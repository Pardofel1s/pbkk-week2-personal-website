# Validation — 6 September 2026

## Automated checks

- `php artisan test --compact`: **29 passed, 86 assertions**.
- `php vendor/bin/pint --test`: passed.
- `php artisan view:cache`: all Blade templates compiled.
- `php artisan route:list --except-vendor`: 11 named application routes, all delegated to PageController.
- `node --check public/js/portfolio.js`: syntax passed.
- `git diff --check`: passed.

Feature tests cover required pages, blog details and unknown slugs, four arithmetic operations, decimals, negative numbers, division by zero, invalid numbers/operations, range limits, form redirects, missing fields, escaped profile text, and controller delegation.

## Browser checks

Verified against local Laravel server at http://127.0.0.1:8001.

- Desktop Home renders the warm peach/sage composition and envelope.
- Envelope button toggles expanded state.
- Card demo toggles spread state.
- Blur slider changes the value to 24 px and updates the style.
- Aura selection changes to sage and updates pressed state.
- Collection Typography filter returns 2 items.
- Blog search for URL returns 1 note.
- Unmatched search returns 0 notes with the empty-state message.
- Combining search URL with Design filter returns 0 notes with the empty state.
- Mobile viewport 390 × 844: Home menu opens and shows all 7 navigation links.
- Mobile calculator form with 10, 5, kali navigates to /hitung/10/5/kali and displays 50.
- No horizontal page overflow observed on mobile Home, calculator result, Projects, Contact, or Collection.
- Temporary viewport override reset after verification.

These are targeted functional and responsive checks, not an exhaustive browser compatibility or accessibility audit.

## Content boundaries

- The user supplied the name, NRP, telephone, email, LinkedIn, and GitHub profile.
- Project items describe features implemented in this website, not invented previous work.
- Collection entries are implementation references.
- Blog entries are initial implementation notes for review/editing by the owner.
- Project Idea is explicitly marked as a proposal pending group agreement; this site does not run an AI agent.
- The source repository is private. External visitors cannot read the source without access.

## Animation upgrade — 2026-09-06

- Added progressive scroll reveals, floating hero artwork, rotating accents, card tilt, button ripple and sheen, reading progress, menu entrance, filter-result reveals, and supported-browser view transitions.
- Footer animation toggle persists across reloads; device reduced-motion preference takes priority. Content remains visible without JavaScript.
- Verified in the local browser: active hero animation, toggle stops it, disabled preference survives reload, re-enabling works, Typography filter shows 2 items, and mobile menu exposes 7 links at 390 x 844 without horizontal page overflow.
- Browser error log was empty during these checks.
- Laravel: 29 tests passed (86 assertions). JavaScript syntax checks, Blade compilation, and git diff whitespace checks passed.
- OS reduced-motion switching and cross-browser view transitions were not manually tested.
