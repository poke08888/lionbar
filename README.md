# Lion Bartender V2 — WordPress Theme + WooCommerce

A bold, premium WordPress theme for a cocktail bar / bartender brand called
**Lion Bartender**, with full **WooCommerce** support so the business can sell
cocktail kits, spirits, glassware, gift cards and event packages online.

> **Note on the design file:** the original design link
> (`https://api.anthropic.com/v1/design/h/UVW0_OHSvqvrI1b5X4Rhgw` → `Lion Bartender.html`)
> returned **HTTP 404** from the build environment, so the source HTML/README
> could not be read. This theme is a faithful interpretation of the
> "Lion Bartender" brand (dark + gold, elegant serif display, cocktail-bar
> storefront). Everything visual is token-driven and Customizer-editable, so it
> is easy to realign once the design is available — see
> [Matching the design](#matching-the-design).

## What's included

The theme lives in [`lion-bartender-v2/`](lion-bartender-v2/). Install it by copying
that folder into `wp-content/themes/` (or zip it and upload via
**Appearance → Themes → Add New → Upload**).

```
lion-bartender-v2/
├── style.css              Theme header + full design system (CSS variables)
├── functions.php          Theme setup, WooCommerce support, enqueues, widgets
├── header.php             Fixed nav, brand emblem, mini-cart link
├── footer.php             Contact / hours / social footer
├── front-page.php         Homepage: hero, features, about, menu, shop, reviews, CTA
├── index.php              Blog / archive / search listing
├── single.php             Single post & single cocktail
├── page.php               Static pages
├── sidebar.php            Blog sidebar
├── searchform.php         Themed search form
├── comments.php           Comments
├── woocommerce.php        WooCommerce page wrapper (shop/product/cart/checkout)
├── screenshot.png         Theme preview
├── template-parts/
│   └── content.php        Post card partial
├── inc/
│   ├── cocktail-cpt.php   "Cocktail Menu" custom post type + price meta
│   ├── customizer.php     Hero / About / Contact / accent-color controls
│   └── plugin-activation.php  One-click WooCommerce install prompt
└── assets/
    ├── css/woocommerce.css   Dark + gold shop styling
    └── js/main.js            Sticky header, mobile menu, smooth scroll
```

## Features matched to the design

| Area | Feature |
|------|---------|
| **Brand** | Dark charcoal/black canvas, gold accents, deep-wine secondary, Playfair Display + Poppins fonts, circular "Lion" emblem mark |
| **Homepage** | Full-screen hero with dual CTAs, feature strip, about block with experience badge, signature cocktail menu, shop teaser, testimonials, booking CTA band |
| **Cocktail Menu** | Custom **Cocktail** post type with price, ABV/strength and badge fields — drives the homepage menu and a `/cocktails` archive |
| **Shop (WooCommerce)** | Full WooCommerce support: shop, product, cart, checkout, account — all restyled dark + gold. Header mini-cart with live count via AJAX fragments. Homepage shows 4 popular products |
| **Customizer** | Edit hero copy/image, about copy/image/years, contact details, social links and the gold accent colour with no code |
| **Responsive** | Mobile slide-in menu, fluid type, stacking grids |
| **Quality** | Translation-ready (`lion-bartender` text domain), escaped output, nonce-protected meta, accessibility skip link & ARIA |

## Setup

1. **Install the theme** (copy folder or upload zip) and **Activate** it.
2. **Install WooCommerce** — on activation the theme shows an admin notice with
   a one-click *Install WooCommerce* button (uses the native WP installer). Run
   the WooCommerce setup wizard to create the Shop, Cart, Checkout and Account
   pages.
3. **Set a static homepage** — *Settings → Reading → Your homepage displays → A
   static page*, then pick any page. `front-page.php` renders the designed
   homepage automatically.
4. **Build the menus** — *Appearance → Menus*, assign one to **Primary** and
   (optionally) **Footer**.
5. **Add cocktails** — *Cocktail Menu → Add Cocktail*. Set a featured image,
   excerpt (shown as the description), price, ABV and badge.
6. **Add products** — *Products → Add New* for cocktail kits, bottles, tools and
   gift cards.
7. **Customize** — *Appearance → Customize* for hero, about, contact and colours.

## Matching the design

When the `Lion Bartender.html` design is available, align the theme by editing
the tokens at the top of `lion-bartender-v2/style.css`:

```css
:root{
  --lb-gold:#c9a227;   /* primary accent */
  --lb-wine:#7a1f2b;   /* secondary accent */
  --lb-cream:#f5f0e6;  /* text */
  --lb-black:#0d0d0f;  /* background */
  --lb-serif:"Playfair Display", serif;
  --lb-sans:"Poppins", sans-serif;
}
```

Hero/section copy and imagery are all editable in the Customizer, so most
design alignment needs no code changes.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- WooCommerce 7.0+ (for the shop)
