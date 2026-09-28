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

// Native dialog keeps the reading surface outside transformed page containers.
const desk = document.querySelector('.letter-desk');
const deskToggle = document.querySelector('.desk-toggle');
const notes = [...document.querySelectorAll('[data-note]')];
const reader = document.querySelector('.note-reader');
const readerPaper = document.querySelector('[data-reader-paper]');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
let selectedNote = 0;
let readerAnimation;
let closingReader = false;
const wrapNote = index => (index + notes.length) % notes.length;
const animatePaper = (frames, duration = 600) => {
    readerAnimation?.cancel();
    if (reducedMotion.matches) return null;
    readerAnimation = readerPaper.animate(frames, { duration, easing: 'cubic-bezier(.18,.8,.22,1)' });
    return readerAnimation;
};
const renderNote = index => {
    selectedNote = wrapNote(index);
    const note = notes[selectedNote];
    readerPaper.dataset.tone = note.dataset.note;
    reader.querySelector('#reader-title').textContent = note.dataset.noteTitle;
    reader.querySelector('[data-reader-index]').textContent = note.querySelector('.desk-card-index').textContent;
    reader.querySelector('[data-reader-message]').textContent = note.querySelector('.desk-message').textContent;
    reader.querySelector('[data-reader-count]').textContent = (selectedNote + 1) + ' / ' + notes.length;
    reader.querySelectorAll('[data-note-step]').forEach(button => {
        const adjacent = notes[wrapNote(selectedNote + Number(button.dataset.noteStep))];
        button.dataset.tone = adjacent.dataset.note;
        button.querySelector('[data-peek-title]').textContent = adjacent.dataset.noteTitle;
        button.setAttribute('aria-label', 'Baca kartu ' + adjacent.dataset.noteTitle);
    });
};
const sourceTransform = note => {
    const source = note.getBoundingClientRect();
    const target = readerPaper.getBoundingClientRect();
    return 'translate(' + (source.x + source.width / 2 - target.x - target.width / 2) + 'px, '
        + (source.y + source.height / 2 - target.y - target.height / 2) + 'px) scale('
        + (source.width / target.width) + ') rotate(-12deg)';
};
const openReader = index => {
    if (!desk.classList.contains('is-open')) return;
    renderNote(index);
    reader.showModal();
    document.body.classList.add('reading-note');
    animatePaper([{ transform: sourceTransform(notes[index]), opacity: .4 }, { transform: 'none', opacity: 1 }], 700);
    reader.querySelector('.reader-close').focus({ preventScroll: true });
};
const closeReader = () => {
    if (!reader?.open || closingReader) return;
    closingReader = true;
    readerAnimation?.cancel();
    const finish = () => {
        reader.close();
        document.body.classList.remove('reading-note');
        closingReader = false;
        notes[selectedNote].focus({ preventScroll: true });
    };
    const animation = animatePaper([{ transform: 'none', opacity: 1 }, { transform: sourceTransform(notes[selectedNote]), opacity: 0 }], 380);
    if (animation) animation.finished.catch(() => {}).then(finish);
    else finish();
};
const turnNote = direction => {
    if (closingReader) return;
    renderNote(selectedNote + direction);
    animatePaper([
        { transform: 'translate(' + direction * 70 + 'px, 20px) rotate(' + direction * 7 + 'deg)', opacity: .15 },
        { transform: 'none', opacity: 1 },
    ], 520);
};
notes.forEach((note, index) => {
    note.disabled = true;
    note.addEventListener('click', () => openReader(index));
});
deskToggle?.addEventListener('click', () => {
    const open = desk.classList.toggle('is-open');
    deskToggle.setAttribute('aria-expanded', String(open));
    deskToggle.querySelector('[data-desk-label]').textContent = open ? 'Fold away' : 'Press play';
    document.querySelector('[data-desk-hint]').textContent = open ? 'Pilih salah satu kartu untuk membaca ceritanya.' : 'Tiga kartu, sedikit cerita. Buka amplopnya.';
    notes.forEach(note => { note.disabled = !open; });
});
reader?.querySelector('.reader-close').addEventListener('click', closeReader);
reader?.querySelectorAll('[data-note-step]').forEach(button => button.addEventListener('click', () => turnNote(Number(button.dataset.noteStep))));
reader?.addEventListener('cancel', event => { event.preventDefault(); closeReader(); });
reader?.addEventListener('click', event => { if (event.target === reader || event.target.classList.contains('reader-stage')) closeReader(); });
reader?.addEventListener('keydown', event => {
    if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
        event.preventDefault();
        turnNote(event.key === 'ArrowRight' ? 1 : -1);
    }
});

document.querySelector('[data-stack-toggle]')?.addEventListener('click', (event) => {
    const button = event.currentTarget;
    const spread = button.closest('.demo-stack').classList.toggle('is-spread');
    button.setAttribute('aria-pressed', String(spread));
    button.querySelector('[data-stack-label]').textContent = spread ? 'Bring them together' : 'Spread the cards';
    button.querySelector('[aria-hidden="true"]').textContent = spread ? '↙' : '↗';
});
document.querySelectorAll('[data-blur-demo]').forEach((demo) => {
    const slider = demo.querySelector('[data-blur]');
    const output = demo.querySelector('[data-blur-value]');
    const presets = [...demo.querySelectorAll('[data-blur-preset]')];
    if (!slider || !output) return;

    const setBlur = (rawValue) => {
        const value = Math.min(Number(slider.max), Math.max(Number(slider.min), Number(rawValue)));
        const progress = ((value - Number(slider.min)) / (Number(slider.max) - Number(slider.min))) * 100;
        slider.value = String(value);
        slider.setAttribute('aria-valuetext', value + ' piksel');
        demo.style.setProperty('--glass-blur', value + 'px');
        demo.style.setProperty('--slider-progress', progress + '%');
        output.textContent = value + ' px';
        presets.forEach((button) => button.setAttribute('aria-pressed', String(Number(button.dataset.blurPreset) === value)));
    };

    slider.addEventListener('input', () => setBlur(slider.value));
    presets.forEach((button) => button.addEventListener('click', () => setBlur(button.dataset.blurPreset)));
    setBlur(slider.value);
});
document.querySelectorAll('[data-aura-choice]').forEach((button) => {
    button.addEventListener('click', () => {
        const demo = button.closest('.demo-aura');
        demo.dataset.aura = button.dataset.auraChoice;
        demo.querySelector('[data-aura-copy]').textContent = button.dataset.auraCopy;
        demo.querySelectorAll('[data-aura-choice]').forEach((choice) => choice.setAttribute('aria-pressed', String(choice === button)));
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
