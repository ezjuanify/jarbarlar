<?php

class Ebbe_Builder_Item_Compare {

	public $id = 'compare';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'Compare', 'ebbe' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_compare',
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
				'name'     => 'header_compare',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 201,
				'title'    => esc_html__( 'Compare', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_header_compare_link',
				'type'            => 'text',
				'section'         => 'header_compare',
				'theme_supports'  => '',
				'default'         => esc_html__( '#', 'ebbe' ),
				'title'           => esc_html__( 'Compare Page Link', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_header_compare_icon_max_height',
				'type'            => 'slider',
				'section'         => 'header_compare',
				'default'         => array(),
				'max'             => 100,
				'device_settings' => true,
				'title'           => esc_html__( 'Icon Max Height', 'ebbe' ),
				'selector'        => 'format',
				'css_format'      => ".builder-item--compare i { font-size: {{value}}; }",
			),
			array(
				'name'        => 'ebbe_header_compare_styling',
				'type'        => 'styling',
				'section'     => 'header_compare',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Button Styling', 'ebbe' ),
				'description' => esc_html__( 'Only reffered to the "Compare" Button.', 'ebbe' ),
				'selector'    => array(
					'normal'            => ".builder-item--compare a.menu-grid-item",
					'hover'             => ".builder-item--compare a.menu-grid-item:hover"
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
						'bg_color'      => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
						'bg_color'      => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
				),
			),

			array(
				'name'        => "ebbe_header_compare_typography",
				'type'        => 'typography',
				'section'     => "header_compare",
				'title'       => esc_html__( 'Typography', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => ".builder-item--compare .ebbe-header-group-label",
			),
			array(
				'name'  		  => 'ebbe_header_compare_icon',
				'type'  		  => 'icon',
				'section'         => 'header_compare',
				'icon' 			  => 'fa fa-exchange',
				'label' 		  => esc_html__( 'Icon', 'ebbe' ),
			),
			array(
				'name'           => 'ebbe_header_compare__hide_icon',
				'type'           => 'checkbox',
				'section'        => 'header_compare',
				'checkbox_label' => esc_html__( 'Hide icon', 'ebbe' ),
				'css_format'     => 'html_class',
			),
			array(
				'name'           => 'ebbe_header_compare__hide_text',
				'type'           => 'checkbox',
				'section'        => 'header_compare',
				'checkbox_label' => esc_html__( 'Hide text', 'ebbe' ),
				'css_format'     => 'html_class',
			)
		);

		// Item Layout.
		return array_merge( $config, ebbe_header_layout_settings( $this->id, 'header_compare' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$hide_icon = sanitize_text_field( Ebbe()->get_setting( 'ebbe_header_compare__hide_icon' ) );
		$hide_text = sanitize_text_field( ebbe()->get_setting( 'ebbe_header_compare__hide_text' ) );
		$link = sanitize_text_field( ebbe()->get_setting( 'ebbe_header_compare_link' ) );
		$icon = Ebbe()->get_setting( 'ebbe_header_compare_icon');
		if (empty(Ebbe()->get_setting( 'ebbe_header_compare_icon'))) {
			$icon = 'fa fa-exchange';
		} else {
			$icon = $icon['icon'];
		}

		echo '<div class="header-group-wrapper text-center">';
			if(!$hide_icon) {
  				echo '<a class="menu-grid-item" href="'.esc_url($link).'"><i class="'.esc_html($icon).'"></i></a>';
			}
			if(!$hide_text) {
				echo '<div class="header-group">';
		  			echo '<a class="menu-grid-item ebbe-header-group-label" href="'.esc_url($link).'">';
		              	esc_html_e('Compare', 'ebbe');
		            echo '</a>';
		        echo '</div>';
		    }
		echo '</div>';
	}
}

Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Item_Compare() );
