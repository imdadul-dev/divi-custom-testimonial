<?php
/**
 * Divi module: Media Testimonial Slider.
 *
 * @package DiviCustomTestimonial
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Media Testimonial Slider module.
 */
class DCT_Media_Testimonial_Slider_Module extends ET_Builder_Module {

	/**
	 * Module slug (shortcode: et_pb_{slug}).
	 *
	 * @var string
	 */
	public $slug = 'dct_media_testimonial_slider';

	/**
	 * Visual Builder support.
	 *
	 * @var string
	 */
	public $vb_support = 'on';

	/**
	 * Main CSS selector for advanced fields.
	 *
	 * @var string
	 */
	public $main_css_element = '%%order_class%%';

	/**
	 * Module init.
	 */
	public function init() {
		$this->name      = esc_html__( 'Media Testimonial Slider', 'divi-custom-testimonial' );
		$this->plural    = esc_html__( 'Media Testimonial Sliders', 'divi-custom-testimonial' );
		$this->icon_path = DCT_PLUGIN_DIR . 'includes/modules/icon.svg';
	}

	/**
	 * Settings modal toggles.
	 *
	 * @return array
	 */
	public function get_settings_modal_toggles() {
		$toggles = parent::get_settings_modal_toggles();

		if ( ! is_array( $toggles ) ) {
			$toggles = array();
		}

		if ( ! isset( $toggles['general'] ) || ! is_array( $toggles['general'] ) ) {
			$toggles['general'] = array();
		}

		if ( ! isset( $toggles['general']['toggles'] ) || ! is_array( $toggles['general']['toggles'] ) ) {
			$toggles['general']['toggles'] = array();
		}

		$toggles['general']['toggles']['dct_slides'] = array(
			'title'    => esc_html__( 'Slides', 'divi-custom-testimonial' ),
			'priority' => 15,
		);

		$toggles['general']['toggles']['dct_design'] = array(
			'title'    => esc_html__( 'Layout & Colors', 'divi-custom-testimonial' ),
			'priority' => 20,
		);

		$toggles['general']['toggles']['dct_slider'] = array(
			'title'    => esc_html__( 'Slider', 'divi-custom-testimonial' ),
			'priority' => 25,
		);

		$toggles['general']['toggles']['dct_video'] = array(
			'title'    => esc_html__( 'Video & Motion', 'divi-custom-testimonial' ),
			'priority' => 30,
		);

		return $toggles;
	}

