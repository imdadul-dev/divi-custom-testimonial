# Divi Custom Testimonial — Feature list

## Core

- Divi Builder module: **Custom Testimonial**
- **Up to five testimonials** on the Content tab using standard fields (not a sortable list, for Visual Builder reliability): per block — **image**, **testimonial text**, **author name**, **read more text**, **read more link**, **open in new tab**

## Layout & design

- Split layout with **image position** left or right (per breakpoint: desktop / tablet / phone)
- **Content text alignment** left, center, or right (per breakpoint)
- **Gaps**: column gap (image vs content), content gap (icon → quote → author → button), space around slider / arrows, inner card min height
- **Inner card** background; optional **module (outer) background** behind the card and arrows
- **Per-element colors**: accent (fallback), quote icon, quote text, author, button background, button text, inner card, module background, arrows
- **Image**: corner radius, aspect ratio, column width %, max width, **object fit** (cover, contain, fill, none, scale-down)
- **Button**: corner radius, padding (vertical / horizontal), border width & color
- **Quote icon** size
- **Slide transition** duration (milliseconds)
- **Typography** (Divi advanced): quote, author, and **button** fonts
- **Spacing** (margin & padding), **background**, **max width**, **height** on the inner card
- **Borders & shadows**: image and **inner card** (separate controls)
- **Custom CSS** targets: quote icon, button, arrows, **content column**, **image column**

## Slider & navigation

- **Previous / next** controls (optional if more than one slide)
- **Arrow** color, **icon size**, and **touch target** size
- Transition uses module setting; **respects `prefers-reduced-motion`**

## Responsive behavior

- **Divi responsive** (tablet / phone icons) on colors, spacing, layout direction, alignment, image sizing, button padding, arrows, and most design fields
- Generated CSS uses Divi breakpoints (**980px** tablet, **767px** phone) for variable overrides
- **≤767px**: column stack (image on top, content below), full-width columns, fluid type via `clamp`, touch-friendly nav
- Slider width syncs on **resize** and **ResizeObserver**

## Plugin behavior

- Loads when Divi is ready (`et_builder_ready`, with `wp_loaded` fallback); registers assets early (`plugins_loaded`) for Divi 4/5 and lazy shortcodes
- Shows an **admin notice** if Divi Builder is not active
- **Visual Builder** uses **`partial`** compatibility (PHP/AJAX preview) — see `VISUAL-BUILDER.md`
