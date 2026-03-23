<?php
/**
 * Loads the Divi module when the builder is available.
 *
 * @package DiviCustomTestimonial
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin bootstrap.
 */
final class DCT_Loader {

	/**
	 * Singleton instance.
	 *
	 * @var DCT_Loader|null
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return DCT_Loader
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'et_builder_ready', array( $this, 'load_divi_module' ), 11 );
		add_action( 'admin_notices', array( $this, 'maybe_admin_notice_divi_missing' ) );
	}

	/**
	 * Load translations.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'divi-custom-testimonial', false, dirname( DCT_PLUGIN_BASENAME ) . '/languages' );
	}

	/**
	 * Register module with Divi Builder.
	 */
	public function load_divi_module() {
		if ( ! class_exists( 'ET_Builder_Module' ) ) {
			return;
		}

		require_once DCT_PLUGIN_DIR . 'includes/modules/class-dct-media-testimonial-slider-module.php';

		new DCT_Media_Testimonial_Slider_Module();
	}

	/**
	 * Show notice when Divi Builder is not available.
	 */
	public function maybe_admin_notice_divi_missing() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( class_exists( 'ET_Builder_Module' ) ) {
			return;
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && 'plugins' !== $screen->id ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		esc_html_e( 'Divi Media Testimonial Slider requires the Divi theme or Divi Builder plugin to be active.', 'divi-custom-testimonial' );
		echo '</p></div>';
	}
}
