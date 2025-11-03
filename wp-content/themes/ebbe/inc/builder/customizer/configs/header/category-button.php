<?php

class Ebbe_Builder_Category_Button {

	public $id = 'category_button';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Category Button', 'ebbe' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_category_button',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_category_button',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'Category Button', 'ebbe' ),
			),

			array(
				'name'    => 'header_category_button_heading',
				'type'    => 'heading',
				'section' => 'header_category_button',
				'title'   => esc_html__( 'The Category Navigation can be populated from Appearance - Menus - Display location - Category Button', 'ebbe' )
			),
			array(
				'name'            => 'ebbe_category_button_placeholder',
				'type'            => 'text',
				'section'         => 'header_category_button',
				'render_callback' => $fn,
				'label'           => esc_html__( 'Placeholder', 'ebbe' ),
				'default'         => esc_html__( 'Catalog', 'ebbe' ),
				'priority'        => 10,
			),

			array(
				'name'            => 'ebbe_category_button_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_category_button',
				'selector'        => ".ebbe_category_button .category_button_wrap",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Button Width', 'ebbe' ),
				'description'     => esc_html__( 'Note: The width can not greater than grid width.', 'ebbe' ),
				'priority'        => 15,
			),

			array(
				'name'            => 'ebbe_category_button_height',
				'type'            => 'slider',
				'device_settings' => true,
				'section'         => 'header_category_button',
				'min'             => 25,
				'step'            => 1,
				'max'             => 100,
				'selector'        => ".ebbe_category_button .category_button_wrap",
				'css_format'      => 'height: {{value}};',
				'label'           => esc_html__( 'Button Height', 'ebbe' ),
				'priority'        => 20,
			),

			array(
				'name'        => 'ebbe_category_button_font_size',
				'type'        => 'typography',
				'section'     => 'header_category_button',
				'selector'    => ".ebbe_category_button .category_button_title",
				'css_format'  => 'typography',
				'label'       => esc_html__( 'Button Text Typography', 'ebbe' ),
				'priority'    => 35,
			),

			array(
				'name'        => 'ebbe_category_button_styling',
				'type'        => 'styling',
				'section'     => 'header_category_button',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Button Styling', 'ebbe' ),
				'selector'    => array(
					'normal'            	=> ".ebbe_category_button .category_button_title",
					'hover'             	=> ".ebbe_category_button .category_button_wrap:hover",
					'normal_text_color' 	=> ".ebbe_category_button .category_button_title",
					'hover_text_color' 		=> ".ebbe_category_button .menu-item > a:hover",
					'normal_bg_color' 		=> ".ebbe_category_button .category_button_wrap",
					'normal_border_style' 	=> ".ebbe_category_button .category_button_wrap",
					'normal_border_width' 	=> ".ebbe_category_button .category_button_wrap",
					'normal_border_color' 	=> ".ebbe_category_button .category_button_wrap",
					'normal_border_radius' 	=> ".ebbe_category_button .category_button_wrap",
					'normal_box_shadow' 	=> ".ebbe_category_button .category_button_wrap",
				),
				'default'     => array(
					'normal' => array(
						'text_color' => '#fff',
						'bg_color'	 => '#5ab210'
					),
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
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
					),
				),
				'priority'        => 40,
			),

		);

		// Item Layout.
		return array_merge( $config, ebbe_header_layout_settings( $this->id, 'header_category_button' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$placeholder = Ebbe()->get_setting( 'ebbe_category_button_placeholder' );
		$placeholder = sanitize_text_field( $placeholder );

		echo '<div class="ebbe_category_button">';
                echo '<button class="category_button_wrap">';
                echo '<span class="category_button_title">'.esc_html($placeholder).'</span></button>';
                echo '<ul class="button_dropdown">';
                    if ( has_nav_menu( 'hb-category-button' ) ) {
                        $defaults = array(
                            'menu'            => '',
                            'container'       => false,
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => 'menu',
                            'menu_id'         => '',
                            'echo'            => true,
                            'fallback_cb'     => false,
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'items_wrap'      => '%3$s',
                            'depth'           => 0,
                            'walker'          => ''
                          );
                          $defaults['theme_location'] = 'hb-category-button';
                          wp_nav_menu( $defaults );
                    }
                echo '</ul>';
        echo '</div>';
	}
}

Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Category_Button() );
