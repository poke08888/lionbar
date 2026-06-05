# Nonelab — WordPress Theme

A faithful WordPress implementation of the **Nonelab** corporate design
(claude.ai/design handoff bundle `nonelab-web`) — a trilingual
(EN / VI / 中文) brochure site for a Vietnamese beauty & wellness group.

It recreates the *Editorial Split* direction pixel-for-pixel: editorial hero,
scroll-reveal motion, parallax, count-up statistics, a brand marquee, partner
logo walls, an awards / "#1 on e-commerce" section, the "Nerman × Indonesia"
band and a working partnership-enquiry form — across five pages
(Home, About, Brands, Partners, Contact).

## Install & first run

1. Copy the `nonelab/` folder into `wp-content/themes/` (or zip it and upload
   via **Appearance → Themes → Add New → Upload**).
2. **Activate** the theme. On activation it automatically:
   - creates the five pages (Home, About, Brands, Partners, Contact) and
     assigns the matching page templates,
   - sets **Home** as the static front page,
   - builds a **Primary** menu from those pages,
   - switches on pretty permalinks (if they weren't already).

   So the full site is live the moment you activate — no manual page setup.
3. (Optional) **Appearance → Customize → Site Identity** to drop in a custom
   logo; otherwise the `nonelab` wordmark + gradient orb is used.

That's it. Visit the front page and switch languages with the **EN / VI / 中文**
toggle in the header (the choice is remembered per visitor).

## How it maps to WordPress

| Design file        | WordPress file                  |
|--------------------|---------------------------------|
| `index.html`       | `front-page.php`                |
| `about.html`       | `templates/about.php`           |
| `brands.html`      | `templates/brands.php`          |
| `partners.html`    | `templates/partners.php`        |
| `contact.html`     | `templates/contact.php`         |
| shared nav/footer  | `header.php` / `footer.php` (server-rendered, was `chrome.js`) |
| `assets/nonelab.css` | `assets/nonelab.css` (enqueued) |
| `assets/site.js`, `assets/i18n*.js` | same, enqueued via `functions.php` |

The trilingual engine is unchanged from the design: `i18n.js` translates every
`data-i18n` node, and each page loads only its own string bundle
(`i18n-home.js`, `i18n-about.js`, …).

## Performance ("load fast, run smoothly")

- **Server-rendered chrome** — the nav and footer are output in PHP instead of
  injected by JS (`chrome.js`), so there is no layout shift and the markup is
  crawlable.
- **Deferred scripts in the footer** — all theme JS is `defer`-loaded so it
  never blocks first paint; dependency order (page strings → i18n engine) is
  guaranteed by WordPress.
- **Split, cache-friendly assets** — the design system CSS is enqueued
  separately from WordPress' generated styles, each versioned by file mtime for
  long-cache + instant cache-busting on change.
- **Only what a page needs** — the per-page i18n bundle and the contact-form
  script load only on the relevant page.
- **Font preconnect + `display=swap`** — matches the design's `<head>` for fast,
  non-blocking webfont loading.
- **Lazy images** — below-the-fold imagery uses `loading="lazy"`; the hero image
  loads eagerly.
- **Lean `<head>** — emoji script, generator, RSD/WLW and shortlink tags are
  removed.
- **Reduced-motion aware** — the design's CSS/JS honour
  `prefers-reduced-motion`, instantly revealing content and disabling the
  marquee/parallax.

## The working contact form

The Contact page form validates on the client (matching the design) **and**
submits to a real WordPress endpoint:

- `assets/contact.js` POSTs to `admin-ajax.php` (`action=nonelab_enquiry`) with
  a nonce.
- `nonelab_handle_enquiry()` in `functions.php` re-validates server-side and
  emails the site admin via `wp_mail()`.
- Change the recipient with the `nonelab_enquiry_recipient` filter:

  ```php
  add_filter( 'nonelab_enquiry_recipient', fn() => 'partnerships@nonelab.net' );
  ```

If the endpoint is unreachable the form falls back to the design's simulated
success state, so it is never broken for the visitor.

## Customising content

The body copy lives in the page templates and in the `assets/i18n-*.js`
translation bundles (EN / VI / 中文). To change a headline or stat, edit the
matching `data-i18n` key in the relevant bundle so all three languages stay in
sync. Brand and partner logos are in `assets/` and `assets/partners/`.

## Requirements

- WordPress 6.0+
- PHP 7.4+
