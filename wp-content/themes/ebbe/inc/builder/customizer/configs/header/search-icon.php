<?php

class Ebbe_Builder_Item_Search_Icon {
	public $id = 'search_icon';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Search Icon', 'ebbe' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '1',
			'section' => 'search_icon',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		// Render callback function.
		$fn       = array( $this, 'render' );
		$selector = ".header-{$this->id}-item";
		$config   = array(
			array(
				'name'  => 'search_icon',
				'type'  => 'section',
				'panel' => 'header_settings',
				'title' => esc_html__( 'Search Icon', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_search_icon_in',
				'type'            => 'select',
				'section'         => 'search_icon',
				'default'         => 'post',
				'title'           => esc_html__( 'Search in:', 'ebbe' ),
				'choices'         => array(
					'post' => esc_html__( 'Blog Posts (Articles)', 'ebbe' ),
					'product'  => esc_html__( 'Products', 'ebbe' ),
				),
			),
			array(
				'name'            => 'ebbe_search_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 5,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector svg",
				'css_format'      => 'height: {{value}}; width: {{value}};',
				'label'           => esc_html__( 'Icon Size', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_search_icon_padding',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 0,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-icon",
				'css_format'      => 'padding: {{value}};',
				'label'           => esc_html__( 'Icon Padding', 'ebbe' ),
			),

			array(
				'name'        => 'ebbe_search_icon_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Icon Styling', 'ebbe' ),
				'description' => esc_html__( 'Search icon styling', 'ebbe' ),
				'selector'    => array(
					'normal'            => "{$selector} .search-icon",
					'hover'             => "{$selector} .search-icon:hover",
					'normal_box_shadow' => "{$selector} .search-icon",
					'normal_text_color' => "{$selector} .search-icon",
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_attachment' => false,
						'bg_repeat'     => false,
						'border_radius' => false,
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name'    => 'ebbe_search_icon_modal_h',
				'type'    => 'heading',
				'section' => 'search_icon',
				'label'   => esc_html__( 'Modal Settings', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_search_icon_placeholder',
				'type'            => 'text',
				'selector'        => "$selector",
				'render_callback' => $fn,
				'section'         => 'search_icon',
				'label'           => esc_html__( 'Placeholder', 'ebbe' ),
				'default'         => esc_html__( 'Search ...', 'ebbe' ),
			),

			array(
				'name'        => 'ebbe_search_icon_form_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Form Styling', 'ebbe' ),
				'description' => esc_html__( 'Form modal styling', 'ebbe' ),
				'selector'    => array(
					'normal'              => "{$selector} .header-search-modal",
					'normal_bg_color'     => "{$selector} .header-search-modal, {$selector} .header-search-modal:before",
					'normal_border_color' => "{$selector} .header-search-modal, {$selector} .header-search-modal:before",
				),
				'default'     => array(
					'normal' => array(
						'border_style' => 'solid',
					),
				),
				'fields'      => array(
					'normal_fields' => array(
						'text_color'    => false, // disable for special field.
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					),
					'hover_fields'  => false,
				),
			),

			array(
				'name'            => 'ebbe_search_icon_modal_height',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 25,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .header-search-form .search-field",
				'css_format'      => 'height: {{value}};',
				'label'           => esc_html__( 'Input Height', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_search_icon_modal_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'selector'        => "$selector .header-search-modal",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Search Modal Width', 'ebbe' ),
			),

			array(
				'name'        => 'ebbe_search_icon_modal_font_size',
				'type'        => 'typography',
				'section'     => 'search_icon',
				'selector'    => "$selector .header-search-form .search-field",
				'css_format'  => 'typography',
				'label'       => esc_html__( 'Input Text Typography', 'ebbe' ),
				'description' => esc_html__( 'Typography for search input', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_search_icon_modal_icon_size',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'search_icon',
				'min'             => 5,
				'step'            => 1,
				'max'             => 100,
				'selector'        => "$selector .search-submit svg",
				'css_format'      => 'height: {{value}}; width: {{value}};',
				'label'           => esc_html__( 'Icon Size', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_search_icon_modal_icon_pos',
				'type'            => 'slider',
				'device_settings' => true,
				'default'         => array(
					'desktop' => array(
						'value' => - 40,
						'unit'  => 'px',
					),
					'tablet'  => array(
						'value' => - 40,
						'unit'  => 'px',
					),
					'mobile'  => array(
						'value' => - 40,
						'unit'  => 'px',
					),
				),
				'section'         => 'search_icon',
				'min'             => - 150,
				'step'            => 1,
				'max'             => 90,
				'selector'        => "$selector .search-submit",
				'css_format'      => 'margin-left: {{value}}; ',
				'label'           => esc_html__( 'Icon Position', 'ebbe' ),
			),

			array(
				'name'        => 'ebbe_search_icon_modal_input_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Input Styling', 'ebbe' ),
				'description' => esc_html__( 'Search input styling', 'ebbe' ),
				'selector'    => array(
					'normal'            => "{$selector} .search-field",
					'hover'             => "{$selector} .search-field:focus",
					'normal_text_color' => "{$selector} .search-field, {$selector} input.search-field::placeholder",
				),
				'default'     => array(
					'normal' => array(
						'border_style' => 'solid',
					),
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'border_radius' => false,
					), // disable hover tab and all fields inside.
				),
			),

			array(
				'name'        => 'ebbe_search_icon_modal_icon_styling',
				'type'        => 'styling',
				'section'     => 'search_icon',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Icon Styling', 'ebbe' ),
				'description' => esc_html__( 'Search input styling', 'ebbe' ),
				'selector'    => array(
					'normal' => "{$selector} .search-submit",
					'hover'  => "{$selector} .search-submit:hover",
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false, // disable for special field.
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'padding'       => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'border_radius' => false,
					), // disable hover tab and all fields inside.
				),
			),

		);

		// Item Layout.
		return array_merge( $config, ebbe_header_layout_settings( $this->id, 'search_icon' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {

		$search_in = Ebbe()->get_setting( 'ebbe_search_icon_in' );
		$placeholder = Ebbe()->get_setting( 'ebbe_search_icon_placeholder' );
		$placeholder = sanitize_text_field( $placeholder );

		echo '<div class="header-' . esc_attr( $this->id ) . '-item item--' . esc_attr( $this->id ) . '">';
		?>
		<a class="search-icon" href="#" aria-label="<?php esc_attr_e( 'open search tool', 'ebbe' ) ?>">
			<span class="ic-search">
				<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21">
					<path fill="currentColor" fill-rule="evenodd" d="M12.514 14.906a8.264 8.264 0 0 1-4.322 1.21C3.668 16.116 0 12.513 0 8.07 0 3.626 3.668.023 8.192.023c4.525 0 8.193 3.603 8.193 8.047 0 2.033-.769 3.89-2.035 5.307l4.999 5.552-1.775 1.597-5.06-5.62zm-4.322-.843c3.37 0 6.102-2.684 6.102-5.993 0-3.31-2.732-5.994-6.102-5.994S2.09 4.76 2.09 8.07c0 3.31 2.732 5.993 6.102 5.993z"></path>
				</svg>
			</span>
			<span class="ic-close">
				<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="612px" height="612px" viewBox="0 0 612 612" fill="currentColor" style="enable-background:new 0 0 612 612;" xml:space="preserve"><g><g id="cross"><g><polygon points="612,36.004 576.521,0.603 306,270.608 35.478,0.603 0,36.004 270.522,306.011 0,575.997 35.478,611.397 306,341.411 576.521,611.397 612,575.997 341.459,306.011 " /></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
			</span>
			<span class="arrow-down"></span>
		</a>
		<div class="header-search-modal-wrapper">
			<form role="search" class="header-search-modal header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label>
					<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'ebbe' ); ?></span>
					<input type="hidden" name="post_type" value="<?php echo esc_attr($search_in); ?>" />
					<input type="search" class="search-field" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'ebbe' ); ?>" />
				</label>
				<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'submit search', 'ebbe' ) ?>">
					<svg aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21">
						<path fill="currentColor" fill-rule="evenodd" d="M12.514 14.906a8.264 8.264 0 0 1-4.322 1.21C3.668 16.116 0 12.513 0 8.07 0 3.626 3.668.023 8.192.023c4.525 0 8.193 3.603 8.193 8.047 0 2.033-.769 3.89-2.035 5.307l4.999 5.552-1.775 1.597-5.06-5.62zm-4.322-.843c3.37 0 6.102-2.684 6.102-5.993 0-3.31-2.732-5.994-6.102-5.994S2.09 4.76 2.09 8.07c0 3.31 2.732 5.993 6.102 5.993z"></path>
					</svg>
				</button>
			</form>
		</div>
		<?php
		echo '</div>';
	}
}

Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Item_Search_Icon() );
