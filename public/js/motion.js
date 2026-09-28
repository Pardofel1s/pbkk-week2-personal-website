(() => {
    const root = document.documentElement;
    const preference = window.matchMedia('(prefers-reduced-motion: reduce)');
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
    const trail = document.querySelector('.pointer-trail');
    const progress = document.querySelector('.reading-progress');
    const activeAnimations = new Set();
    const visited = new WeakSet();
    const sparks = new Set();
    const tiltCards = document.querySelectorAll('[data-tilt], .project-preview, .collection-visual');
    let observer;
    let enabled = false;
    let frame = 0;
    let lastTrail = null;
    let lastTrailTime = 0;

    const animate = (element, keyframes, options = {}) => {
        if (!enabled || !element || typeof element.animate !== 'function') return null;

        const animation = element.animate(keyframes, {
            duration: 700,
            easing: 'cubic-bezier(.16,1,.3,1)',
            ...options,
        });
        activeAnimations.add(animation);
        const cleanup = () => activeAnimations.delete(animation);
        animation.addEventListener('finish', cleanup, { once: true });
        animation.addEventListener('cancel', cleanup, { once: true });
        return animation;
    };

    const reveal = (element, index = 0) => animate(element, [
        { opacity: 0, transform: 'translateY(22px)' },
        { opacity: 1, transform: 'translateY(0)' },
    ], { delay: Math.min(index, 4) * 55, fill: 'backwards' });

    const clearTrail = () => {
        sparks.forEach(spark => {
            spark.getAnimations().forEach(animation => animation.cancel());
            spark.remove();
        });
        sparks.clear();
        lastTrail = null;
    };

    const updateProgress = () => {
        frame = 0;
        if (!progress) return;
        const distance = root.scrollHeight - window.innerHeight;
        const fraction = distance > 0 ? Math.min(1, Math.max(0, window.scrollY / distance)) : 0;
        progress.style.transform = 'scaleX(' + fraction + ')';
    };

    const queueProgress = () => {
        if (!frame) frame = requestAnimationFrame(updateProgress);
    };

    const configure = () => {
        enabled = !preference.matches;
        root.classList.toggle('motion-on', enabled);
        observer?.disconnect();
        clearTrail();
        if (!enabled) {
            activeAnimations.forEach(animation => animation.cancel());
            activeAnimations.clear();
            tiltCards.forEach(card => {
                card.style.removeProperty('--tilt-x');
                card.style.removeProperty('--tilt-y');
            });
            return;
        }

        updateProgress();
        if ('IntersectionObserver' in window) {
            observer = new IntersectionObserver(entries => {
                entries.forEach((entry, index) => {
                    if (!entry.isIntersecting || visited.has(entry.target)) return;
                    visited.add(entry.target);
                    reveal(entry.target, index);
                    observer.unobserve(entry.target);
                });
            }, { threshold: .08 });

            document.querySelectorAll('[data-reveal], .section-heading, .showcase-card, .about-strip > div, .chapter-section, .project-card, .collection-card, .blog-row, .concept-grid article, .agent-flow > div, .contact-letter, .contact-details, .academic-poster, .prose-block, .article-body section').forEach(element => {
                if (!visited.has(element)) observer.observe(element);
            });
        }
    };

    preference.addEventListener('change', configure);
    finePointer.addEventListener('change', clearTrail);
    configure();

    // A brief pen stroke follows the hand; no image stamps or persistent cursor follower.
    if (trail) {
        document.addEventListener('pointermove', event => {
            if (!enabled || !finePointer.matches || event.pointerType === 'touch' || document.hidden) return;
            if (event.buttons || event.target.closest('input, textarea, [contenteditable="true"]')) {
                lastTrail = null;
                return;
            }

            const now = performance.now();
            const point = { x: event.clientX, y: event.clientY };
            if (!lastTrail) {
                lastTrail = point;
                return;
            }

            const dx = point.x - lastTrail.x;
            const dy = point.y - lastTrail.y;
            if (Math.hypot(dx, dy) < 17 || now - lastTrailTime < 38) return;
            const angle = Math.atan2(dy, dx) * 180 / Math.PI;
            lastTrail = point;
            lastTrailTime = now;

            while (sparks.size >= 12) {
                const oldest = sparks.values().next().value;
                oldest.getAnimations().forEach(animation => animation.cancel());
                oldest.remove();
                sparks.delete(oldest);
            }

            const dark = root.dataset.theme === 'dark';
            const spark = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            spark.classList.add('cursor-mark');
            spark.classList.add(dark ? 'cursor-mark--night' : 'cursor-mark--ink');
            spark.setAttribute('viewBox', '0 0 20 20');
            spark.setAttribute('aria-hidden', 'true');
            spark.style.left = point.x + 'px';
            spark.style.top = point.y + 'px';
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('d', dark ? 'M10 5V15M5 10H15' : 'M3 13C7 5 13 5 17 9');
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke', 'currentColor');
            path.setAttribute('stroke-width', dark ? '1' : '1.35');
            path.setAttribute('stroke-linecap', 'round');
            spark.append(path);
            trail.append(spark);
            sparks.add(spark);

            const rotation = dark ? 45 : angle;
            const animation = animate(spark, [
                { opacity: 0, transform: 'translate(-50%, -50%) rotate(' + rotation + 'deg) scale(.6)', offset: 0 },
                { opacity: dark ? .5 : .62, transform: 'translate(-50%, -50%) rotate(' + rotation + 'deg) scale(1)', offset: .2 },
                { opacity: 0, transform: 'translate(-50%, 5px) rotate(' + (rotation + 18) + 'deg) scale(.8)', offset: 1 },
            ], { duration: dark ? 620 : 540, easing: 'ease-out' });

            const remove = () => {
                spark.remove();
                sparks.delete(spark);
            };
            if (animation) {
                animation.addEventListener('finish', remove, { once: true });
                animation.addEventListener('cancel', remove, { once: true });
            } else {
                remove();
            }
        }, { passive: true });
    }

    document.querySelectorAll('.hero-copy > *, .page-heading > *, .article-page header > *').forEach((element, index) => {
        visited.add(element);
        reveal(element, index);
    });
    animate(document.querySelector('.header-rule'), [
        { transform: 'scaleX(0)', transformOrigin: 'left' },
        { transform: 'scaleX(1)', transformOrigin: 'left' },
    ], { duration: 900 });
    animate(document.querySelector('.result-number'), [
        { opacity: 0, transform: 'translateY(15px) scale(.96)' },
        { opacity: 1, transform: 'translateY(0) scale(1)' },
    ], { duration: 750 });

    tiltCards.forEach(card => {
        let tiltFrame = 0;
        const reset = () => {
            cancelAnimationFrame(tiltFrame);
            card.style.removeProperty('--tilt-x');
            card.style.removeProperty('--tilt-y');
        };
        card.addEventListener('pointermove', event => {
            if (!enabled || !finePointer.matches || event.pointerType === 'touch') return;
            const rect = card.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width - .5;
            const y = (event.clientY - rect.top) / rect.height - .5;
            cancelAnimationFrame(tiltFrame);
            tiltFrame = requestAnimationFrame(() => {
                card.style.setProperty('--tilt-x', (-y * 5).toFixed(2) + 'deg');
                card.style.setProperty('--tilt-y', (x * 5).toFixed(2) + 'deg');
            });
        });
        card.addEventListener('pointerleave', reset);
        card.addEventListener('pointercancel', reset);
        card.addEventListener('blur', reset, true);
    });

    document.addEventListener('portfolio:filtered', event => {
        document.querySelectorAll('[data-filter-item]').forEach((item, index) => {
            if (item.hidden || item.dataset.filterItem !== event.detail.group) return;
            visited.add(item);
            observer?.unobserve(item);
            reveal(item, index);
        });
    });
    document.addEventListener('portfolio:theme-changed', clearTrail);
    document.documentElement.addEventListener('pointerleave', clearTrail);
    window.addEventListener('blur', clearTrail);
    window.addEventListener('pagehide', clearTrail);
    window.addEventListener('scroll', queueProgress, { passive: true });
    window.addEventListener('resize', queueProgress, { passive: true });
    window.addEventListener('pageshow', queueProgress);
    document.addEventListener('visibilitychange', () => {
        root.classList.toggle('motion-suspended', document.hidden);
        if (document.hidden) clearTrail();
        activeAnimations.forEach(animation => document.hidden ? animation.pause() : animation.play());
    });
})();
