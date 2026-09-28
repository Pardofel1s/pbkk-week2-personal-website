(() => {
    const canvas = document.querySelector('[data-dream-sky]');
    const context = canvas?.getContext('2d', { alpha: true });
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const coarsePointer = window.matchMedia('(pointer: coarse)');

    if (!canvas || !context) return;

    const particles = [];
    const flares = [];
    const palettes = {
        light: ['#ff7865', '#fba28c', '#4e8057', '#d7a86e'],
        dark: ['#f6ad91', '#d78672', '#9ab18d', '#e2bd8d'],
    };
    let width = 0;
    let height = 0;
    let pixelRatio = 1;
    let animationFrame = 0;
    let lastFrame = 0;
    let nextTimer = 0;
    let introTimers = [];

    const randomBetween = (minimum, maximum) => minimum + Math.random() * (maximum - minimum);
    const palette = () => palettes[document.documentElement.dataset.theme === 'dark' ? 'dark' : 'light'];

    const resize = () => {
        pixelRatio = Math.min(window.devicePixelRatio || 1, 1.5);
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = Math.round(width * pixelRatio);
        canvas.height = Math.round(height * pixelRatio);
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';
        context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
    };

    const draw = (now) => {
        animationFrame = 0;
        if (document.hidden || reducedMotion.matches) return;

        const delta = Math.min((now - (lastFrame || now)) / 16.67, 2);
        lastFrame = now;
        context.clearRect(0, 0, width, height);
        context.globalCompositeOperation = 'lighter';

        for (let index = flares.length - 1; index >= 0; index -= 1) {
            const flare = flares[index];
            flare.life -= 16.67 * delta;
            if (flare.life <= 0) {
                flares.splice(index, 1);
                continue;
            }

            const progress = 1 - flare.life / flare.duration;
            const alpha = Math.min(1, flare.life / 180) * 0.48;
            const radius = 2 + progress * 7;
            context.globalAlpha = alpha;
            context.strokeStyle = flare.color;
            context.shadowColor = flare.color;
            context.shadowBlur = 9;
            context.lineWidth = 0.8;
            context.beginPath();
            context.arc(flare.x, flare.y, radius, 0, Math.PI * 2);
            context.stroke();
            context.beginPath();
            for (let ray = 0; ray < 8; ray += 1) {
                const angle = (Math.PI * 2 * ray) / 8;
                context.moveTo(flare.x + Math.cos(angle) * radius * 0.35, flare.y + Math.sin(angle) * radius * 0.35);
                context.lineTo(flare.x + Math.cos(angle) * (radius + 5), flare.y + Math.sin(angle) * (radius + 5));
            }
            context.stroke();
        }

        for (let index = particles.length - 1; index >= 0; index -= 1) {
            const particle = particles[index];
            particle.x += particle.vx * delta;
            particle.y += particle.vy * delta;
            particle.vy += 0.012 * delta;
            particle.life -= 16.67 * delta;

            if (particle.life <= 0) {
                particles.splice(index, 1);
                continue;
            }

            const opacity = Math.min(1, particle.life / 430) * 0.56;
            context.globalAlpha = opacity;
            context.strokeStyle = particle.color;
            context.fillStyle = particle.color;
            context.lineWidth = particle.size * 0.55;
            context.shadowColor = particle.color;
            context.shadowBlur = document.documentElement.dataset.theme === 'dark' ? 8 : 5;
            context.beginPath();
            context.moveTo(particle.x - particle.vx * 3.5, particle.y - particle.vy * 3.5);
            context.lineTo(particle.x, particle.y);
            context.stroke();
            context.beginPath();
            context.arc(particle.x, particle.y, particle.size * 0.58, 0, Math.PI * 2);
            context.fill();
        }

        context.globalAlpha = 1;
        context.globalCompositeOperation = 'source-over';
        context.shadowBlur = 0;
        if (particles.length || flares.length) animationFrame = window.requestAnimationFrame(draw);
    };

    const animateParticles = () => {
        if (!animationFrame && !document.hidden && !reducedMotion.matches) {
            lastFrame = 0;
            animationFrame = window.requestAnimationFrame(draw);
        }
    };

    const burst = (x, y, intensity = 1) => {
        if (document.hidden || reducedMotion.matches) return;

        const colors = palette();
        const count = (coarsePointer.matches ? 17 : 25) * intensity;
        const speedScale = coarsePointer.matches ? 0.82 : 1;
        const color = colors[Math.floor(Math.random() * colors.length)];
        flares.push({ x, y, life: 520, duration: 520, color });

        for (let index = 0; index < count; index += 1) {
            const angle = (Math.PI * 2 * index) / count + randomBetween(-0.08, 0.08);
            const speed = randomBetween(0.85, 2.15) * speedScale * intensity;
            particles.push({
                x,
                y,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed,
                life: randomBetween(850, 1320),
                color: colors[index % colors.length],
                size: randomBetween(1, 1.8) * (coarsePointer.matches ? 0.85 : 1),
            });
        }

        animateParticles();
    };

    const scheduleBurst = () => {
        window.clearTimeout(nextTimer);
        nextTimer = window.setTimeout(() => {
            if (!document.hidden && !reducedMotion.matches) {
                const margin = 44;
                burst(randomBetween(margin, Math.max(margin + 1, width - margin)), randomBetween(height * 0.16, height * 0.82), 0.9);
            }
            scheduleBurst();
        }, randomBetween(4300, 6800));
    };

    const start = () => {
        if (reducedMotion.matches || document.hidden) return;

        introTimers = [
            window.setTimeout(() => burst(width * 0.79, height * 0.23, 1.1), 520),
            window.setTimeout(() => burst(width * 0.16, height * 0.66, 0.85), 1220),
            window.setTimeout(() => burst(width * 0.68, height * 0.78, 0.9), 1960),
        ];
        scheduleBurst();
    };

    const stop = () => {
        window.clearTimeout(nextTimer);
        introTimers.forEach(window.clearTimeout);
        introTimers = [];
        if (animationFrame) window.cancelAnimationFrame(animationFrame);
        animationFrame = 0;
        particles.length = 0;
        flares.length = 0;
        context.clearRect(0, 0, width, height);
    };

    resize();
    start();
    window.addEventListener('resize', resize, { passive: true });
    document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());
    reducedMotion.addEventListener('change', () => reducedMotion.matches ? stop() : start());
})();
