(() => {
    const playerShell = document.querySelector('[data-music-player]');
    if (!playerShell) return;

    const brand = playerShell.querySelector('.brand');
    const popover = playerShell.querySelector('.music-popover');

    const setOpen = isOpen => {
        popover.hidden = !isOpen;
        brand.setAttribute('aria-expanded', String(isOpen));
    };

    brand.addEventListener('click', () => setOpen(popover.hidden));

    document.addEventListener('click', event => {
        if (!popover.hidden && !playerShell.contains(event.target)) setOpen(false);
    });

    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && !popover.hidden) {
            setOpen(false);
            brand.focus();
            return;
        }

        const isTyping = event.target instanceof HTMLElement
            && (event.target.isContentEditable || ['INPUT', 'TEXTAREA', 'SELECT'].includes(event.target.tagName));
        if (event.key.toLowerCase() === 'k' && !event.altKey && !event.ctrlKey && !event.metaKey && !isTyping) {
            event.preventDefault();
            setOpen(popover.hidden);
            if (!popover.hidden) brand.focus();
        }
    });
})();
