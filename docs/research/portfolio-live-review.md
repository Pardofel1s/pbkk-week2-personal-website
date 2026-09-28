# Portfolio reference review

Reviewed: 28 September 2026

## Scope and method

The catalogue contains **2,108 distinct Awwwards portfolio submissions** gathered from 68 paginated gallery pages. Each row is a listing and its public metadata; it does not mean that all 2,108 destination sites were opened or visually reviewed. The full catalogue is in [`portfolio-catalog.csv`](portfolio-catalog.csv).

For a direct review, 24 listing records were selected across eight visual themes and three pagination bands (recent, middle, earlier). The exact selection and source record for each entry are in [`portfolio-live-review-sample.csv`](portfolio-live-review-sample.csv). The page bands are positions in the archive, not publication-year claims.

Of the 24 candidates, 21 destination URLs were opened. Fifteen rendered far enough for a useful visual inspection, two exposed page content but remained at a blank or zero-percent preloader in this browser, and four were unavailable here (a parked domain, a missing page, a timeout, or a DNS failure). One archive record had no destination link; two remaining destinations were not opened. These limitations are recorded rather than treated as design evidence.

## Patterns that fit this website

| Site reviewed | What was visible | Decision for Kamal's site |
| --- | --- | --- |
| [Adam Bricker](https://www.adambricker.com/) | Strong editorial title and a compact numbered section index over a project-led page. | Keep the current section selector on long pages and use clear section labels; this is already a strong fit for the field-journal direction. |
| [Qlip — 2026 greeting](https://2026.qlip.co.jp/en/) and [2025 greeting](https://2025.qlip.co.jp/) | Large, centered serif headline, restrained navigation, and one obvious invitation into the page. | Keep expressive type for major headings while preserving the short supporting copy and clear next action. |
| [3Dear](https://www.3dear.se/) | A concise, large serif statement set apart from a visual project area. | Preserve the contrast between editorial headings and practical sans-serif controls. |
| [Aeruk](https://aerukart.com/) | One primary identity statement, a short explanation, a clear project action, and section links. | Keep the homepage introduction compact; the new music strip also follows this hierarchy by separating title, artist, and progress. |
| [1820 Productions](https://www.1820productions.com/) | A selected work is prominent, with a small index, direct work/services/about links, and short calls to action. | Make project browsing feel guided and labelled rather than adding more decorative motion. |
| [3.14 Studio](https://www.3point14.ca/) | A clear typographic statement and an explicit “Formal / Raw” visual switch. | Continue treating theme and visual settings as intentional controls with visible state. |
| [Airbag Studio](https://airbagstudio.it/en) | Bold color in one hero area, then structured explanations and stable section navigation. | Reserve accent color for focal moments; keep the rest of the site readable in both themes. |
| [A24 film-disc concept](https://a24.raviklaassens.com/) | Keyboard help is stated beside an unusual disc-selection interaction. This is an independent concept project, not the official A24 website. | Keep interaction shortcuts visible and explain them; the player now documents `K` and `Esc`, plus its real play and seek controls. |
| [Ahoy Agvertising](https://agvertising.biz/) | A playful map-like hero and unusual side links, but the page is initially sparse while its animation loads. | Use animation as a layer around the content, never as a gate that hides the page or navigation. |

Several visually louder examples were useful as limits. [0110 Studio](https://amirvl.com/) and [Aeruk](https://aerukart.com/) use prominent 3D or refractive artwork; [Acid Crunch](https://acid-crunch.com/) uses a dark, console-like portfolio; and [8enjamin](https://8enjamin.vercel.app/) remained at a zero-percent loading state in this browser. Their styles or loading behavior are not suitable to copy wholesale into a fast academic portfolio.

## Changes informed by the review

- The header keeps its small K mark and now shows a real, fine progress line beside the song title. The dedicated panel exposes the same progress as a keyboard-accessible range, along with current time, duration, and an actual play/pause control.
- The song is streamed from the official SoundCloud release. Its embed and official Widget API are loaded only after the visitor opens the player, keeping the first page view free of music-player network requests.
- The existing page-section selector and compact section labels remain; the sampled portfolios confirmed their value on long pages.
- No large 3D scene or full-screen preloader was added. The sample showed both can dominate a portfolio and can delay access to its content.

The reference list is a design survey, not a claim that every page in the Awwwards catalogue is current, available, or visually reviewed. The snapshot counts are in [`portfolio-catalog-summary.md`](portfolio-catalog-summary.md).
