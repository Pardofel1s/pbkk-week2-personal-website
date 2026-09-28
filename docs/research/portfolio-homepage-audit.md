# Portfolio homepage audit

Reviewed: 28 September 2026

## Scope and method

The Awwwards archive snapshot contains **4,526 distinct portfolio submission records** gathered from 146 successful gallery pages. The records are catalogue entries, not 4,526 verified live sites. The full index is in [`portfolio-catalog.csv`](portfolio-catalog.csv).

The destination-link collector visited all **4,526 Awwwards detail records** and found **2,577 destination URL entries**, representing **2,538 distinct homepage paths** after duplicates were normalized by host and path (ignoring query strings and fragments). The audit made one initial HTML request to each of **2,400 distinct homepages** and recorded response status, document title and description, language, common page landmarks, link and control counts, responsive viewport metadata, ARIA attributes, and simple animation-related text hints. The request client followed normal redirects. Raw destination and audit data are in [`portfolio-destinations.csv`](portfolio-destinations.csv) and [`portfolio-homepage-audit.csv`](portfolio-homepage-audit.csv).

## Results

| Check | Result |
| --- | ---: |
| Unique homepages requested | 2,400 |
| HTTP 2xx responses | 2,085 (86.9%) |
| Other HTTP responses | 74 (3.1%) |
| No HTTP status returned | 241 (10.0%) |
| Viewport metadata present | 2,026 (84.4%) |
| At least one H1 | 1,408 (58.7%) |
| Navigation landmark present | 1,219 (50.8%) |
| At least one ARIA attribute | 1,504 (62.7%) |
| Skip link present | 177 (7.4%) |
| At least one HTML button | 1,094 (45.6%) |
| At least one link | 1,855 (77.3%) |
| Animation-related markup hints | 1,593 (66.4%) |

Counts are out of all 2,400 selected homepages; rows with no returned content count as not containing a feature. Among the inspected HTML responses, responsive viewport metadata and links were common. Explicit navigation landmarks and skip links appeared less often in the HTML snapshot, so the site keeps its semantic navigation, labelled controls, and keyboard paths visible by design. The animation-hint count only detects words or library names in the returned HTML; it does **not** measure actual animation or show whether motion improves usability.

The implementation applies the more reliable interaction lessons from the separately documented visual sample: keep the personal introduction concise, give long pages clear chapter navigation, label keyboard shortcuts, and let visitors move between pages without losing the soundtrack. Route changes now update the page content and URL while preserving the header and official SoundCloud player. Playback still requires an intentional click.

## Limits

- This is an automated homepage HTML audit with one initial request per selected address. It does not execute each site's JavaScript, download or inspect its stylesheets, measure performance, test responsive layouts, or judge its appearance.
- HTTP 2xx means the server returned a successful response; it does not guarantee that a person would see a complete, usable page. Some destinations may depend on client-side rendering.
- Timeouts, DNS/TLS failures, bot protections, and other restrictions account for rows without a status or with non-2xx responses. These results are preserved in the CSV instead of being treated as design patterns.
- A separate stratified sample of 24 entries was opened for visual review. Fifteen rendered far enough for useful inspection, two loaded only partially, four were unavailable in the review browser, one listing had no destination, and two destinations were not opened. The detailed observations and design decisions are in [`portfolio-live-review.md`](portfolio-live-review.md).
- The archive and site responses are a snapshot collected on 28 September 2026; availability and markup can change.

Source: [Awwwards portfolio archive](https://www.awwwards.com/websites/portfolio/).
