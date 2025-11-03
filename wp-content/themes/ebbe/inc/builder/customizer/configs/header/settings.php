<?php

class Ebbe_Builder_Header_Settings {
	public $id = 'header_settings';

	function customize() {
		$section = 'header_settings';

		return array(
			array(
				'name'     		=> $section,
				'type'     		=> 'section',
				'panel'    		=> 'header_settings',
				'priority' 		=> 299,
				'title'    		=> esc_html__( 'Settings', 'ebbe' ),
			),
			array(
				'name'          => 'ebbe_general_settings_look_htransparent',
				'type'          => 'checkbox',
				'section'   	=> $section,
				'title'         => esc_html__( 'Transparent Header', 'ebbe' ),
				'description'   => esc_html__('Enable or disable Transparent Header', 'ebbe'),
				'default'       => 0,
			),
			array(
				'name'      	=> 'ebbe_is_nav_sticky',
				'type'      	=> 'checkbox',
				'section'   	=> $section,
				'title'     	=> esc_html__( 'Fixed Navigation menu?', 'ebbe' ),
				'description'   => esc_html__('Enable or disable Sticky Header', 'ebbe'),
			),
		);
	}
}

Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Header_Settings() );
// Include Global Section Customizer
require_once get_template_directory() . '/inc/builder/customizer/configs/header/global-section.php';
