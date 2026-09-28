(() => {
    const playerShell = document.querySelector('[data-music-player]');
    if (!playerShell) return;

    const brand = playerShell.querySelector('.brand');
    const popover = playerShell.querySelector('.music-popover');
    const frame = playerShell.querySelector('[data-music-widget]');
    const status = playerShell.querySelector('[data-music-status]');
    const toggle = playerShell.querySelector('[data-music-toggle]');
    const playIcon = playerShell.querySelector('[data-music-play-icon]');
    const seek = playerShell.querySelector('[data-music-seek]');
    const currentTime = playerShell.querySelector('[data-music-current]');
    const durationTime = playerShell.querySelector('[data-music-duration]');
    const inlineProgress = playerShell.querySelector('[data-music-inline-progress]');
    let playerLoaded = false;
    let widgetReady = false;
    let widget;
    let apiPromise;
    let isPlaying = false;
    let duration = 0;

    const formatTime = milliseconds => {
        const seconds = Math.floor(Math.max(0, milliseconds) / 1000);
        return Math.floor(seconds / 60) + ':' + String(seconds % 60).padStart(2, '0');
    };

    const setPlaybackState = playing => {
        isPlaying = playing;
        toggle.setAttribute('aria-pressed', String(playing));
        toggle.setAttribute('aria-label', playing ? 'Jeda lagu' : 'Putar lagu');
        playIcon.textContent = playing ? 'Ⅱ' : '▶';
        playerShell.dataset.playing = String(playing);
    };

    frame.addEventListener('load', () => {
        if (!widgetReady) status.textContent = 'Gunakan waveform SoundCloud di bawah jika kontrol kustom masih dimuat.';
    });

    const updateProgress = (position, relativePosition) => {
        const progress = Number.isFinite(relativePosition) ? Math.max(0, Math.min(1, relativePosition)) : 0;
        const safePosition = Number.isFinite(position) ? position : 0;
        currentTime.textContent = formatTime(safePosition);
        seek.value = String(Math.round(progress * Number(seek.max)));
        seek.setAttribute('aria-valuetext', formatTime(safePosition) + ' dari ' + formatTime(duration));
        inlineProgress.style.transform = 'scaleX(' + progress + ')';
    };

    const loadWidgetApi = () => {
        if (window.SC?.Widget) return Promise.resolve(window.SC);
        if (apiPromise) return apiPromise;

        apiPromise = new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://w.soundcloud.com/player/api.js';
            script.async = true;
            const timeout = window.setTimeout(() => {
                script.remove();
                reject(new Error('SoundCloud controls took too long to load.'));
            }, 8000);
            script.onload = () => {
                window.clearTimeout(timeout);
                window.SC?.Widget ? resolve(window.SC) : reject(new Error('SoundCloud controls are unavailable.'));
            };
            script.onerror = () => {
                window.clearTimeout(timeout);
                reject(new Error('SoundCloud controls could not be loaded.'));
            };
            document.head.append(script);
        });

        apiPromise = apiPromise.catch(error => {
            apiPromise = undefined;
            throw error;
        });

        return apiPromise;
    };

    const connectWidget = async () => {
        if (!playerLoaded) {
            frame.loading = 'eager';
            frame.src = frame.dataset.src;
            frame.removeAttribute('data-src');
            playerLoaded = true;
        }

        try {
            const soundcloud = await loadWidgetApi();
            widget = soundcloud.Widget(frame);
            const events = soundcloud.Widget.Events;

            widget.bind(events.READY, () => {
                widgetReady = true;
                toggle.disabled = false;
                seek.disabled = false;
                status.textContent = 'Pemutar siap. Tekan ▶ untuk mulai; musik akan tetap berjalan saat panel ditutup.';
                widget.getDuration(milliseconds => {
                    duration = milliseconds;
                    durationTime.textContent = formatTime(duration);
                });
                widget.isPaused(paused => setPlaybackState(!paused));
            });
            widget.bind(events.PLAY, () => setPlaybackState(true));
            widget.bind(events.PAUSE, () => setPlaybackState(false));
            widget.bind(events.FINISH, () => {
                setPlaybackState(false);
                updateProgress(0, 0);
            });
            widget.bind(events.PLAY_PROGRESS, event => {
                updateProgress(event.currentPosition, event.relativePosition);
            });
            widget.bind(events.ERROR, () => {
                status.textContent = 'Pemutar sedang bermasalah. Coba tombol pada waveform SoundCloud.';
            });
        } catch {
            status.textContent = 'Gunakan tombol pada pemutar SoundCloud di bawah untuk mendengarkan.';
        }
    };

    const setOpen = isOpen => {
        popover.hidden = !isOpen;
        brand.setAttribute('aria-expanded', String(isOpen));

        if (isOpen && !playerLoaded) {
            status.textContent = 'Memuat pemutar resmi SoundCloud…';
            connectWidget();
        }
    };

    brand.addEventListener('click', () => setOpen(popover.hidden));

    toggle.addEventListener('click', () => {
        if (!widgetReady) return;
        if (isPlaying) widget.pause();
        else widget.play();
    });

    seek.addEventListener('input', () => {
        if (!duration) return;
        const position = duration * (Number(seek.value) / Number(seek.max));
        currentTime.textContent = formatTime(position);
        seek.setAttribute('aria-valuetext', formatTime(position) + ' dari ' + formatTime(duration));
    });

    seek.addEventListener('change', () => {
        if (widgetReady && duration) widget.seekTo(duration * (Number(seek.value) / Number(seek.max)));
    });

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
