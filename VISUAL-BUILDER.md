# Visual Builder notes

## Why you might see minified JavaScript (`createElement`, `rawContentProcessor`, etc.)

Divi’s Visual Builder has three compatibility levels: **off**, **partial**, and **on** (see [Compatibility levels](https://www.elegantthemes.com/documentation/developers/divi-module/compatibility-levels/)).

- **`on`** means the module ships a **React** implementation for the builder. If a plugin only has PHP and still sets `vb_support` to `on`, the VB can show **broken output or minified bundle code** instead of your layout.
- **`partial`** tells Divi to render the module **via AJAX using your PHP `render()` method**. That is what this plugin uses so the preview matches the front end without a separate JS bundle.

After updating the plugin, **clear cache**, reload the Visual Builder, and re-insert the module if the old instance still looks wrong.

## Content → Testimonials looked blank

That was usually the same **VB + `on` mismatch**: the settings UI did not behave correctly. With **`partial`** support and a **default first slide** in the sortable list, new modules should open with one testimonial row ready to edit (image, testimonial text, author, Read More text/link).

### Content tab still empty or sortable rows have no sub-fields

Divi reserves many **top-level attribute names** (for example `image`, `quote`, `author`, `background_color`). Using those names as **keys inside** a `sortable_list` can break the settings panel so labels and inputs never appear.

This module uses prefixed keys (`tst_image`, `tst_quote`, `tst_author`, …) so they do not collide with Divi’s internals. Older saved modules that used the old keys are still read on the front end via fallbacks.

Also ensure each field that belongs on the **Content** tab includes **`tab_slug` => `'general'`** together with **`toggle_slug`**.

## Backend builder

If you ever need the classic Divi backend builder, modules with `partial` still work there; settings are the same.
