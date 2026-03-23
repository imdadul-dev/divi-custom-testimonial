<?php
/**
 * Bootstrap: load module once Divi Builder is available; works across Divi 4 / 5 / Builder plugin.
 *
 * @package DiviCustomTestimonial
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Divi Builder core is loaded.
 *
 * @return bool
 */
function dct_is_divi_builder_available() {
	return class_exists( 'ET_Builder_Module' ) && class_exists( 'ET_Builder_Element' );
}

/**
 * Register plugin CSS/JS (called once).
 *
 * @return void
 */
function dct_register_assets() {
	if ( wp_style_is( 'dct-custom-testimonial', 'registered' ) ) {
		return;
	}

	wp_register_style(
		'dct-custom-testimonial',
		DCT_PLUGIN_URL . 'assets/css/frontend.css',
		array(),
		DCT_VERSION
	);

	wp_register_script(
		'dct-custom-testimonial',
		DCT_PLUGIN_URL . 'assets/js/frontend.js',
		array(),
		DCT_VERSION,
		true
	);
}

/**
 * Load the Divi module class and register assets.
 *
 * @return void
 */
function dct_load_module() {
	if ( ! dct_is_divi_builder_available() ) {
		return;
	}

	if ( class_exists( 'DCT_Custom_Testimonial_Module', false ) ) {
		return;
	}

	require_once DCT_PLUGIN_DIR . 'includes/modules/DCT_Custom_Testimonial_Module.php';
}

/**
 * Fallback if `et_builder_ready` never fired (unusual load order / edge cases).
 *
 * @return void
 */
function dct_maybe_load_module_fallback() {
	if ( class_exists( 'DCT_Custom_Testimonial_Module', false ) ) {
		return;
	}
	if ( ! dct_is_divi_builder_available() ) {
		return;
	}
	// Primary path: et_builder_ready should have run; this only runs if it did not.
	if ( did_action( 'et_builder_ready' ) ) {
		return;
	}
	dct_load_module();
}

/**
 * Enqueue assets in the Visual Builder / FB iframe when Divi loads scripts there.
 *
 * @return void
 */
function dct_enqueue_visual_builder_assets() {
	if ( ! class_exists( 'DCT_Custom_Testimonial_Module', false ) ) {
		return;
	}
	dct_register_assets();
	wp_enqueue_style( 'dct-custom-testimonial' );
	wp_enqueue_script( 'dct-custom-testimonial' );
}
