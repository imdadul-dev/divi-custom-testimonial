<?php
/**
 * Plugin Name: Divi Custom Testimonial
 * Description: A testimonial slider module for Divi with image, quote, author, and call-to-action—matching a clean split layout with navigation arrows.
 * Version: 1.0.0
 * Author: Custom
 * Text Domain: divi-custom-testimonial
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DCT_VERSION', '1.2.2' );
define( 'DCT_PLUGIN_FILE', __FILE__ );
define( 'DCT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DCT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load the module after Divi Builder is ready.
 */
function dct_load_module() {
	if ( ! class_exists( 'ET_Builder_Module' ) ) {
		return;
	}

	require_once DCT_PLUGIN_DIR . 'includes/modules/DCT_Custom_Testimonial_Module.php';

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
add_action( 'et_builder_ready', 'dct_load_module', 11 );

/**
 * Admin notice when Divi Builder is not available.
 */
function dct_admin_notice_missing_divi() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( class_exists( 'ET_Builder_Module' ) ) {
		return;
	}

	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'Divi Custom Testimonial requires the Divi theme or Divi Builder plugin to be active.', 'divi-custom-testimonial' );
	echo '</p></div>';
}
add_action( 'admin_notices', 'dct_admin_notice_missing_divi' );
