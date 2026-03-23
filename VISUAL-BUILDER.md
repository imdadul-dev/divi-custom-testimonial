# Visual Builder notes

## Version compatibility (Divi 4 / 5 / Builder plugin)

The plugin:

- Loads on `et_builder_ready` and falls back to `wp_loaded` if the builder fired in an unusual order.
- Registers CSS/JS on `plugins_loaded` so assets exist before Divi lazy-loads shortcodes or the Visual Builder iframe.
- Enqueues assets for the FB iframe via `et_fb_enqueue_assets`. The module’s `render()` also calls `wp_enqueue_*` when the module outputs, so front end and VB previews still get CSS/JS.
- Uses `vb_support = partial` (PHP/AJAX preview) so a separate React bundle is not required across Divi versions.
- Does **not** call `parent::init()` before setting `slug` / `name` — doing so can register an invalid module and make the Visual Builder fail to load.

Use the **Divi theme** or **Divi Builder** plugin from Elegant Themes; third-party “Divi” forks are not supported.

## Why you might see minified JavaScript (`createElement`, `rawContentProcessor`, etc.)

Divi’s Visual Builder has three compatibility levels: **off**, **partial**, and **on** (see [Compatibility levels](https://www.elegantthemes.com/documentation/developers/divi-module/compatibility-levels/)).

- **`on`** means the module ships a **React** implementation for the builder. If a plugin only has PHP and still sets `vb_support` to `on`, the VB can show **broken output or minified bundle code** instead of your layout.
- **`partial`** tells Divi to render the module **via AJAX using your PHP `render()` method**. That is what this plugin uses so the preview matches the front end without a separate JS bundle.

After updating the plugin, **clear cache**, reload the Visual Builder, and re-insert the module if the old instance still looks wrong.

## Content → Testimonials looked blank

That was usually the same **VB + `on` mismatch**: the settings UI did not behave correctly. With **`partial`** support and a **default first slide** in the sortable list, new modules should open with one testimonial row ready to edit (image, testimonial text, author, Read More text/link).

### Content tab still empty or sortable rows have no sub-fields

**Current plugin (1.3+):** testimonials are **not** a `sortable_list` anymore. The Content tab uses **normal Divi fields** (upload, textarea, text, yes/no) for up to **five** testimonials (`Testimonial 1 — Image`, `Testimonial 1 — Testimonial text`, …). That avoids Visual Builder bugs with `sortable_list` on PHP-only modules.

**Legacy:** if your page still has a `slides="[...]"` attribute from an older version and you have **not** filled any of the new plain fields, the front end still uses that JSON. As soon as you fill the new fields and save, the module uses those instead (re-enter any extra slides in testimonial 2–5 if needed).

## Backend builder

If you ever need the classic Divi backend builder, modules with `partial` still work there; settings are the same.
