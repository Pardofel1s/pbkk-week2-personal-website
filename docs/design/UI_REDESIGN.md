# UI redesign notes

This iteration keeps the existing Warm Editorial Aura palette and treats the
site as a personal field journal: paper, correspondence, typographic indexes,
and small experiments that respond to the visitor.

## Reference principles

- [Rauno Freiberg — Interaction Design](https://rauno.me/craft/interaction-design):
  spatial continuity, interruptible motion, physical metaphors, and movement
  that explains an interaction. This informed the letter stack, the reader
  transition, and the restraint of idle animation.
- [Josh W. Comeau](https://www.joshwcomeau.com/): playful demonstrations and
  small interactive teaching surfaces. This informed the Workbench studies,
  where visitors can spread paper, change focus, and tune the color mood.
- [Henry From Online](https://henry.codes/): a personal editorial voice and
  digital-garden composition. This informed the folio headings, numbered
  indexes, alternating studies, and correspondence-style Contact page.

The implementation borrows principles rather than copying code, layouts, or
assets. All visual elements are built with the project's Blade, CSS, and small
vanilla JavaScript modules.

## Portfolio review: 20 live references

I reviewed the following working portfolios from A1's curated animated
portfolio collection. The review focused on their visual hierarchy, motion,
navigation, and how much animation they use to support rather than interrupt
reading. They are references for evaluating the experience, not templates to
copy.

1. [Jason Bergh](https://www.jasonbergh.com/)
2. [Joshua Baker](https://www.joshuabaker.com/)
3. [Oliver Gareis](https://www.olivergareis.com/)
4. [Artiom Yakushev](https://www.art-yakushev.com/)
5. [Daniel Sun](https://danielsun.space/)
6. [Dousan Miao](https://dousanmiao.com/)
7. [Sofia Khegai](https://khegai.com/)
8. [Juan Mora](https://juanmora.co/)
9. [Philip Readman](https://www.philipreadman.com/)
10. [Alvin Leung](https://alvinn.design/)
11. [Maximilian Kaspar](https://www.maximiliankaspar.com/)
12. [Daniil Chebotarev](https://www.daniilch.design/)
13. [Vladimir Pushkarev](https://puschkarew.com/)
14. [Christopher Koziol](https://koziol.design/)
15. [Viacheslav Novoseltsev](https://vshslv.com/)
16. [Gianluca Patti](https://glcpatti.com/)
17. [Artem Shcherban](https://artemshcherban.com/)
18. [Joffrey Spitzer](https://joffreyspitzer.com/)
19. [Awais Razzaque](https://www.awaisrazzaque.com/)
20. [Amna Javed](https://amnajaved.com/)

The gallery's guidance matches the implementation constraints: motion should
feel natural and quick, with smooth transitions, hover feedback, and scroll
reveals; jarring or slow movement harms the experience. Broader portfolio
reviews also support a clear section navigation, a concise personal story,
responsive reading, and a visible next action. The site's original peach,
coral, sage, and espresso palette remains the design anchor.

Sources: [A1 animated portfolio gallery](https://www.a1.gallery/websites/animated-portfolio),
[Colorlib developer portfolio review](https://colorlib.com/wp/developer-portfolios/),
[Pixpa portfolio review](https://www.pixpa.com/blog/portfolio-website-inspiration).

## Developer portfolio review: 21 more examples

The second pass focuses on software and engineering portfolios. The source
compares 21 live examples and calls out their navigation and project
presentation patterns; these are more relevant to a student engineering
portfolio than design-award sites alone.

| Portfolio | Pattern worth learning from |
| --- | --- |
| [Devon Stank](https://devonstank.com/) | Video-led hero with a restrained, readable dark layout. |
| [Michael Mannucci](https://michaelmannucci.com/) | Minimal one-page layout with direct section-jump links. |
| [Diogo Correia](https://diogotc.com/) | Sticky section navigation and an experience timeline. |
| [Alex Naraghi](https://www.alexnaraghi.com/) | Text-first introduction with a clear résumé action. |
| [Andrew McCarthy](https://andrevv.com/) | Project-led long scroll with a persistent, quiet header. |
| [La Playa](https://laplaya.studio/) | Project screenshots lead, with short captions for context. |
| [Sharlee](https://itssharl.ee/) | Theme choice and overlay navigation sit together in a clear menu. |
| [Brittany Chiang](https://brittanychiang.com/) | Fixed section links stay in view beside the scrolling content. |
| [Lauren Waller](https://www.lauren-waller.com/) | Large links and concise biography make the entry page scannable. |
| [Adenekan Wonderful](https://www.codewonders.dev/) | The biography itself provides contextual links to work and writing. |
| [Tania Rascia](https://www.taniarascia.com/) | Work history, theme choice, source links, and live demos are easy to find. |
| [Kenneth Jimmy](https://kenjimmy.xyz/) | Framed composition, a clear contact action, and theme control. |
| [Tamal Sen](https://tamalsen.dev/) | Persistent navigation supports a long single-page portfolio. |
| [Arpit Bhayani](https://arpitbhayani.me/) | Backend projects are explained with code and demo links rather than screenshots alone. |
| [Tom Weightman](https://www.tomweightman.com/) | Each project states the engineer's contribution. |
| [Koysor Abdul](https://www.koysor.me/) | Work cards link out to usable project examples. |
| [Lars Olson](https://www.lars-olson.com/) | Small interaction details add personality around the work. |
| [Niall Mc Dermott](https://niallmcdermott.webflow.io/) | Split-screen layout pairs stable identity with scrolling content. |
| [Leland Jansen](https://www.lelandjansen.com/) | Case studies say what changed and quantify the result. |
| [Tim Gesemann](https://www.tim-gesemann.dev/) | Prominent work followed by a creative experience timeline. |
| [Anthony Fu](https://antfu.me/) | Open-source projects link directly to their repositories. |

### Section navigation decision

The old right-hand dots behaved visually like a scrubber and concealed the
section names. The revised desktop control is a compact table of contents:
numbered anchors align to a thin position line, the current section name stays
visible, and other names reveal on hover or keyboard focus. On narrow screens,
it becomes a bottom anchor strip. Anchors still use normal document scrolling;
the browser scrollbar remains available and receives the palette's warm
styling. The active link exposes `aria-current="location"`, following W3C's
guidance for identifying the current item in a related set. Reduced-motion
preferences continue to disable smooth scrolling and nonessential movement.

This choice combines the section links used by Michael Mannucci, the persistent
navigation patterns in Diogo Correia and Brittany Chiang, and the readable
minimalism shared by the one-page examples. It avoids taking over the whole
screen with a custom scrollbar or forcing visitors into a snap-scroll system.

Sources: [Colorlib's 21 developer portfolio examples](https://colorlib.com/wp/developer-portfolios/),
[W3C technique ARIA26](https://www.w3.org/WAI/WCAG21/Techniques/aria/ARIA26),
[A1's animation guidance](https://www.a1.gallery/websites/animated-portfolio).

## Focused interaction audit — 28 September 2026

I revisited the music and long-page navigation against current examples and
official platform documentation before changing either interaction.

| Reference | What the review supports | Applied decision |
| --- | --- | --- |
| [Joshua Baker](https://www.joshuabaker.com/) | A short Work/About/Contact index sits beside a direct, project-led introduction. | Keep the side rail small and chapter-oriented; let the page remain the main event. |
| [Josh W. Comeau](https://www.joshwcomeau.com/) | Content is grouped by categories and article cards have clear titles and summaries; the site also discusses the performance cost of animation strategies. | Give each scroll destination a readable label and keep the interaction native/lightweight. |
| [Michael Mannucci](https://michaelmannucci.com/) | One-page work/blog links jump directly to their sections. | Keep normal anchor links and browser scrolling instead of replacing the document scroll model. |
| [Diogo Correia](https://diogotc.com/) | Sticky navigation makes jumps between long-page sections convenient, with experience presented as a timeline. | Keep the index available while scrolling and expose which chapter is active. |
| [Brittany Chiang](https://brittanychiang.com/) | Compact persistent section links pair naturally with a one-page technical portfolio. | Use a slim index with a selected-state cue; avoid a large fixed menu over content. |
| [Andrew McCarthy](https://andrevv.com/) | A persistent name/info header supports a long project scroll while visual effects follow the content. | Keep page navigation as an orientation aid, not a separate scrolling experience. |
| [A1 animated portfolio gallery](https://www.a1.gallery/websites/animated-portfolio) | Current examples use smooth transitions, hover feedback, and scroll reveals to help people browse work. | Animate active/hover states briefly; do not animate the rail continuously. |
| [W3C WAI G128](https://www.w3.org/WAI/WCAG21/Techniques/general/G128) | A navigation component should identify the current location in a way that matches displayed content. | Set `aria-current="location"` and reinforce it with both number and text styling. |
| [Nielsen Norman Group: In-Page Links](https://www.nngroup.com/articles/in-page-links/) | Anchors save time on long pages; sticky in-page links should mark the current section and must not cover the target heading. | Keep the index separate from the main site nav, show the active chapter, and preserve a clear view of the destination. |
| [MDN: Intersection Observer](https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API) | Browser-managed intersection observation avoids the repeated scroll-handler work historically used to track visibility. | Continue using `IntersectionObserver` for active-chapter updates instead of a per-scroll layout loop. |
| [YouTube IFrame API](https://developers.google.com/youtube/iframe_api_reference) | The documented controllable embedded player is a YouTube video player; it provides playback events and seek methods. | Do not label an embedded YouTube video as native YouTube Music playback. |
| [YouTube Help: Embed videos and playlists](https://support.google.com/youtube/answer/171780?hl=en) | YouTube documents embedding YouTube videos/playlists, including referrer requirements and privacy-enhanced mode. | Link the requested song directly to YouTube Music and avoid a broken/blank iframe in the site's player. |

### Navigation decision

The former desktop rail mostly hid section names until hover, so it read like a
thin, decorative scrollbar. The updated desktop index gives the right-side
control a narrow paper-like surface, visible chapter titles, numbered anchors,
and a progress track that stays beside the hero artwork. Its selected chapter uses both a filled number and a
coral title cue. At phone widths it remains a compact bottom pill with the
current chapter name and nearby numeric destinations, preserving room for
reading. Native scrolling stays intact, and the active section is exposed via
`aria-current="location"`.

### YouTube Music decision

There is no official YouTube Music playback API in the supported Google
developer documentation reviewed for this iteration. The documented IFrame
API controls YouTube video embeds, not the YouTube Music web app. The K control
therefore opens the song directly in YouTube Music, with a matching title,
artist, concise note, and a clear external action. It no longer displays a
pretend progress bar or a YouTube video embed as though that were native
YouTube Music playback. The K button and the `K` keyboard shortcut open the
same compact choice panel; `Escape` closes it.

Sources: [YouTube IFrame Player API](https://developers.google.com/youtube/iframe_api_reference),
[YouTube's embedding guide](https://support.google.com/youtube/answer/171780?hl=en),
[official track page and YouTube Music destination](https://soundcloud.com/leagueoflegends/everything-goes-on-porter-robinson).

## Motion rules

- Idle pulsing, floating, and shimmer loops are removed.
- Page reveals, theme transitions, and card movement happen after a visitor
  action or when new content enters the viewport.
- The light cursor leaves a short, open ink stroke; dark mode uses a tiny warm
  glint. Both are capped, temporary, and disabled for touch and reduced motion.
- The letter reader is a native dialog so focus, Escape, keyboard navigation,
  and the full-screen visual layer remain predictable.
