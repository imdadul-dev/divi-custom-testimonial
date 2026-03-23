<?php
/**
 * Plugin Name: Divi Custom Testimonial
 * Description: A testimonial slider module for Divi with image, quote, author, and call-to-action—matching a clean split layout with navigation arrows.
 * Version: 1.4.0
 * Author: Custom
 * Text Domain: divi-custom-testimonial
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * Compatible with Divi theme, Divi Builder plugin, Divi 4.x / 5.x (backward compatibility layer).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DCT_VERSION', '1.4.0' );
define( 'DCT_PLUGIN_FILE', __FILE__ );
define( 'DCT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DCT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once DCT_PLUGIN_DIR . 'includes/class-dct-loader.php';

/**
 * Register assets early so Divi lazy-loading / VB iframe can enqueue them reliably.
 */
add_action( 'plugins_loaded', 'dct_register_assets', 5 );

/**
 * Primary: after Divi registers builder classes.
 */
add_action( 'et_builder_ready', 'dct_load_module', 11 );

/**
 * Fallback: unusual load order (caching, child themes, Builder plugin timing).
 */
add_action( 'wp_loaded', 'dct_maybe_load_module_fallback', 99 );

/**
 * Visual Builder (iframe) — hook exists in Divi 4+ FB.
 */
add_action( 'et_fb_enqueue_assets', 'dct_enqueue_visual_builder_assets' );

/**
 * VB preview when `et_fb` is present or Divi helper reports FB active.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		$vb = false;
		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
			$vb = true;
		} elseif ( function_exists( 'et_fb_is_enabled' ) && et_fb_is_enabled() ) {
			$vb = true;
		} elseif ( isset( $_GET['et_fb'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$vb = true;
		}
		if ( $vb ) {
			dct_enqueue_visual_builder_assets();
		}
	},
	999
);

/**
 * Admin notice when Divi Builder is not available.
 */
function dct_admin_notice_missing_divi() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( dct_is_divi_builder_available() ) {
		return;
	}

	echo '<div class="notice notice-warning is-dismissible"><p>';
	echo esc_html__( 'Divi Custom Testimonial requires the Divi theme or Divi Builder plugin to be active. The module will load automatically when Divi Builder is available.', 'divi-custom-testimonial' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'dct_admin_notice_missing_divi' );
