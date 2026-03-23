<?php
/**
 * Plugin Name:       Divi Media Testimonial Slider
 * Plugin URI:        https://github.com/yourusername/divi-custom-testimonial
 * Description:       Custom Divi Builder module: media (image/video) with testimonial content and Swiper-based slider.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Your Name
 * Author URI:        https://example.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       divi-custom-testimonial
 *
 * @package DiviCustomTestimonial
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DCT_VERSION', '1.0.0' );
define( 'DCT_PLUGIN_FILE', __FILE__ );
define( 'DCT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DCT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'DCT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once DCT_PLUGIN_DIR . 'includes/class-dct-loader.php';

DCT_Loader::instance();
