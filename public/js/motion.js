(() => {
    const root = document.documentElement;
    const preference = window.matchMedia('(prefers-reduced-motion: reduce)');
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
    const toggle = document.querySelector('[data-motion-toggle]');
    const progress = document.querySelector('.reading-progress');
    const activeAnimations = new Set();
    const visited = new WeakSet();
    let observer;
    let enabled = false;
    let frame = 0;
    let stored = 'on';
    try { stored = localStorage.getItem('portfolio-motion') || 'on'; } catch { /* Storage is optional. */ }

    const animate = (element, keyframes, options = {}) => {
        if (!enabled || !element || typeof element.animate !== 'function') return;
        const animation = element.animate(keyframes, { duration: 650, easing: 'cubic-bezier(.2,.7,.2,1)', ...options });
        activeAnimations.add(animation);
        const cleanup = () => activeAnimations.delete(animation);
        animation.addEventListener('finish', cleanup, { once: true });
        animation.addEventListener('cancel', cleanup, { once: true });
    };
    const reveal = (element, index = 0) => animate(element, [
        { opacity: 0, transform: 'translateY(24px)' },
        { opacity: 1, transform: 'translateY(0)' },
    ], { delay: (index % 3) * 65, fill: 'backwards' });

    const updateProgress = () => {
        frame = 0;
        if (!enabled) return;
        const distance = root.scrollHeight - window.innerHeight;
        progress.style.transform = 'scaleX(' + (distance > 0 ? Math.min(1, Math.max(0, window.scrollY / distance)) : 0) + ')';
    };
    const queueProgress = () => {
        if (enabled && !frame) frame = requestAnimationFrame(updateProgress);
    };
    const configure = () => {
        enabled = stored !== 'off' && !preference.matches;
        root.classList.toggle('motion-on', enabled);
        toggle.hidden = false;
        toggle.disabled = preference.matches;
        toggle.setAttribute('aria-pressed', String(enabled));
        toggle.textContent = preference.matches ? 'Reduced motion' : 'Animations: ' + (enabled ? 'on' : 'off');
        toggle.title = preference.matches ? 'Mengikuti pengaturan reduced motion perangkat.' : 'Aktifkan atau hentikan animasi website.';
        observer?.disconnect();
        if (!enabled) {
            activeAnimations.forEach(animation => animation.cancel());
            activeAnimations.clear();
            document.querySelectorAll('.motion-ripple').forEach(ripple => ripple.remove());
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
            document.querySelectorAll('.section-heading, .showcase-card, .about-strip > div, .chapter-section, .project-card, .collection-card, .blog-row, .concept-grid article, .agent-flow > div, .contact-letter, .contact-details, .academic-poster, .prose-block, .article-body section').forEach(element => {
                if (!visited.has(element)) observer.observe(element);
            });
        }
    };

    toggle?.addEventListener('click', () => {
        stored = enabled ? 'off' : 'on';
        try { localStorage.setItem('portfolio-motion', stored); } catch { /* In-memory preference still works. */ }
        configure();
    });
    preference.addEventListener('change', configure);
    configure();
    document.querySelectorAll('.hero-copy > *, .page-heading > *, .article-page header > *').forEach((element, index) => reveal(element, index));
    animate(document.querySelector('.header-rule'), [{ transform: 'scaleX(0)', transformOrigin: 'left' }, { transform: 'scaleX(1)', transformOrigin: 'left' }], { duration: 1000 });
    animate(document.querySelector('.result-number'), [{ opacity: 0, transform: 'translateY(15px) scale(.94)' }, { opacity: 1, transform: 'translateY(0) scale(1)' }], { duration: 750 });

    document.querySelectorAll('.project-preview, .collection-visual').forEach(card => {
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
                card.style.setProperty('--tilt-x', (-y * 7).toFixed(2) + 'deg');
                card.style.setProperty('--tilt-y', (x * 7).toFixed(2) + 'deg');
            });
        });
        card.addEventListener('pointerleave', reset);
        card.addEventListener('pointercancel', reset);
    });
    document.addEventListener('click', event => {
        const button = event.target.closest('.pill-button, .contact-link, .brand, .demo-action');
        if (!enabled || !button || event.detail === 0) return;
        const rect = button.getBoundingClientRect();
        const ripple = document.createElement('span');
        ripple.className = 'motion-ripple';
        ripple.setAttribute('aria-hidden', 'true');
        ripple.style.left = event.clientX - rect.left + 'px';
        ripple.style.top = event.clientY - rect.top + 'px';
        button.append(ripple);
        ripple.addEventListener('animationend', () => ripple.remove(), { once: true });
        setTimeout(() => ripple.remove(), 1000);
    });
    document.addEventListener('portfolio:filtered', event => {
        document.querySelectorAll('[data-filter-item="' + event.detail.group + '"]:not([hidden])').forEach((item, index) => {
            visited.add(item);
            observer?.unobserve(item);
            reveal(item, index);
        });
    });
    window.addEventListener('scroll', queueProgress, { passive: true });
    window.addEventListener('resize', queueProgress, { passive: true });
    document.addEventListener('visibilitychange', () => {
        root.classList.toggle('motion-suspended', document.hidden);
        activeAnimations.forEach(animation => document.hidden ? animation.pause() : animation.play());
    });
    window.addEventListener('pageshow', queueProgress);
})();
