(() => {
    const main = document.querySelector('#main-content');
    if (!main || !window.fetch || !window.history.pushState) return;

    let requestController;
    let scrollFrame = 0;

    const updateHistoryScroll = () => {
        scrollFrame = 0;
        window.history.replaceState({ ...window.history.state, portfolioNavigation: true, scrollY: window.scrollY }, '', window.location.href);
    };

    const isSameOriginPage = url => url.origin === window.location.origin && !/\.[a-z0-9]{1,8}$/i.test(url.pathname);

    const syncPageChrome = nextDocument => {
        document.title = nextDocument.title;
        document.body.className = nextDocument.body.className;

        const nextDescription = nextDocument.querySelector('meta[name="description"]');
        const description = document.querySelector('meta[name="description"]');
        if (nextDescription && description) description.content = nextDescription.content;

        const currentLinks = [...document.querySelectorAll('#main-nav a')];
        const nextLinks = [...nextDocument.querySelectorAll('#main-nav a')];
        currentLinks.forEach((link, index) => {
            const active = nextLinks[index]?.getAttribute('aria-current');
            if (active) link.setAttribute('aria-current', active);
            else link.removeAttribute('aria-current');
        });

        const currentSelector = document.querySelector('[data-section-selector]');
        const nextSelector = nextDocument.querySelector('[data-section-selector]');
        if (currentSelector && nextSelector) currentSelector.replaceWith(nextSelector);
        else if (currentSelector) currentSelector.remove();
        else if (nextSelector) document.querySelector('.site-frame')?.append(nextSelector);
    };

    const loadPage = async (destination, { historyMode = 'push', scrollY = 0, method = 'GET', body } = {}) => {
        const url = new URL(destination, window.location.href);
        if (!isSameOriginPage(url)) {
            window.location.assign(url.href);
            return;
        }

        requestController?.abort();
        requestController = new AbortController();
        document.documentElement.classList.add('page-navigation-pending');

        try {
            const response = await window.fetch(url.href, {
                method,
                body,
                credentials: 'same-origin',
                headers: { Accept: 'text/html', 'X-Requested-With': 'XMLHttpRequest' },
                signal: requestController.signal,
            });
            if (response.status >= 500 || !response.headers.get('content-type')?.includes('text/html')) {
                window.location.assign(url.href);
                return;
            }

            const finalUrl = new URL(response.url || url.href, window.location.href);
            if (finalUrl.origin !== window.location.origin) {
                window.location.assign(finalUrl.href);
                return;
            }

            const nextDocument = new DOMParser().parseFromString(await response.text(), 'text/html');
            const nextMain = nextDocument.querySelector('#main-content');
            if (!nextMain) {
                window.location.assign(url.href);
                return;
            }

            main.replaceChildren(...Array.from(nextMain.childNodes));
            syncPageChrome(nextDocument);

            if (historyMode === 'push') {
                window.history.pushState({ portfolioNavigation: true, scrollY: 0 }, '', finalUrl.href);
            } else if (historyMode === 'replace') {
                window.history.replaceState({ portfolioNavigation: true, scrollY }, '', finalUrl.href);
            }

            window.scrollTo(0, scrollY);
            document.dispatchEvent(new CustomEvent('portfolio:navigated', {
                detail: { url: finalUrl.href, routeTheme: finalUrl.searchParams.get('mode') },
            }));
            main.focus({ preventScroll: true });
        } catch (error) {
            if (error.name !== 'AbortError') window.location.assign(url.href);
        } finally {
            document.documentElement.classList.remove('page-navigation-pending');
        }
    };

    const submitForm = (form, submitter) => {
        const method = (form.method || 'GET').toUpperCase();
        if (!['GET', 'POST'].includes(method) || form.target || form.querySelector('input[type="file"]')) return false;

        const url = new URL(form.action || window.location.href, window.location.href);
        if (!isSameOriginPage(url)) return false;

        const data = new FormData(form);
        if (submitter?.name) data.append(submitter.name, submitter.value);

        if (method === 'GET') {
            for (const [key, value] of data.entries()) {
                if (typeof value === 'string') url.searchParams.append(key, value);
            }
            loadPage(url.href);
        } else {
            loadPage(url.href, { method, body: data });
        }

        return true;
    };

    document.addEventListener('click', event => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        const link = event.target.closest('a[href]');
        if (!link || link.target || link.hasAttribute('download') || link.relList.contains('external')) return;

        const url = new URL(link.href, window.location.href);
        if (!isSameOriginPage(url) || url.href === window.location.href || (url.pathname === window.location.pathname && url.search === window.location.search && url.hash)) return;

        event.preventDefault();
        window.history.replaceState({ ...window.history.state, portfolioNavigation: true, scrollY: window.scrollY }, '', window.location.href);
        loadPage(url.href);
    });

    document.addEventListener('submit', event => {
        if (!(event.target instanceof HTMLFormElement) || event.defaultPrevented) return;
        if (!submitForm(event.target, event.submitter)) return;
        event.preventDefault();
    });

    window.addEventListener('popstate', event => {
        loadPage(window.location.href, { historyMode: 'none', scrollY: event.state?.scrollY ?? 0 });
    });

    window.addEventListener('scroll', () => {
        if (!scrollFrame) scrollFrame = window.requestAnimationFrame(updateHistoryScroll);
    }, { passive: true });

    window.history.replaceState({ ...window.history.state, portfolioNavigation: true, scrollY: window.scrollY }, '', window.location.href);
})();
