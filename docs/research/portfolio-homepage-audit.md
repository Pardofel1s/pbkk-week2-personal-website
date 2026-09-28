# Portfolio homepage audit

Reviewed: 28 September 2026

## Scope and method

The Awwwards archive snapshot contains **4,526 distinct portfolio submission records** gathered from 146 successful gallery pages. The records are catalogue entries, not 4,526 verified live sites. The full index is in [`portfolio-catalog.csv`](portfolio-catalog.csv).

The destination-link collector visited **3,660 Awwwards detail records** and found **2,101 destination URL entries**. Duplicate destination homepages were normalized by host and path (ignoring query strings and fragments). The audit then made one HTML request to each of **2,000 distinct homepages** and recorded response status, document title and description, language, common page landmarks, link and control counts, responsive viewport metadata, ARIA attributes, and simple animation-related text hints. Raw destination and audit data are in [`portfolio-destinations.csv`](portfolio-destinations.csv) and [`portfolio-homepage-audit.csv`](portfolio-homepage-audit.csv).

## Results

| Check | Result |
| --- | ---: |
| Unique homepages requested | 2,000 |
| HTTP 2xx responses | 1,756 (87.8%) |
| Other HTTP responses | 60 (3.0%) |
| No HTTP status returned | 184 (9.2%) |
| Viewport metadata present | 1,706 (85.3%) |
| At least one H1 | 1,169 (58.5%) |
| Navigation landmark present | 1,016 (50.8%) |
| At least one ARIA attribute | 1,278 (63.9%) |
| Skip link present | 148 (7.4%) |
| At least one HTML button | 944 (47.2%) |
| At least one link | 1,553 (77.7%) |
| Animation-related markup hints | 1,341 (67.1%) |

Among the returned documents, responsive viewport metadata and links were common. Explicit navigation landmarks and skip links appeared less often in the HTML snapshot, so the site keeps its semantic navigation, labelled controls, and keyboard paths visible by design. The animation-hint count only detects words or library names in the returned HTML; it does **not** measure actual animation or show whether motion improves usability.

The implementation applies the more reliable interaction lessons from the separately documented visual sample: keep the personal introduction concise, give long pages clear chapter navigation, label keyboard shortcuts, and let visitors move between pages without losing the soundtrack. Route changes now update the page content and URL while preserving the header and official SoundCloud player. Playback still requires an intentional click.

## Limits

- This is an automated, one-request homepage HTML audit. It does not execute each site's JavaScript, download or inspect its stylesheets, measure performance, test responsive layouts, or judge its appearance.
- HTTP 2xx means the server returned a successful response; it does not guarantee that a person would see a complete, usable page. Some destinations may depend on client-side rendering.
- Timeouts, DNS/TLS failures, bot protections, and other restrictions account for rows without a status or with non-2xx responses. These results are preserved in the CSV instead of being treated as design patterns.
- A separate stratified sample of 24 entries was opened for visual review. Fifteen rendered far enough for useful inspection, two loaded only partially, four were unavailable in the review browser, one listing had no destination, and two destinations were not opened. The detailed observations and design decisions are in [`portfolio-live-review.md`](portfolio-live-review.md).
- The archive and site responses are a snapshot collected on 28 September 2026; availability and markup can change.

Source: [Awwwards portfolio archive](https://www.awwwards.com/websites/portfolio/).