	/**
	 * Advanced fields (fonts, button, spacing).
	 *
	 * @return array
	 */
	public function get_advanced_fields_config() {
		return array(
			'fonts'          => array(
				'quote'    => array(
					'label' => esc_html__( 'Quote', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .dct-mts__quote",
					),
				),
				'author'   => array(
					'label' => esc_html__( 'Author', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .dct-mts__author-name",
					),
				),
				'subtitle' => array(
					'label' => esc_html__( 'Subtitle', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .dct-mts__author-subtitle",
					),
				),
			),
			'button'         => array(
				'button' => array(
					'label' => esc_html__( 'Button', 'divi-custom-testimonial' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .dct-mts__button.et_pb_button",
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main' => "{$this->main_css_element}",
				),
			),
		);
	}

	/**
	 * Field definitions.
	 *
	 * @return array
	 */
	public function get_fields() {
		return array(
			'slides'                    => array(
				'label'           => esc_html__( 'Slides', 'divi-custom-testimonial' ),
				'type'            => 'sortable_list',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'dct_slides',
				'default'         => wp_json_encode(
					array(
						array(
							'media_type'      => 'image',
							'image'           => '',
							'video_url'       => '',
							'quote_text'      => esc_html__( 'Your testimonial quote goes here.', 'divi-custom-testimonial' ),
							'author_name'     => esc_html__( 'Author Name', 'divi-custom-testimonial' ),
							'author_subtitle' => esc_html__( 'Company / Role', 'divi-custom-testimonial' ),
							'button_text'     => esc_html__( 'Read more', 'divi-custom-testimonial' ),
							'button_url'      => '#',
						),
					)
				),
				'options'         => array(
					'new_slide' => array(
						'add_button_text' => esc_html__( 'Add Slide', 'divi-custom-testimonial' ),
						'item_name'       => esc_html__( 'Slide', 'divi-custom-testimonial' ),
						'item_settings'   => array(
							'media_type'      => array(
								'label'   => esc_html__( 'Media Type', 'divi-custom-testimonial' ),
								'type'    => 'select',
								'options' => array(
									'image' => esc_html__( 'Image', 'divi-custom-testimonial' ),
									'video' => esc_html__( 'Video', 'divi-custom-testimonial' ),
								),
								'default' => 'image',
							),
							'image'           => array(
								'label'              => esc_html__( 'Image', 'divi-custom-testimonial' ),
								'type'               => 'upload',
								'upload_button_text' => esc_html__( 'Upload', 'divi-custom-testimonial' ),
								'choose_text'        => esc_html__( 'Choose Image', 'divi-custom-testimonial' ),
								'update_text'        => esc_html__( 'Update Image', 'divi-custom-testimonial' ),
								'show_if'            => array(
									'media_type' => 'image',
								),
							),
							'video_url'       => array(
								'label'       => esc_html__( 'Video URL', 'divi-custom-testimonial' ),
								'type'        => 'text',
								'description' => esc_html__( 'YouTube, Vimeo, or direct file (mp4/webm).', 'divi-custom-testimonial' ),
								'show_if'     => array(
									'media_type' => 'video',
								),
							),
							'quote_text'      => array(
								'label' => esc_html__( 'Quote Text', 'divi-custom-testimonial' ),
								'type'  => 'textarea',
							),
							'author_name'     => array(
								'label' => esc_html__( 'Author Name', 'divi-custom-testimonial' ),
								'type'  => 'text',
							),
							'author_subtitle' => array(
								'label' => esc_html__( 'Author Subtitle', 'divi-custom-testimonial' ),
								'type'  => 'text',
							),
							'button_text'     => array(
								'label' => esc_html__( 'Button Text', 'divi-custom-testimonial' ),
								'type'  => 'text',
							),
							'button_url'      => array(
								'label' => esc_html__( 'Button URL', 'divi-custom-testimonial' ),
								'type'  => 'text',
							),
						),
					),
				),
			),
			'media_position'            => array(
				'label'           => esc_html__( 'Media Position', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_design',
				'default'         => 'left',
				'options'         => array(
					'left'  => esc_html__( 'Media Left', 'divi-custom-testimonial' ),
					'right' => esc_html__( 'Media Right', 'divi-custom-testimonial' ),
				),
			),
			'text_alignment'              => array(
				'label'           => esc_html__( 'Text Alignment', 'divi-custom-testimonial' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_design',
				'default'         => 'left',
				'options'         => function_exists( 'et_builder_get_text_orientation_options' )
					? et_builder_get_text_orientation_options( array( 'justified' ) )
					: array(
						'left'   => esc_html__( 'Left', 'divi-custom-testimonial' ),
						'center' => esc_html__( 'Center', 'divi-custom-testimonial' ),
						'right'  => esc_html__( 'Right', 'divi-custom-testimonial' ),
					),
			),
			'quote_icon_color'          => array(
				'label'           => esc_html__( 'Quote Icon Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_design',
				'default'         => '#c5a47e',
				'custom_color'    => true,
			),
			'content_text_color'        => array(
				'label'           => esc_html__( 'Quote & Meta Text Color', 'divi-custom-testimonial' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_design',
				'custom_color'    => true,
			),
			'slider_autoplay'           => array(
				'label'           => esc_html__( 'Autoplay', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_slider',
				'default'         => 'off',
				'options'         => array(
					'on'  => esc_html__( 'On', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'Off', 'divi-custom-testimonial' ),
				),
			),
			'slider_autoplay_speed'     => array(
				'label'           => esc_html__( 'Autoplay Speed (ms)', 'divi-custom-testimonial' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_slider',
				'default'         => '5000',
				'range_settings'  => array(
					'min'  => '1000',
					'max'  => '20000',
					'step' => '500',
				),
				'validate_unit'   => false,
				'show_if'         => array(
					'slider_autoplay' => 'on',
				),
			),
			'slider_loop'               => array(
				'label'           => esc_html__( 'Loop', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_slider',
				'default'         => 'on',
				'options'         => array(
					'on'  => esc_html__( 'On', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'Off', 'divi-custom-testimonial' ),
				),
			),
			'slider_effect'             => array(
				'label'           => esc_html__( 'Transition', 'divi-custom-testimonial' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_slider',
				'default'         => 'slide',
				'options'         => array(
					'slide' => esc_html__( 'Slide', 'divi-custom-testimonial' ),
					'fade'  => esc_html__( 'Fade', 'divi-custom-testimonial' ),
				),
			),
			'slider_arrows'             => array(
				'label'           => esc_html__( 'Show Arrows', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_slider',
				'default'         => 'on',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'No', 'divi-custom-testimonial' ),
				),
			),
			'slider_dots'               => array(
				'label'           => esc_html__( 'Show Dots', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_slider',
				'default'         => 'on',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'No', 'divi-custom-testimonial' ),
				),
			),
			'show_video_play_overlay'   => array(
				'label'           => esc_html__( 'Video Play Button Overlay', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_video',
				'default'         => 'on',
				'options'         => array(
					'on'  => esc_html__( 'On', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'Off', 'divi-custom-testimonial' ),
				),
			),
			'enable_video_lightbox'     => array(
				'label'           => esc_html__( 'Open Video in Lightbox', 'divi-custom-testimonial' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'toggle_slug'     => 'dct_video',
				'default'         => 'on',
				'options'         => array(
					'on'  => esc_html__( 'On', 'divi-custom-testimonial' ),
					'off' => esc_html__( 'Off', 'divi-custom-testimonial' ),
				),
			),
		);
	}

	/**
	 * Enqueue Swiper and frontend assets when the module is used.
	 */
	public function enqueue_scripts() {
		parent::enqueue_scripts();

		wp_enqueue_style(
			'dct-swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			array(),
			'11.1.0'
		);

		wp_enqueue_script(
			'dct-swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			array(),
			'11.1.0',
			true
		);

		wp_enqueue_style(
			'dct-mts-frontend',
			DCT_PLUGIN_URL . 'assets/css/frontend.css',
			array( 'dct-swiper' ),
			DCT_VERSION
		);

		wp_enqueue_script(
			'dct-mts-frontend',
			DCT_PLUGIN_URL . 'assets/js/frontend.js',
			array( 'dct-swiper' ),
			DCT_VERSION,
			true
		);

		wp_localize_script(
			'dct-mts-frontend',
			'dctMtsL10n',
			array(
				'closeLabel' => __( 'Close', 'divi-custom-testimonial' ),
				'videoLabel' => __( 'Video', 'divi-custom-testimonial' ),
			)
		);
	}

	/**
	 * Parse sortable list / JSON slides into array.
	 *
	 * @param mixed $raw Raw attribute value.
	 * @return array<int, array<string, string>>
	 */
	protected function parse_slides( $raw ) {
		if ( empty( $raw ) ) {
			return array();
		}

		if ( is_string( $raw ) ) {
			$decoded = json_decode( $raw, true );
			if ( JSON_ERROR_NONE === json_last_error() && is_array( $decoded ) ) {
				return $decoded;
			}
			return array();
		}

		if ( is_array( $raw ) ) {
			return $raw;
		}

		return array();
	}

	/**
	 * Build image HTML for slide.
	 *
	 * @param string $image Image URL or attachment ID.
	 * @return string
	 */
	protected function get_slide_image_html( $image ) {
		$image = is_string( $image ) ? trim( $image ) : '';

		if ( '' === $image ) {
			return '';
		}

		if ( ctype_digit( $image ) ) {
			$html = wp_get_attachment_image(
				(int) $image,
				'large',
				false,
				array(
					'class'   => 'dct-mts__img',
					'loading' => 'lazy',
					'alt'     => '',
				)
			);
			return $html ? $html : '';
		}

		return sprintf(
			'<img class="dct-mts__img" src="%1$s" alt="" loading="lazy" decoding="async" />',
			esc_url( $image )
		);
	}

	/**
	 * Get oEmbed or video tag for slide video URL.
	 *
	 * @param string $url Video URL.
	 * @return string
	 */
	protected function get_slide_video_embed( $url ) {
		$url = is_string( $url ) ? trim( $url ) : '';
		if ( '' === $url ) {
			return '';
		}

		$embed = wp_oembed_get(
			$url,
			array(
				'width'  => 1280,
				'height' => 720,
			)
		);

		if ( $embed ) {
			return $embed;
		}

		if ( preg_match( '/\.(mp4|webm|ogg)$/i', $url ) ) {
			return sprintf(
				'<video class="dct-mts__video-el" controls playsinline preload="metadata" src="%s"></video>',
				esc_url( $url )
			);
		}

		return '';
	}

	/**
	 * Render module output.
	 *
	 * @param array  $attrs       Attributes.
	 * @param string $content     Inner content.
	 * @param string $render_slug Render slug.
	 * @return string
	 */
	public function render( $attrs, $content = null, $render_slug = '' ) {
		$slides = $this->parse_slides( isset( $attrs['slides'] ) ? $attrs['slides'] : '' );

		if ( empty( $slides ) ) {
			return '';
		}

		$media_position   = isset( $attrs['media_position'] ) && 'right' === $attrs['media_position'] ? 'right' : 'left';
		$text_align       = isset( $attrs['text_alignment'] ) ? $attrs['text_alignment'] : 'left';
		$quote_icon_color = isset( $attrs['quote_icon_color'] ) ? $attrs['quote_icon_color'] : '';
		$content_color    = isset( $attrs['content_text_color'] ) ? $attrs['content_text_color'] : '';

		$autoplay       = isset( $attrs['slider_autoplay'] ) && 'on' === $attrs['slider_autoplay'];
		$autoplay_speed = isset( $attrs['slider_autoplay_speed'] ) ? absint( $attrs['slider_autoplay_speed'] ) : 5000;
		$loop           = ! isset( $attrs['slider_loop'] ) || 'on' === $attrs['slider_loop'];
		$effect         = isset( $attrs['slider_effect'] ) && 'fade' === $attrs['slider_effect'] ? 'fade' : 'slide';
		$show_arrows    = ! isset( $attrs['slider_arrows'] ) || 'on' === $attrs['slider_arrows'];
		$show_dots      = ! isset( $attrs['slider_dots'] ) || 'on' === $attrs['slider_dots'];

		$play_overlay   = ! isset( $attrs['show_video_play_overlay'] ) || 'on' === $attrs['show_video_play_overlay'];
		$video_lightbox = ! isset( $attrs['enable_video_lightbox'] ) || 'on' === $attrs['enable_video_lightbox'];

		$order_class = isset( $attrs['order_class'] ) ? sanitize_html_class( $attrs['order_class'] ) : 'dct-mts';
		$uid         = wp_unique_id( 'dct-mts-' );

		$nav_prev_class = $order_class . '-prev-' . $uid;
		$nav_next_class = $order_class . '-next-' . $uid;
		$pagination_id  = $order_class . '-pag-' . $uid;

		$swiper_config = array(
			'loop'          => $loop,
			'speed'         => 600,
			'slidesPerView' => 1,
			'effect'        => $effect,
			'a11y'          => array(
				'enabled' => true,
			),
			'keyboard'      => array(
				'enabled' => true,
			),
			'watchSlidesProgress' => true,
		);

		if ( $autoplay ) {
			$swiper_config['autoplay'] = array(
				'delay'                => max( 1000, $autoplay_speed ),
				'disableOnInteraction' => false,
				'pauseOnMouseEnter'    => true,
			);
		} else {
			$swiper_config['autoplay'] = false;
		}

		if ( $show_arrows ) {
			$swiper_config['navigation'] = array(
				'prevEl' => '.' . $nav_prev_class,
				'nextEl' => '.' . $nav_next_class,
			);
		}

		if ( $show_dots ) {
			$swiper_config['pagination'] = array(
				'el'        => '#' . $pagination_id,
				'clickable' => true,
			);
		}

		if ( 'fade' === $effect ) {
			$swiper_config['fadeEffect'] = array(
				'crossFade' => true,
			);
		}

		$style_vars = array();
		if ( '' !== $quote_icon_color ) {
			$style_vars[] = '--dct-mts-quote-icon:' . esc_attr( $quote_icon_color );
		}
		if ( '' !== $content_color ) {
			$style_vars[] = '--dct-mts-content-color:' . esc_attr( $content_color );
		}

		$style_attr = ! empty( $style_vars ) ? ' style="' . esc_attr( implode( ';', $style_vars ) ) . '"' : '';

		$wrapper_classes = array(
			'dct-mts',
			'dct-mts--media-' . $media_position,
			'dct-mts--text-' . sanitize_html_class( $text_align ),
		);

		ob_start();
		?>
		<div
			class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>"
			<?php echo $style_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above ?>
			data-dct-play-overlay="<?php echo esc_attr( $play_overlay ? '1' : '0' ); ?>"
			data-dct-video-lightbox="<?php echo esc_attr( $video_lightbox ? '1' : '0' ); ?>"
		>
			<div
				class="dct-mts__swiper swiper"
				data-swiper-config="<?php echo esc_attr( wp_json_encode( $swiper_config ) ); ?>"
				role="region"
				aria-roledescription="carousel"
				aria-label="<?php esc_attr_e( 'Testimonials', 'divi-custom-testimonial' ); ?>"
			>
				<div class="swiper-wrapper">
					<?php
					foreach ( $slides as $index => $slide ) {
						$slide      = is_array( $slide ) ? $slide : array();
						$media_type = isset( $slide['media_type'] ) && 'video' === $slide['media_type'] ? 'video' : 'image';

						$quote      = isset( $slide['quote_text'] ) ? $slide['quote_text'] : '';
						$author     = isset( $slide['author_name'] ) ? $slide['author_name'] : '';
						$subtitle   = isset( $slide['author_subtitle'] ) ? $slide['author_subtitle'] : '';
						$btn_text   = isset( $slide['button_text'] ) ? $slide['button_text'] : '';
						$btn_url    = isset( $slide['button_url'] ) ? $slide['button_url'] : '';
						$video_url  = isset( $slide['video_url'] ) ? $slide['video_url'] : '';
						$image_val  = isset( $slide['image'] ) ? $slide['image'] : '';

						$slide_label = sprintf(
							/* translators: %d: slide number */
							__( 'Slide %d', 'divi-custom-testimonial' ),
							(int) $index + 1
						);
						?>
						<div
							class="swiper-slide dct-mts__slide"
							role="group"
							aria-roledescription="slide"
							aria-label="<?php echo esc_attr( $slide_label ); ?>"
						>
							<div class="dct-mts__inner">
								<div class="dct-mts__media">
									<?php if ( 'image' === $media_type ) : ?>
										<div class="dct-mts__media-inner dct-mts__media-inner--image">
											<?php echo $this->get_slide_image_html( $image_val ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</div>
									<?php else : ?>
										<div
											class="dct-mts__media-inner dct-mts__media-inner--video"
											data-video-url="<?php echo esc_attr( $video_url ); ?>"
										>
											<?php if ( '' !== $video_url && $play_overlay && $video_lightbox ) : ?>
												<button
													type="button"
													class="dct-mts__play"
													aria-label="<?php esc_attr_e( 'Play video', 'divi-custom-testimonial' ); ?>"
												>
													<span class="dct-mts__play-icon" aria-hidden="true"></span>
												</button>
												<div class="dct-mts__embed-store" hidden>
													<?php echo $this->get_slide_video_embed( $video_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												</div>
											<?php else : ?>
												<?php echo $this->get_slide_video_embed( $video_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
								<div class="dct-mts__content">
									<div class="dct-mts__quote-wrap">
										<span class="dct-mts__quote-mark" aria-hidden="true">“</span>
										<div class="dct-mts__quote">
											<?php echo wp_kses_post( wpautop( $quote ) ); ?>
										</div>
									</div>
									<?php if ( '' !== $author || '' !== $subtitle ) : ?>
										<div class="dct-mts__meta">
											<?php if ( '' !== $author ) : ?>
												<div class="dct-mts__author-name"><?php echo esc_html( $author ); ?></div>
											<?php endif; ?>
											<?php if ( '' !== $subtitle ) : ?>
												<div class="dct-mts__author-subtitle"><?php echo esc_html( $subtitle ); ?></div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
									<?php if ( '' !== $btn_text && '' !== $btn_url ) : ?>
										<div class="dct-mts__cta">
											<a class="dct-mts__button et_pb_button" href="<?php echo esc_url( $btn_url ); ?>">
												<?php echo esc_html( $btn_text ); ?>
											</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<?php if ( $show_arrows ) : ?>
					<button
						type="button"
						class="dct-mts__nav dct-mts__nav--prev swiper-button-prev <?php echo esc_attr( $nav_prev_class ); ?>"
						aria-label="<?php esc_attr_e( 'Previous slide', 'divi-custom-testimonial' ); ?>"
					></button>
					<button
						type="button"
						class="dct-mts__nav dct-mts__nav--next swiper-button-next <?php echo esc_attr( $nav_next_class ); ?>"
						aria-label="<?php esc_attr_e( 'Next slide', 'divi-custom-testimonial' ); ?>"
					></button>
				<?php endif; ?>
				<?php if ( $show_dots ) : ?>
					<div
						class="dct-mts__pagination swiper-pagination"
						id="<?php echo esc_attr( $pagination_id ); ?>"
						role="tablist"
						aria-label="<?php esc_attr_e( 'Slides', 'divi-custom-testimonial' ); ?>"
					></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
