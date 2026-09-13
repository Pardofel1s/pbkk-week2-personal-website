document.documentElement.classList.add('js');

// Mobile navigation remains visible if JavaScript is unavailable.
const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('#main-nav');
const closeMenu = () => {
    nav?.classList.remove('is-open');
    toggle?.setAttribute('aria-expanded', 'false');
};
toggle?.addEventListener('click', () => {
    const open = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', String(open));
});
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && nav?.classList.contains('is-open')) {
        closeMenu();
        toggle.focus();
    }
});
nav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));

const envelopeToggle = document.querySelector('.envelope-toggle');
envelopeToggle?.addEventListener('click', () => {
    const open = document.querySelector('.envelope').classList.toggle('is-open');
    envelopeToggle.setAttribute('aria-expanded', String(open));
    envelopeToggle.setAttribute('aria-label', open ? 'Tutup kartu showcase' : 'Buka kartu showcase');
});
document.querySelector('[data-stack-toggle]')?.addEventListener('click', (event) => {
    const button = event.currentTarget;
    const spread = button.closest('.demo-stack').classList.toggle('is-spread');
    button.setAttribute('aria-pressed', String(spread));
    button.textContent = spread ? 'Bring them together ↙' : 'Spread the cards ↗';
});
document.querySelector('[data-blur]')?.addEventListener('input', (event) => {
    const value = event.target.value;
    event.target.closest('.demo-glass').style.setProperty('--glass-blur', value + 'px');
    document.querySelector('[data-blur-value]').textContent = value + ' px';
});
document.querySelectorAll('[data-aura-choice]').forEach((button) => {
    button.addEventListener('click', () => {
        button.closest('.demo-aura').dataset.aura = button.dataset.auraChoice;
        document.querySelectorAll('[data-aura-choice]').forEach((choice) => choice.setAttribute('aria-pressed', String(choice === button)));
    });
});

// Collection categories and blog search combine without changing the URL.
document.querySelectorAll('[data-filter-group]').forEach((group) => {
    const name = group.dataset.filterGroup;
    const items = [...document.querySelectorAll('[data-filter-item="' + name + '"]')];
    const search = document.querySelector('[data-search="' + name + '"]');
    const count = document.querySelector('[data-count="' + name + '"]');
    const empty = document.querySelector('[data-empty="' + name + '"]');
    let selected = 'All';
    const update = () => {
        const query = (search?.value ?? '').toLocaleLowerCase('id').trim();
        let visible = 0;
        items.forEach((item) => {
            const matches = (selected === 'All' || item.dataset.category === selected)
                && (item.dataset.searchText ?? item.textContent).toLocaleLowerCase('id').includes(query);
            item.hidden = !matches;
            if (matches) visible += 1;
        });
        if (count) count.textContent = visible + (name === 'blog' ? ' catatan' : ' items');
        if (empty) empty.hidden = visible !== 0;
        document.dispatchEvent(new CustomEvent('portfolio:filtered', { detail: { group: name } }));
    };
    group.querySelectorAll('[data-filter]').forEach((button) => {
        button.addEventListener('click', () => {
            selected = button.dataset.filter;
            group.querySelectorAll('[data-filter]').forEach((choice) => choice.setAttribute('aria-pressed', String(choice === button)));
            update();
        });
    });
    search?.addEventListener('input', update);
});
document.querySelector('[data-copy-url]')?.addEventListener('click', async () => {
    const feedback = document.querySelector('.copy-feedback');
    try {
        await navigator.clipboard.writeText(window.location.href);
        feedback.textContent = 'Tautan hasil berhasil disalin.';
    } catch {
        feedback.textContent = 'Belum bisa menyalin otomatis. Salin alamat dari address bar browser.';
    }
});
