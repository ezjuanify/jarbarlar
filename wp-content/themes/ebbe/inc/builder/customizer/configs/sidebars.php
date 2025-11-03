<?php

class Ebbe_Builder_Header_Sidebars {
	public $id = 'header_sidebars';

	function customize() {
		$section = 'header_sidebars';

		return array(
			array(
				'name'     => $section,
				'type'     => 'section',
				'panel'    => 'general_settings_panel',
				'priority' => 299,
				'title'    => esc_html__( 'Sidebars', 'ebbe' ),
			),
			array(
				'name'             => 'ebbe_general_sidebars',
				'type'             => 'repeater',
				'section'        	=> $section,
				'title'            => esc_html__( 'Custom Sidebars', 'ebbe' ),
				'live_title_field' => 'title',
				'default'          => array(
					array(
						'title' => esc_html__( 'Header Burger Sidebar', 'ebbe' ),
					),
				),
				'fields'           => array(
					array(
						'name'  => 'title',
						'type'  => 'text',
						'label' => esc_html__( 'Sidebar Name', 'ebbe' ),
					),
				),
			),
		);
	}
}

Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Header_Sidebars() );
