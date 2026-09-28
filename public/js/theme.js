(() => {
    const root = document.documentElement;
    const system = window.matchMedia('(prefers-color-scheme: dark)');
    const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const valid = theme => theme === 'light' || theme === 'dark';
    const routeMode = new URLSearchParams(window.location.search).get('mode');
    let saved = null;
    try { saved = localStorage.getItem('portfolio-theme'); } catch {}
    let chosen = valid(routeMode) ? routeMode : (valid(window.routeTheme) ? window.routeTheme : (valid(saved) ? saved : null));
    let scene = null;
    let switchTimer = 0;
    let cleanupTimer = 0;

    const updateButton = theme => {
        document.querySelectorAll('.theme-toggle').forEach(button => {
            const dark = theme === 'dark';
            button.setAttribute('aria-pressed', String(dark));
            button.setAttribute('aria-label', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
            const label = button.querySelector('[data-theme-label]');
            if (label) label.textContent = dark ? 'Terang' : 'Gelap';
            const icon = button.querySelector('[data-theme-icon]');
            if (icon) icon.textContent = dark ? '☼' : '◐';
        });
    };

    const apply = theme => {
        root.dataset.theme = theme;
        root.style.colorScheme = theme;
        updateButton(theme);
        document.querySelector('meta[name="theme-color"]')?.setAttribute('content', theme === 'dark' ? '#202820' : '#f7c2a8');
        document.dispatchEvent(new CustomEvent('portfolio:theme-changed', { detail: { theme } }));
    };

    const clearTransition = () => {
        window.clearTimeout(switchTimer);
        window.clearTimeout(cleanupTimer);
        scene?.getAnimations({ subtree: true }).forEach(animation => animation.cancel());
        scene?.remove();
        scene = null;
        root.classList.remove('theme-shifting');
    };

    const transition = theme => {
        clearTransition();
        if (motion.matches || document.hidden || !document.body || typeof Element.prototype.animate !== 'function' || root.dataset.theme === theme) {
            apply(theme);
            return;
        }

        const sunrise = theme === 'light';
        scene = document.createElement('div');
        scene.className = 'theme-sky ' + (sunrise ? 'theme-sky--dawn' : 'theme-sky--dusk');
        scene.setAttribute('aria-hidden', 'true');
        const glow = document.createElement('span');
        glow.className = 'theme-sky__glow';
        const sun = document.createElement('span');
        sun.className = 'theme-sky__sun';
        const horizon = document.createElement('span');
        horizon.className = 'theme-sky__horizon';
        scene.append(glow, sun, horizon);
        document.body.append(scene);
        root.classList.add('theme-shifting');

        scene.animate([
            { opacity: 0 },
            { opacity: 1, offset: .25 },
            { opacity: 1, offset: .65 },
            { opacity: 0 },
        ], { duration: 1150, easing: 'ease-in-out', fill: 'both' });
        sun.animate([
            { transform: sunrise ? 'translate(-50%, 45vh) scale(.7)' : 'translate(-50%, -12vh) scale(1)' },
            { transform: sunrise ? 'translate(-50%, -12vh) scale(1)' : 'translate(-50%, 45vh) scale(.7)' },
        ], { duration: 1080, easing: 'cubic-bezier(.35,0,.25,1)', fill: 'both' });
        glow.animate([
            { opacity: .1, transform: 'translate(-50%, 25%) scale(.8)' },
            { opacity: .7, transform: 'translate(-50%, 0) scale(1.05)', offset: .5 },
            { opacity: 0, transform: 'translate(-50%, 10%) scale(1.15)' },
        ], { duration: 1150, easing: 'ease-in-out', fill: 'both' });

        switchTimer = window.setTimeout(() => apply(theme), 430);
        cleanupTimer = window.setTimeout(clearTransition, 1200);
    };

    // Resolve the URL before stored preference, before the first paint.
    apply(chosen ?? (system.matches ? 'dark' : 'light'));

    const bindControls = () => {
        updateButton(root.dataset.theme);
        document.querySelector('meta[name="theme-color"]')?.setAttribute('content', root.dataset.theme === 'dark' ? '#202820' : '#f7c2a8');
        document.querySelectorAll('.theme-toggle').forEach(button => {
            button.addEventListener('click', () => {
                chosen = (chosen ?? root.dataset.theme) === 'dark' ? 'light' : 'dark';
                try { localStorage.setItem('portfolio-theme', chosen); } catch {}
                transition(chosen);
            });
        });
    };

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bindControls, { once: true });
    else bindControls();

    system.addEventListener('change', () => {
        if (chosen) return;
        clearTransition();
        apply(system.matches ? 'dark' : 'light');
    });
    motion.addEventListener('change', () => {
        if (!motion.matches) return;
        clearTransition();
        apply(chosen ?? (system.matches ? 'dark' : 'light'));
    });
    window.addEventListener('pagehide', clearTransition);
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden || !scene) return;
        clearTransition();
        apply(chosen ?? (system.matches ? 'dark' : 'light'));
    });
})();
