<?php
/**
 * Divi module: Custom Testimonial slider.
 *
 * @package DiviCustomTestimonial
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DCT_Custom_Testimonial_Module extends ET_Builder_Module {

	/**
	 * Module init.
	 *
	 * Do not call parent::init() before slug/name are set — ET_Builder_Module registers the
	 * module during init; an empty slug breaks the Visual Builder. Custom modules typically
	 * only assign properties here (Elegant Themes pattern).
	 */
	public function init() {
		$this->name      = esc_html__( 'Custom Testimonial', 'divi-custom-testimonial' );
		$this->plural    = esc_html__( 'Custom Testimonials', 'divi-custom-testimonial' );
		$this->slug       = 'dct_custom_testimonial';
		/**
		 * Use "partial" so the Visual Builder previews via PHP (AJAX). "on" requires a bundled
		 * React module; without it the VB shows broken minified JS (createElement/rawContentProcessor).
		 *
		 * @link https://www.elegantthemes.com/documentation/developers/divi-module/compatibility-levels/
		 */
		$this->vb_support = 'partial';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title'    => esc_html__( 'Content', 'divi-custom-testimonial' ),
						'priority' => 1,
					),
					'navigation'   => array(
						'title'    => esc_html__( 'Navigation', 'divi-custom-testimonial' ),
						'priority' => 2,
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'layout'   => array(
						'title'    => esc_html__( 'Layout & Spacing', 'divi-custom-testimonial' ),
						'priority' => 45,
					),
					'colors'   => array(
						'title'    => esc_html__( 'Colors', 'divi-custom-testimonial' ),
						'priority' => 46,
					),
					'icon'     => array(
						'title'    => esc_html__( 'Quote Icon', 'divi-custom-testimonial' ),
						'priority' => 50,
					),
					'image'    => array(
						'title'    => esc_html__( 'Image', 'divi-custom-testimonial' ),
						'priority' => 51,
					),
					'button'   => array(
						'title'    => esc_html__( 'Button', 'divi-custom-testimonial' ),
						'priority' => 52,
					),
				),
			),
		);

		$this->custom_css_fields = array(
			'quote_icon' => array(
				'label'    => esc_html__( 'Quote Icon', 'divi-custom-testimonial' ),
				'selector' => '.dct-quote-icon',
			),
			'read_more'  => array(
				'label'    => esc_html__( 'Read More Button', 'divi-custom-testimonial' ),
				'selector' => '.dct-read-more',
			),
			'nav_prev'   => array(
				'label'    => esc_html__( 'Previous Arrow', 'divi-custom-testimonial' ),
				'selector' => '.dct-nav--prev',
			),
			'nav_next'   => array(
				'label'    => esc_html__( 'Next Arrow', 'divi-custom-testimonial' ),
				'selector' => '.dct-nav--next',
			),
			'content_col' => array(
				'label'    => esc_html__( 'Content Column', 'divi-custom-testimonial' ),
				'selector' => '.dct-content',
			),
			'media_col'   => array(
				'label'    => esc_html__( 'Image Column', 'divi-custom-testimonial' ),
				'selector' => '.dct-media',
			),
		);
	}

	/**
	 * Advanced fields (typography, spacing, etc.).
	 *
	 * @return array
	 */
	public function get_advanced_fields_config() {
		return array(
			'fonts'          => array(
				'quote'  => array(
					'label'          => esc_html__( 'Quote', 'divi-custom-testimonial' ),
					'css'            => array(
						'main' => '%%order_class%% .dct-quote-text',
					),
					'font_size'      => array(
						'default' => '18px',
					),
					'line_height'    => array(
						'default' => '1.6em',
					),
					'letter_spacing' => array(
						'default' => '0px',
					),
				),
				'author' => array(
					'label'          => esc_html__( 'Author', 'divi-custom-testimonial' ),
					'css'            => array(
						'main' => '%%order_class%% .dct-author',
					),
					'font_size'      => array(
						'default' => '15px',
					),
					'line_height'    => array(
						'default' => '1.4em',
					),
				),
				'button' => array(
					'label'          => esc_html__( 'Button', 'divi-custom-testimonial' ),
					'css'            => array(
						'main' => '%%order_class%% .dct-read-more',
					),
					'font_size'      => array(
						'default' => '15px',
					),
					'line_height'    => array(
						'default' => '1.2em',
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main' => '%%order_class%% .dct-testimonial-inner',
				),
			),
			'background'     => array(
				'css' => array(
					'main' => '%%order_class%% .dct-testimonial-inner',
				),
			),
			'max_width'      => array(
				'css' => array(
					'main' => '%%order_class%% .dct-testimonial-inner',
				),
			),
			'height'         => array(
				'css' => array(
					'main' => '%%order_class%% .dct-testimonial-inner',
				),
			),
			'borders'        => array(
				'default' => array(
					'label' => esc_html__( 'Image', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dct-media img',
							'border_styles' => '%%order_class%% .dct-media img',
						),
					),
				),
				'inner'   => array(
					'label' => esc_html__( 'Inner Card', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dct-testimonial-inner',
							'border_styles' => '%%order_class%% .dct-testimonial-inner',
						),
					),
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .dct-media img',
					),
				),
				'inner'   => array(
					'label' => esc_html__( 'Inner Card', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => '%%order_class%% .dct-testimonial-inner',
					),
				),
			),
		);
	}

	/**
	 * Plain Content fields (up to 5 testimonials). sortable_list is unreliable in the Visual Builder
	 * for PHP-only modules, so we use standard field types Divi always renders.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	protected function dct_get_plain_testimonial_fields() {
		$common = array(
			'option_category' => 'basic_option',
			'tab_slug'        => 'general',
			'toggle_slug'     => 'main_content',
		);

		$fields = array();

		for ( $i = 1; $i <= 5; $i++ ) {
			/* translators: %d: testimonial index 1–5 */
			$prefix = sprintf( esc_html__( 'Testimonial %d', 'divi-custom-testimonial' ), $i );

			$fields[ 'dct_t' . $i . '_image' ] = array_merge(
				$common,
				array(
					'label' => sprintf(
						/* translators: 1: block label, 2: field name */
						esc_html__( '%1$s — %2$s', 'divi-custom-testimonial' ),
						$prefix,
						esc_html__( 'Image', 'divi-custom-testimonial' )
					),
					'type' => 'upload',
				)
			);

			$fields[ 'dct_t' . $i . '_quote' ] = array_merge(
				$common,
				array(
					'label' => sprintf(
						esc_html__( '%1$s — %2$s', 'divi-custom-testimonial' ),
						$prefix,
						esc_html__( 'Testimonial text', 'divi-custom-testimonial' )
					),
					'type' => 'textarea',
				)
			);

			$fields[ 'dct_t' . $i . '_author' ] = array_merge(
				$common,
				array(
					'label' => sprintf(
						esc_html__( '%1$s — %2$s', 'divi-custom-testimonial' ),
						$prefix,
						esc_html__( 'Author name', 'divi-custom-testimonial' )
					),
					'type' => 'text',
				)
			);

			$fields[ 'dct_t' . $i . '_readmore_text' ] = array_merge(
				$common,
				array(
					'label'   => sprintf(
						esc_html__( '%1$s — %2$s', 'divi-custom-testimonial' ),
						$prefix,
						esc_html__( 'Read more button text', 'divi-custom-testimonial' )
					),
					'type'    => 'text',
					'default' => 'Read More',
				)
			);

			$fields[ 'dct_t' . $i . '_readmore_url' ] = array_merge(
				$common,
				array(
					'label' => sprintf(
						esc_html__( '%1$s — %2$s', 'divi-custom-testimonial' ),
						$prefix,
						esc_html__( 'Read more button link', 'divi-custom-testimonial' )
					),
					'type' => 'text',
				)
			);

			$fields[ 'dct_t' . $i . '_readmore_new_tab' ] = array_merge(
				$common,
				array(
					'label'   => sprintf(
						esc_html__( '%1$s — %2$s', 'divi-custom-testimonial' ),
						$prefix,
						esc_html__( 'Open button link in new tab', 'divi-custom-testimonial' )
					),
					'type'    => 'yes_no_button',
					'options' => array(
						'on'  => esc_html__( 'Yes', 'divi-custom-testimonial' ),
						'off' => esc_html__( 'No', 'divi-custom-testimonial' ),
					),
					'default' => 'off',
				)
			);
		}

		return $fields;
	}

	/**
	 * Module field definitions.
	 *
	 * @return array
	 */
	public function get_fields() {
		return array_merge(
			$this->dct_get_plain_testimonial_fields(),
			array(
			'accent_color'        => array(
				'label'           => esc_html__( 'Accent Color', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Fallback accent when icon or button colors are left empty.', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '#8dc65f',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'quote_icon_color'    => array(
				'label'           => esc_html__( 'Quote Icon Color', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Leave empty to use the accent color.', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'quote_text_color'    => array(
				'label'           => esc_html__( 'Quote Text Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '#333333',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'author_text_color'   => array(
				'label'           => esc_html__( 'Author Text Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '#a8a8a8',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'button_bg_color'     => array(
				'label'           => esc_html__( 'Button Background', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Leave empty to use the accent color.', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'inner_bg_color'      => array(
				'label'           => esc_html__( 'Inner Card Background', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '#eeeeee',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'outer_bg_color'      => array(
				'label'           => esc_html__( 'Module Background', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Background behind the card and arrows.', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'colors',
				'tab_slug'        => 'advanced',
				'default'         => '',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'image_position'      => array(
				'label'           => esc_html__( 'Image Position', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'options'         => array(
					'left'  => esc_html__( 'Left', 'divi-custom-testimonial' ),
					'right' => esc_html__( 'Right', 'divi-custom-testimonial' ),
				),
				'default'         => 'left',
				'mobile_options'  => true,
			),
			'content_text_align'  => array(
				'label'           => esc_html__( 'Content Text Align', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'options'         => array(
					'left'   => esc_html__( 'Left', 'divi-custom-testimonial' ),
					'center' => esc_html__( 'Center', 'divi-custom-testimonial' ),
					'right'  => esc_html__( 'Right', 'divi-custom-testimonial' ),
				),
				'default'         => 'center',
				'mobile_options'  => true,
			),
			'column_gap'          => array(
				'label'           => esc_html__( 'Gap Between Image & Content', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 120,
					'step' => 1,
				),
				'default'         => '48px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'content_gap'         => array(
				'label'           => esc_html__( 'Gap Between Content Elements', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Space between icon, quote, author, and button.', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 64,
					'step' => 1,
				),
				'default'         => '16px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'inner_min_height'    => array(
				'label'           => esc_html__( 'Inner Card Min Height', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Set to 0 for automatic height.', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 800,
					'step' => 1,
				),
				'default'         => '280px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'wrapper_gap'         => array(
				'label'           => esc_html__( 'Space Around Slider (Arrows)', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 80,
					'step' => 1,
				),
				'default'         => '16px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'slider_transition_ms' => array(
				'label'           => esc_html__( 'Slide Transition (ms)', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'layout',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 1500,
					'step' => 50,
				),
				'default'         => '450',
				'default_unit'    => 'ms',
				'mobile_options'  => false,
			),
			'image_radius'        => array(
				'label'           => esc_html__( 'Image Corner Radius', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'image',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'default'         => '24px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'button_text_color'   => array(
				'label'           => esc_html__( 'Button Text Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'button',
				'tab_slug'        => 'advanced',
				'default'         => '#ffffff',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'button_radius'       => array(
				'label'           => esc_html__( 'Button Corner Radius', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'button',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
				),
				'default'         => '4px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'show_arrows'         => array(
				'label'           => esc_html__( 'Show Arrows', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'navigation',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'No', 'divi-custom-testimonial' ),
				),
				'default'         => 'on',
			),
			'arrow_color'         => array(
				'label'           => esc_html__( 'Arrow Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'navigation',
				'default'         => '#c8c8c8',
				'mobile_options'  => true,
			),
			'arrow_style'         => array(
				'label'           => esc_html__( 'Arrow Style', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'How the previous/next controls look.', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'navigation',
				'options'         => array(
					'chevron' => esc_html__( 'Chevron (filled)', 'divi-custom-testimonial' ),
					'angle'   => esc_html__( 'Angle (thin lines)', 'divi-custom-testimonial' ),
					'minimal' => esc_html__( 'Minimal (‹ ›)', 'divi-custom-testimonial' ),
				),
				'default'         => 'chevron',
			),
			'icon_size'           => array(
				'label'           => esc_html__( 'Quote Icon Size', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'icon',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 20,
					'max'  => 120,
					'step' => 1,
				),
				'default'         => '56px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'content_max_width'   => array(
				'label'           => esc_html__( 'Content Column Max Width', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'icon',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 200,
					'max'  => 900,
					'step' => 1,
				),
				'default'         => '520px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'image_aspect_ratio'  => array(
				'label'           => esc_html__( 'Image Aspect Ratio', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'toggle_slug'     => 'image',
				'tab_slug'        => 'advanced',
				'options'         => array(
					'square' => esc_html__( 'Square (1:1)', 'divi-custom-testimonial' ),
					'4-3'    => esc_html__( '4:3', 'divi-custom-testimonial' ),
					'3-2'    => esc_html__( '3:2', 'divi-custom-testimonial' ),
					'auto'   => esc_html__( 'Natural height', 'divi-custom-testimonial' ),
				),
				'default'         => 'square',
				'mobile_options'  => true,
			),
			'image_column_width'  => array(
				'label'           => esc_html__( 'Image Column Width', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Approximate share of the row used by the image.', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'image',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'default'         => '42%',
				'default_unit'    => '%',
				'mobile_options'  => true,
			),
			'image_max_width'     => array(
				'label'           => esc_html__( 'Image Max Width', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'image',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 1000,
					'step' => 1,
				),
				'default'         => '420px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'image_object_fit'    => array(
				'label'           => esc_html__( 'Image Object Fit', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'toggle_slug'     => 'image',
				'tab_slug'        => 'advanced',
				'options'         => array(
					'cover'    => esc_html__( 'Cover', 'divi-custom-testimonial' ),
					'contain'  => esc_html__( 'Contain', 'divi-custom-testimonial' ),
					'fill'     => esc_html__( 'Fill', 'divi-custom-testimonial' ),
					'none'     => esc_html__( 'None', 'divi-custom-testimonial' ),
					'scale-down' => esc_html__( 'Scale Down', 'divi-custom-testimonial' ),
				),
				'default'         => 'cover',
				'mobile_options'  => true,
			),
			'button_padding_vertical' => array(
				'label'           => esc_html__( 'Button Padding Top & Bottom', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'button',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'default'         => '10px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'button_padding_horizontal' => array(
				'label'           => esc_html__( 'Button Padding Left & Right', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'button',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'default'         => '28px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'button_border_width' => array(
				'label'           => esc_html__( 'Button Border Width', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'button',
				'tab_slug'        => 'advanced',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 16,
					'step' => 1,
				),
				'default'         => '0px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'button_border_color' => array(
				'label'           => esc_html__( 'Button Border Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'field_configuration',
				'toggle_slug'     => 'button',
				'tab_slug'        => 'advanced',
				'default'         => '',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'arrow_icon_size'     => array(
				'label'           => esc_html__( 'Arrow Icon Size', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'navigation',
				'tab_slug'        => 'general',
				'range_settings'  => array(
					'min'  => 6,
					'max'  => 40,
					'step' => 1,
				),
				'default'         => '12px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			'nav_button_size'     => array(
				'label'           => esc_html__( 'Arrow Touch Area', 'divi-custom-testimonial' ),
				'description'     => esc_html__( 'Width and height of the previous/next buttons.', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'navigation',
				'tab_slug'        => 'general',
				'range_settings'  => array(
					'min'  => 28,
					'max'  => 80,
					'step' => 1,
				),
				'default'         => '44px',
				'default_unit'    => 'px',
				'mobile_options'  => true,
			),
			)
		);
	}

	/**
	 * Read a module prop with optional default.
	 *
	 * @param string $key     Prop key (desktop).
	 * @param string $default Default when empty.
	 * @return string
	 */
	protected function dct_prop( $key, $default = '' ) {
		if ( ! isset( $this->props[ $key ] ) ) {
			return $default;
		}
		$val = $this->props[ $key ];
		if ( is_string( $val ) ) {
			$val = trim( $val );
		}
		if ( $val === '' || null === $val ) {
			return $default;
		}
		return (string) $val;
	}

	/**
	 * Prop for a responsive breakpoint (Divi stores _tablet / _phone suffixes).
	 *
	 * @param string $key     Base prop key.
	 * @param string $device  desktop|tablet|phone.
	 * @param string $default Default when empty.
	 * @return string
	 */
	protected function dct_prop_device( $key, $device, $default = '' ) {
		if ( 'desktop' === $device ) {
			return $this->dct_prop( $key, $default );
		}
		$suffix = 'tablet' === $device ? '_tablet' : '_phone';
		$k      = $key . $suffix;
		if ( ! isset( $this->props[ $k ] ) ) {
			return $default;
		}
		$val = $this->props[ $k ];
		if ( is_string( $val ) ) {
			$val = trim( $val );
		}
		if ( $val === '' || null === $val ) {
			return $default;
		}
		return (string) $val;
	}

	/**
	 * Image / text alignment classes for responsive layout.
	 *
	 * @param string $prop   Field name (image_position or content_text_align).
	 * @param string $prefix Class prefix (img or txt).
	 * @return string Space-separated classes.
	 */
	protected function dct_responsive_layout_classes( $prop, $prefix ) {
		$defaults = array(
			'image_position'     => 'left',
			'content_text_align' => 'center',
		);
		$base = isset( $defaults[ $prop ] ) ? $defaults[ $prop ] : 'left';

		$d = $this->dct_prop( $prop, $base );
		if ( 'image_position' === $prop ) {
			$d = in_array( $d, array( 'left', 'right' ), true ) ? $d : 'left';
		} else {
			$d = in_array( $d, array( 'left', 'center', 'right' ), true ) ? $d : 'center';
		}

		$t = $this->dct_prop_device( $prop, 'tablet', '' );
		if ( '' === $t ) {
			$t = $d;
		}
		if ( 'image_position' === $prop ) {
			$t = in_array( $t, array( 'left', 'right' ), true ) ? $t : $d;
		} else {
			$t = in_array( $t, array( 'left', 'center', 'right' ), true ) ? $t : $d;
		}

		$p = $this->dct_prop_device( $prop, 'phone', '' );
		if ( '' === $p ) {
			$p = $t;
		}
		if ( 'image_position' === $prop ) {
			$p = in_array( $p, array( 'left', 'right' ), true ) ? $p : $t;
		} else {
			$p = in_array( $p, array( 'left', 'center', 'right' ), true ) ? $p : $t;
		}

		$map = array(
			'left'   => 'l',
			'right'  => 'r',
			'center' => 'c',
		);

		return sprintf(
			'dct-%1$s-d-%2$s dct-%1$s-t-%3$s dct-%1$s-p-%4$s',
			esc_attr( $prefix ),
			esc_attr( isset( $map[ $d ] ) ? $map[ $d ] : 'l' ),
			esc_attr( isset( $map[ $t ] ) ? $map[ $t ] : 'l' ),
			esc_attr( isset( $map[ $p ] ) ? $map[ $p ] : 'l' )
		);
	}

	/**
	 * Build full CSS custom properties for desktop (all defaults applied).
	 *
	 * @return array<string, string>
	 */
	protected function dct_style_vars_desktop_map() {
		$accent = $this->dct_prop( 'accent_color', '#8dc65f' );

		$icon_c = $this->dct_prop( 'quote_icon_color', '' );
		if ( '' === $icon_c ) {
			$icon_c = $accent;
		}

		$btn_bg = $this->dct_prop( 'button_bg_color', '' );
		if ( '' === $btn_bg ) {
			$btn_bg = $accent;
		}

		$btn_border_c = $this->dct_prop( 'button_border_color', '' );
		if ( '' === $btn_border_c ) {
			$btn_border_c = 'transparent';
		}

		$outer = $this->dct_prop( 'outer_bg_color', '' );
		if ( '' === $outer ) {
			$outer = 'transparent';
		}

		$trans = $this->dct_prop( 'slider_transition_ms', '450' );
		$trans = preg_replace( '/[^0-9.]/', '', (string) $trans );
		if ( '' === $trans ) {
			$trans = '450';
		}

		$min_h = $this->dct_prop( 'inner_min_height', '280px' );
		if ( '0' === $min_h || '0px' === $min_h ) {
			$min_h = '0px';
		}

		return array(
			'--dct-accent'      => $accent,
			'--dct-icon-color'  => $icon_c,
			'--dct-quote'       => $this->dct_prop( 'quote_text_color', '#333333' ),
			'--dct-author'      => $this->dct_prop( 'author_text_color', '#a8a8a8' ),
			'--dct-btn-bg'      => $btn_bg,
			'--dct-inner-bg'    => $this->dct_prop( 'inner_bg_color', '#eeeeee' ),
			'--dct-outer-bg'    => $outer,
			'--dct-btn-text'    => $this->dct_prop( 'button_text_color', '#ffffff' ),
			'--dct-arrow'       => $this->dct_prop( 'arrow_color', '#c8c8c8' ),
			'--dct-img-radius'  => $this->dct_prop( 'image_radius', '24px' ),
			'--dct-btn-radius'  => $this->dct_prop( 'button_radius', '4px' ),
			'--dct-icon-size'   => $this->dct_prop( 'icon_size', '56px' ),
			'--dct-content-max' => $this->dct_prop( 'content_max_width', '520px' ),
			'--dct-column-gap'  => $this->dct_prop( 'column_gap', '48px' ),
			'--dct-content-gap' => $this->dct_prop( 'content_gap', '16px' ),
			'--dct-inner-min-h' => $min_h,
			'--dct-wrapper-gap' => $this->dct_prop( 'wrapper_gap', '16px' ),
			'--dct-image-basis' => $this->dct_prop( 'image_column_width', '42%' ),
			'--dct-image-max'   => $this->dct_prop( 'image_max_width', '420px' ),
			'--dct-object-fit'  => $this->dct_prop( 'image_object_fit', 'cover' ),
			'--dct-btn-py'      => $this->dct_prop( 'button_padding_vertical', '10px' ),
			'--dct-btn-px'      => $this->dct_prop( 'button_padding_horizontal', '28px' ),
			'--dct-btn-bw'      => $this->dct_prop( 'button_border_width', '0px' ),
			'--dct-btn-bc'      => $btn_border_c,
			'--dct-arrow-chev'  => $this->dct_prop( 'arrow_icon_size', '12px' ),
			'--dct-nav-hit'     => $this->dct_prop( 'nav_button_size', '44px' ),
			'--dct-slide-ms'    => $trans . 'ms',
		);
	}

	/**
	 * Partial overrides for tablet / phone (only props set for that breakpoint).
	 *
	 * @param string $device tablet|phone.
	 * @return array<string, string>
	 */
	protected function dct_style_vars_responsive_map( $device ) {
		if ( ! in_array( $device, array( 'tablet', 'phone' ), true ) ) {
			return array();
		}

		$g = function ( $key ) use ( $device ) {
			return $this->dct_prop_device( $key, $device, '' );
		};

		$out = array();

		$map = array(
			'accent_color'        => '--dct-accent',
			'quote_text_color'    => '--dct-quote',
			'author_text_color'   => '--dct-author',
			'inner_bg_color'      => '--dct-inner-bg',
			'button_text_color'   => '--dct-btn-text',
			'arrow_color'         => '--dct-arrow',
			'image_radius'        => '--dct-img-radius',
			'button_radius'       => '--dct-btn-radius',
			'icon_size'           => '--dct-icon-size',
			'content_max_width'   => '--dct-content-max',
			'column_gap'          => '--dct-column-gap',
			'content_gap'         => '--dct-content-gap',
			'wrapper_gap'         => '--dct-wrapper-gap',
			'image_column_width'  => '--dct-image-basis',
			'image_max_width'     => '--dct-image-max',
			'image_object_fit'    => '--dct-object-fit',
			'button_padding_vertical'   => '--dct-btn-py',
			'button_padding_horizontal' => '--dct-btn-px',
			'button_border_width' => '--dct-btn-bw',
			'arrow_icon_size'     => '--dct-arrow-chev',
			'nav_button_size'     => '--dct-nav-hit',
		);

		foreach ( $map as $prop => $var ) {
			$val = $g( $prop );
			if ( '' !== $val ) {
				$out[ $var ] = $val;
			}
		}

		$outer = $g( 'outer_bg_color' );
		if ( '' !== $outer ) {
			$out['--dct-outer-bg'] = $outer;
		}

		$btn_border = $g( 'button_border_color' );
		if ( '' !== $btn_border ) {
			$out['--dct-btn-bc'] = $btn_border;
		}

		$min_h = $g( 'inner_min_height' );
		if ( '' !== $min_h ) {
			if ( '0' === $min_h || '0px' === $min_h ) {
				$min_h = '0px';
			}
			$out['--dct-inner-min-h'] = $min_h;
		}

		$trans = $g( 'slider_transition_ms' );
		if ( '' !== $trans ) {
			$trans = preg_replace( '/[^0-9.]/', '', (string) $trans );
			if ( '' !== $trans ) {
				$out['--dct-slide-ms'] = $trans . 'ms';
			}
		}

		$accent = $g( 'accent_color' );
		$icon_c = $g( 'quote_icon_color' );
		$btn_bg = $g( 'button_bg_color' );

		if ( '' !== $icon_c ) {
			$out['--dct-icon-color'] = $icon_c;
		} elseif ( '' !== $accent ) {
			$out['--dct-icon-color'] = $accent;
		}

		if ( '' !== $btn_bg ) {
			$out['--dct-btn-bg'] = $btn_bg;
		} elseif ( '' !== $accent ) {
			$out['--dct-btn-bg'] = $accent;
		}

		return $out;
	}

	/**
	 * Inline style string for desktop variables.
	 *
	 * @return string
	 */
	protected function dct_style_vars_inline() {
		$parts = array();
		foreach ( $this->dct_style_vars_desktop_map() as $k => $v ) {
			$parts[] = sprintf( '%s:%s', esc_attr( $k ), esc_attr( $v ) );
		}
		return implode( ';', $parts );
	}

	/**
	 * Extra CSS for tablet/phone variable overrides.
	 *
	 * @param string $order_class Unique module class (e.g. et_pb_dct_custom_testimonial_0).
	 * @return string Safe CSS.
	 */
	protected function dct_responsive_var_css( $order_class ) {
		if ( '' === $order_class ) {
			return '';
		}

		$safe     = preg_replace( '/[^a-zA-Z0-9_-]/', '', $order_class );
		$selector = '.' . $safe . ' .dct-testimonial';

		$out = '';

		$packs = array(
			array(
				'max'    => 980,
				'device' => 'tablet',
			),
			array(
				'max'    => 767,
				'device' => 'phone',
			),
		);

		foreach ( $packs as $pack ) {
			$map = $this->dct_style_vars_responsive_map( $pack['device'] );
			if ( empty( $map ) ) {
				continue;
			}
			$decls = array();
			foreach ( $map as $var => $val ) {
				$decls[] = sprintf( '%s:%s', esc_attr( $var ), esc_attr( $val ) );
			}
			if ( empty( $decls ) ) {
				continue;
			}
			$out .= sprintf(
				'@media (max-width:%dpx){%s{%s}}',
				(int) $pack['max'],
				$selector,
				implode( ';', $decls )
			);
		}

		return $out;
	}

	/**
	 * Read a slide row value. New keys use tst_* prefix; legacy keys (image, quote, …) still work for old saves.
	 *
	 * @param array  $slide   One slide from sortable_list JSON.
	 * @param string $new_key Preferred key (e.g. tst_quote).
	 * @param string $old_key Legacy key (e.g. quote).
	 * @param string $default Default when both missing.
	 * @return string
	 */
	protected function dct_slide_prop( $slide, $new_key, $old_key, $default = '' ) {
		if ( ! is_array( $slide ) ) {
			return $default;
		}
		if ( array_key_exists( $new_key, $slide ) ) {
			return (string) $slide[ $new_key ];
		}
		if ( array_key_exists( $old_key, $slide ) ) {
			return (string) $slide[ $old_key ];
		}
		return $default;
	}

	/**
	 * New-tab flag for a slide (tst_url_new_window or url_new_window).
	 *
	 * @param array $slide Slide row.
	 * @return bool
	 */
	protected function dct_slide_new_tab( $slide ) {
		if ( ! is_array( $slide ) ) {
			return false;
		}
		if ( array_key_exists( 'tst_url_new_window', $slide ) ) {
			return 'on' === $slide['tst_url_new_window'];
		}
		if ( array_key_exists( 'url_new_window', $slide ) ) {
			return 'on' === $slide['url_new_window'];
		}
		return false;
	}

	/**
	 * Build slide rows from plain Content fields (dct_t1_* … dct_t5_*).
	 *
	 * @return array<int, array<string, string>>
	 */
	protected function dct_slides_from_plain_fields() {
		$slides = array();

		for ( $i = 1; $i <= 5; $i++ ) {
			$img    = isset( $this->props[ 'dct_t' . $i . '_image' ] ) ? trim( (string) $this->props[ 'dct_t' . $i . '_image' ] ) : '';
			$quote  = isset( $this->props[ 'dct_t' . $i . '_quote' ] ) ? trim( (string) $this->props[ 'dct_t' . $i . '_quote' ] ) : '';
			$author = isset( $this->props[ 'dct_t' . $i . '_author' ] ) ? trim( (string) $this->props[ 'dct_t' . $i . '_author' ] ) : '';

			if ( '' === $img && '' === $quote && '' === $author ) {
				continue;
			}

			$btn = isset( $this->props[ 'dct_t' . $i . '_readmore_text' ] ) ? trim( (string) $this->props[ 'dct_t' . $i . '_readmore_text' ] ) : '';
			if ( '' === $btn ) {
				$btn = 'Read More';
			}

			$url = isset( $this->props[ 'dct_t' . $i . '_readmore_url' ] ) ? trim( (string) $this->props[ 'dct_t' . $i . '_readmore_url' ] ) : '';

			$new_tab = isset( $this->props[ 'dct_t' . $i . '_readmore_new_tab' ] ) && 'on' === $this->props[ 'dct_t' . $i . '_readmore_new_tab' ];

			$slides[] = array(
				'tst_image'          => $img,
				'tst_quote'          => $quote,
				'tst_author'         => $author,
				'tst_button_text'    => $btn,
				'tst_button_url'     => $url,
				'tst_url_new_window' => $new_tab ? 'on' : 'off',
			);
		}

		return $slides;
	}

	/**
	 * Get slides from props (plain fields first, then legacy sortable JSON).
	 *
	 * @return array<int, array<string, string>>
	 */
	protected function dct_get_slides() {
		$from_plain = $this->dct_slides_from_plain_fields();
		if ( ! empty( $from_plain ) ) {
			return $from_plain;
		}

		$slides = isset( $this->props['slides'] ) ? $this->props['slides'] : '';

		if ( is_string( $slides ) && $slides !== '' ) {
			$decoded = json_decode( $slides, true );
			if ( JSON_ERROR_NONE === json_last_error() && is_array( $decoded ) ) {
				return $decoded;
			}
		}

		if ( is_array( $slides ) ) {
			return $slides;
		}

		return array();
	}

	/**
	 * Render module output.
	 *
	 * @param array  $attrs       Attributes.
	 * @param string $content     Inner content.
	 * @param string $render_slug Slug.
	 * @return string
	 */
	public function render( $attrs, $content = null, $render_slug = null ) {
		wp_enqueue_style( 'dct-custom-testimonial' );
		wp_enqueue_script( 'dct-custom-testimonial' );

		$slides = $this->dct_get_slides();

		if ( empty( $slides ) ) {
			return sprintf(
				'<div class="dct-empty">%s</div>',
				esc_html__( 'Add testimonials in the module settings.', 'divi-custom-testimonial' )
			);
		}

		$show_arrows = isset( $this->props['show_arrows'] ) ? $this->props['show_arrows'] : 'on';
		$aspect      = isset( $this->props['image_aspect_ratio'] ) ? $this->props['image_aspect_ratio'] : 'square';

		$aspect_class = 'dct-aspect--square';
		if ( '4-3' === $aspect ) {
			$aspect_class = 'dct-aspect--4-3';
		} elseif ( '3-2' === $aspect ) {
			$aspect_class = 'dct-aspect--3-2';
		} elseif ( 'auto' === $aspect ) {
			$aspect_class = 'dct-aspect--auto';
		}

		$style_vars = $this->dct_style_vars_inline();

		$order_class = isset( $this->props['order_class'] ) ? $this->props['order_class'] : '';

		$layout_classes = trim(
			$this->dct_responsive_layout_classes( 'image_position', 'img' ) . ' ' .
			$this->dct_responsive_layout_classes( 'content_text_align', 'txt' )
		);

		$slides_html = '';
		foreach ( $slides as $index => $slide ) {
			$image    = $this->dct_slide_prop( $slide, 'tst_image', 'image', '' );
			$quote    = $this->dct_slide_prop( $slide, 'tst_quote', 'quote', '' );
			$author   = $this->dct_slide_prop( $slide, 'tst_author', 'author', '' );
			$btn_text = $this->dct_slide_prop( $slide, 'tst_button_text', 'button_text', '' );
			if ( '' === $btn_text ) {
				$btn_text = 'Read More';
			}
			$btn_url    = $this->dct_slide_prop( $slide, 'tst_button_url', 'button_url', '' );
			$url_target = $this->dct_slide_new_tab( $slide ) ? '_blank' : '_self';
			$rel         = '_blank' === $url_target ? 'noopener noreferrer' : '';

			$img_tag = '';
			if ( $image ) {
				$img_tag = sprintf(
					'<img src="%1$s" alt="%2$s" loading="lazy" decoding="async" />',
					esc_url( $image ),
					esc_attr( wp_strip_all_tags( $author ) )
				);
			}

			$button_html = '';
			if ( $btn_url ) {
				$button_html = sprintf(
					'<a class="dct-read-more" href="%1$s" target="%2$s" rel="%3$s">%4$s</a>',
					esc_url( $btn_url ),
					esc_attr( $url_target ),
					esc_attr( $rel ),
					esc_html( $btn_text )
				);
			} elseif ( $btn_text ) {
				$button_html = sprintf(
					'<span class="dct-read-more dct-read-more--static">%s</span>',
					esc_html( $btn_text )
				);
			}

			$slides_html .= sprintf(
				'<div class="dct-slide" data-slide-index="%6$d" role="group" aria-roledescription="slide" aria-label="%7$s">
					<div class="dct-testimonial-inner">
						<div class="dct-media %5$s">%1$s</div>
						<div class="dct-content">
							<div class="dct-quote-icon" aria-hidden="true">
								<svg width="1em" height="1em" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" focusable="false"><path d="M14 32c-2.5-4-4-8.5-4-13 0-6 3.5-10 9-10 5 0 8 3.5 8 8.5 0 9-6 17.5-15 24l-6-3c6-5 10-11 11-16-.8.3-1.7.5-2.5.5-2.8 0-4.5-1.8-4.5-4.5 0-2.5 2-4.5 4.5-4.5 3 0 5 2.2 5 5.5 0 4-2.5 8.5-6 13.5zm22 0c-2.5-4-4-8.5-4-13 0-6 3.5-10 9-10 5 0 8 3.5 8 8.5 0 9-6 17.5-15 24l-6-3c6-5 10-11 11-16-.8.3-1.7.5-2.5.5-2.8 0-4.5-1.8-4.5-4.5 0-2.5 2-4.5 4.5-4.5 3 0 5 2.2 5 5.5 0 4-2.5 8.5-6 13.5z" fill="currentColor"/></svg>
							</div>
							<div class="dct-quote-text">%2$s</div>
							<div class="dct-author">%3$s</div>
							%4$s
						</div>
					</div>
				</div>',
				$img_tag, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built safely above.
				wp_kses_post( nl2br( esc_html( $quote ) ) ),
				esc_html( $author ),
				$button_html, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in sprintf above.
				esc_attr( $aspect_class ),
				(int) $index,
				/* translators: %d: slide number */
				esc_attr( sprintf( __( 'Slide %d', 'divi-custom-testimonial' ), (int) $index + 1 ) )
			);
		}

		$arrow_style = isset( $this->props['arrow_style'] ) ? $this->props['arrow_style'] : 'chevron';
		$arrow_styles = array( 'chevron', 'angle', 'minimal' );
		if ( ! in_array( $arrow_style, $arrow_styles, true ) ) {
			$arrow_style = 'chevron';
		}

		$prev_btn = '';
		$next_btn = '';
		if ( 'on' === $show_arrows && count( $slides ) > 1 ) {
			if ( 'minimal' === $arrow_style ) {
				$prev_inner = '<span class="dct-nav__minimal" aria-hidden="true">&#8249;</span>';
				$next_inner = '<span class="dct-nav__minimal" aria-hidden="true">&#8250;</span>';
			} elseif ( 'angle' === $arrow_style ) {
				$prev_inner = '<span class="dct-nav__angle" aria-hidden="true"></span>';
				$next_inner = '<span class="dct-nav__angle dct-nav__angle--next" aria-hidden="true"></span>';
			} else {
				$prev_inner = '<span class="dct-nav__chev" aria-hidden="true"></span>';
				$next_inner = '<span class="dct-nav__chev" aria-hidden="true"></span>';
			}

			$prev_btn = sprintf(
				'<button type="button" class="dct-nav dct-nav--prev dct-nav--style-%1$s" aria-label="%2$s">%3$s</button>',
				esc_attr( $arrow_style ),
				esc_attr__( 'Previous testimonial', 'divi-custom-testimonial' ),
				$prev_inner // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static HTML spans.
			);
			$next_btn = sprintf(
				'<button type="button" class="dct-nav dct-nav--next dct-nav--style-%1$s" aria-label="%2$s">%3$s</button>',
				esc_attr( $arrow_style ),
				esc_attr__( 'Next testimonial', 'divi-custom-testimonial' ),
				$next_inner // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			);
		}

		$slide_count = count( $slides );

		$responsive_css = $this->dct_responsive_var_css( $order_class );

		$out = sprintf(
			'<div class="dct-testimonial %6$s" data-dct-slider data-dct-slide-count="%5$d" style="%1$s">%2$s<div class="dct-viewport"><div class="dct-track">%3$s</div></div>%4$s</div>',
			esc_attr( $style_vars ),
			$prev_btn, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$slides_html, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$next_btn, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			(int) $slide_count,
			esc_attr( $layout_classes )
		);

		if ( '' !== $responsive_css ) {
			$out .= '<style type="text/css">' . $responsive_css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in builder.
		}

		return $out;
	}
}

new DCT_Custom_Testimonial_Module();
