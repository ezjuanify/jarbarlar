<?php

class Ebbe_Builder_Footer extends Ebbe_Customize_Builder_Panel {
	public $id = 'footer';

	function get_config() {
		return array(
			'id'         => 'footer',
			'title'      => esc_html__( 'Footer Builder', 'ebbe' ),
			'control_id' => 'footer_builder_panel',
			'panel'      => 'footer_settings',
			'section'    => 'footer_builder_panel',
			'devices'    => array(
				'desktop' => esc_html__( 'Footer Layout', 'ebbe' ),
			),
		);
	}

	function get_rows_config() {
		return array(
			'main'   => esc_html__( 'Footer Main', 'ebbe' ),
			'bottom' => esc_html__( 'Footer Bottom', 'ebbe' ),
		);
	}

	function customize() {
		$fn     = 'ebbe_customize_render_footer';
		$config = array(
			array(
				'name'     => 'footer_settings',
				'type'     => 'panel',
				'priority' => 98,
				'title'    => esc_html__( 'Footer', 'ebbe' ),
			),

			array(
				'name'  => 'footer_builder_panel',
				'type'  => 'section',
				'panel' => 'footer_settings',
				'title' => esc_html__( 'Footer Builder', 'ebbe' ),
			),

			array(
				'name'                => 'footer_builder_panel',
				'type'                => 'js_raw',
				'section'             => 'footer_builder_panel',
				'theme_supports'      => '',
				'title'               => esc_html__( 'Footer Builder', 'ebbe' ),
				'selector'            => '#site-footer',
				'render_callback'     => $fn,
				'container_inclusive' => true,
			),

		);

		return $config;
	}

	function row_config( $section = false, $section_name = false ) {
		$selector           = '#cb-row--' . str_replace( '_', '-', $section );
		$skin_mode_selector = '.footer--row-inner.' . str_replace( '_', '-', $section ) . '-inner';

		$fn = 'ebbe_customize_render_footer';

		$config = array(
			array(
				'name'           => $section,
				'type'           => 'section',
				'panel'          => 'footer_settings',
				'theme_supports' => '',
				'title'          => $section_name,
			),

			array(
				'name'            => $section . '_layout',
				'type'            => 'select',
				'section'         => $section,
				'title'           => esc_html__( 'Layout', 'ebbe' ),
				'selector'        => $selector,
				'render_callback' => $fn,
				'css_format'      => 'html_class',
				'default'         => 'layout-full-contained',
				'choices'         => array(
					'layout-full-contained' => esc_html__( 'Full width - Contained', 'ebbe' ),
					'layout-fullwidth'      => esc_html__( 'Full Width', 'ebbe' ),
					'layout-contained'      => esc_html__( 'Contained', 'ebbe' ),
				),
			),
			array(
				'name'       => "{$section}_background_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Background Color', 'ebbe' ),
				'selector'   => "{$selector} .footer--row-inner",
				'css_format' => 'background-color: {{value}}',
			),
			array(
				'name'       => "{$section}_title_typography",
				'type'       => 'typography',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Typography', 'ebbe' ),
				'selector'   => "{$selector} .footer--row-inner .widget-title",
				'css_format' => 'typography',
			),
			array(
				'name'       => "{$section}_title_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Title', 'ebbe' ),
				'selector'   => "{$selector} .footer--row-inner .widget-title",
				'css_format' => 'color: {{value}}',
			),
			array(
				'name'       => "{$section}_items_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Items', 'ebbe' ),
				'selector'   => "{$selector} .footer--row-inner .menu-item a",
				'css_format' => 'color: {{value}}',
			),
			array(
				'name'       => "{$section}_items_color_hover",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Menu Items (Hover)', 'ebbe' ),
				'selector'   => "{$selector} .footer--row-inner .menu-item a:hover",
				'css_format' => 'color: {{value}}',
			),
			array(
				'name'       => "{$section}_separator_color",
				'type'       => 'color',
				'section'    => $section,
				'title'      => esc_html__( 'Separator', 'ebbe' ),
				'selector'   => "{$selector} .footer--row-inner .container",
				'css_format' => 'border-color: {{value}}',
			),
			array(
				'name'       	=> "{$section}_mobile_aligment",
				'type'          => 'text_align_no_justify',
				'section'    	=> $section,
				'title'         => esc_html__( 'Mobile Alignment', 'ebbe' ),
				'default'		=> 'left',
				'selector'      => "@media screen and (max-width: 1170px) { {$selector} div",
				'css_format' 	=> "text-align: {{value}};}",	
			),
		);
		$config = apply_filters( 'ebbe/builder/' . $this->id . '/rows/section_configs', $config, $section, $section_name );
		return $config;
	}
}

function ebbe_footer_layout_settings( $item_id, $section ) {

	global $wp_customize;

	if ( is_object( $wp_customize ) ) {
		global $wp_registered_sidebars;
		$name = $section;
		if ( is_array( $wp_registered_sidebars ) ) {
			if ( isset( $wp_registered_sidebars[ $item_id ] ) ) {
				$name = $wp_registered_sidebars[ $item_id ]['name'];
			}
		}
		$wp_customize->add_section(
			$section,
			array(
				'title' => $name,
			)
		);
	}

	if ( function_exists( 'ebbe_header_layout_settings' ) ) {
		return ebbe_header_layout_settings( $item_id, $section, 'ebbe_customize_render_footer', 'footer_' );
	}

	return false;
}

Ebbe_Customize_Layout_Builder()->register_builder( 'footer', new Ebbe_Builder_Footer() );



