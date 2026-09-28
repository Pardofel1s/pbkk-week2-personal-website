(() => {
    const navigation = document.querySelector('[data-section-selector]');
    const sections = [...document.querySelectorAll('main [data-page-section][id]')];
    if (!navigation || sections.length < 2) return;

    const links = sections.map((section, index) => {
        const label = section.dataset.sectionLabel || section.querySelector('h1, h2')?.textContent?.trim() || `Section ${index + 1}`;
        const link = document.createElement('a');
        link.href = `#${section.id}`;
        link.dataset.label = label;
        link.setAttribute('aria-label', `Ke bagian ${label}`);
        link.innerHTML = `<span class="section-index" aria-hidden="true">${String(index + 1).padStart(2, '0')}</span><span class="section-name" aria-hidden="true">${label}</span>`;
        navigation.append(link);
        return link;
    });

    navigation.hidden = false;
    document.body.classList.add('has-section-selector');
    const activeSections = new Set();
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) activeSections.add(entry.target);
            else activeSections.delete(entry.target);
        });
        const active = sections
            .filter(section => activeSections.has(section))
            .sort((first, second) => first.getBoundingClientRect().top - second.getBoundingClientRect().top)[0]
            || sections.reduce((nearest, section) => Math.abs(section.getBoundingClientRect().top) < Math.abs(nearest.getBoundingClientRect().top) ? section : nearest, sections[0]);
        const activeIndex = sections.indexOf(active);
        navigation.style.setProperty('--section-progress', `${((activeIndex + 0.5) / sections.length) * 100}%`);
        navigation.dataset.currentSection = sections[activeIndex].dataset.sectionLabel || `Section ${activeIndex + 1}`;
        navigation.dataset.sectionCount = String(sections.length).padStart(2, '0');
        links.forEach((link, index) => {
            if (index === activeIndex) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
    }, { rootMargin: '-22% 0px -55% 0px', threshold: 0 });

    sections.forEach(section => observer.observe(section));
})();
