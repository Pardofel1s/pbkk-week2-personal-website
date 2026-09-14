(() => {
    const root = document.documentElement;
    const system = window.matchMedia('(prefers-color-scheme: dark)');
    let chosen = null;
    try { chosen = localStorage.getItem('portfolio-theme'); } catch {}
    const apply = theme => {
        root.dataset.theme = theme;
        root.style.colorScheme = theme;
        const button = document.querySelector('.theme-toggle');
        if (button) {
            const dark = theme === 'dark';
            button.setAttribute('aria-pressed', String(dark));
            button.setAttribute('aria-label', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
            button.querySelector('[data-theme-label]').textContent = dark ? 'Terang' : 'Gelap';
        }
        document.querySelector('meta[name="theme-color"]')?.setAttribute('content', theme === 'dark' ? '#171b19' : '#fff8f2');
    };
    apply(['light', 'dark'].includes(chosen) ? chosen : (system.matches ? 'dark' : 'light'));
    document.addEventListener('DOMContentLoaded', () => {
        apply(root.dataset.theme);
        document.querySelector('.theme-toggle')?.addEventListener('click', () => {
            chosen = root.dataset.theme === 'dark' ? 'light' : 'dark';
            try { localStorage.setItem('portfolio-theme', chosen); } catch {}
            apply(chosen);
        });
    });
    system.addEventListener('change', () => { if (!chosen) apply(system.matches ? 'dark' : 'light'); });
})();
