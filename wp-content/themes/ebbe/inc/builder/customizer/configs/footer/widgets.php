<?php

class Ebbe_Builder_Item_Footer_Widget_1 {
	public $id = 'footer-1';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 1', 'ebbe' ),
			'id'      => 'footer-1',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-1',
		);
	}

	function customize() {
		return ebbe_footer_layout_settings( 'footer-1', 'sidebar-widgets-footer-1' );
	}
}

class Ebbe_Builder_Item_Footer_Widget_2 {
	public $id = 'footer-2';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 2', 'ebbe' ),
			'id'      => 'footer-2',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-2',
		);
	}

	function customize() {
		return ebbe_footer_layout_settings( 'footer-2', 'sidebar-widgets-footer-2' );
	}
}

class Ebbe_Builder_Item_Footer_Widget_3 {
	public $id = 'footer-3';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 3', 'ebbe' ),
			'id'      => 'footer-3',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-3',
		);
	}

	function customize() {
		return ebbe_footer_layout_settings( 'footer-3', 'sidebar-widgets-footer-3' );
	}
}

class Ebbe_Builder_Item_Footer_Widget_4 {
	public $id = 'footer-4';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 4', 'ebbe' ),
			'id'      => 'footer-4',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-4',
		);
	}

	function customize() {
		return ebbe_footer_layout_settings( 'footer-4', 'sidebar-widgets-footer-4' );
	}
}

class Ebbe_Builder_Item_Footer_Widget_5 {
	public $id = 'footer-5';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 5', 'ebbe' ),
			'id'      => 'footer-5',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-5',
		);
	}

	function customize() {
		return ebbe_footer_layout_settings( 'footer-5', 'sidebar-widgets-footer-5' );
	}
}

class Ebbe_Builder_Item_Footer_Widget_6 { 
	public $id = 'footer-6';

	function item() {
		return array(
			'name'    => esc_html__( 'Footer Sidebar 6', 'ebbe' ),
			'id'      => 'footer-6',
			'width'   => '3',
			'section' => 'sidebar-widgets-footer-6',
		);
	}

	function customize() {
		return ebbe_footer_layout_settings( 'footer-6', 'sidebar-widgets-footer-6' );
	}
}


function ebbe_change_footer_widgets_location( $wp_customize ) {
	for ( $i = 1; $i <= 6; $i ++ ) {
		if ( $wp_customize->get_section( 'sidebar-widgets-footer-' . $i ) ) {
			$wp_customize->get_section( 'sidebar-widgets-footer-' . $i )->panel = 'footer_settings';
		}
	}

}

add_action( 'customize_register', 'ebbe_change_footer_widgets_location', 999 );

/**
 * Always show footer widgets for customize builder
 *
 * @param bool   $active
 * @param string $section
 *
 * @return bool
 */
function ebbe_customize_footer_widgets_show( $active, $section ) {
	if ( strpos( $section->id, 'widgets-footer-' ) ) {
		$active = true;
	}

	return $active;
}

add_filter( 'customize_section_active', 'ebbe_customize_footer_widgets_show', 15, 2 );


/**
 * Display Footer widget
 *
 * @param string $footer_id
 */
function ebbe_builder_footer_widget_item( $footer_id = 'footer-1' ) {
	$show = false;
	if ( is_active_sidebar( $footer_id ) ) {
		echo '<div class="widget-area">';
		dynamic_sidebar( $footer_id );
		$show = true;
		echo '</div>';
	}
}

function ebbe_builder_footer_1_item() {
	ebbe_builder_footer_widget_item( 'footer-1' );
}

function ebbe_builder_footer_2_item() {
	ebbe_builder_footer_widget_item( 'footer-2' );
}

function ebbe_builder_footer_3_item() {
	ebbe_builder_footer_widget_item( 'footer-3' );
}

function ebbe_builder_footer_4_item() {
	ebbe_builder_footer_widget_item( 'footer-4' );
}

function ebbe_builder_footer_5_item() {
	ebbe_builder_footer_widget_item( 'footer-5' );
}

function ebbe_builder_footer_6_item() {
	ebbe_builder_footer_widget_item( 'footer-6' );
}

Ebbe_Customize_Layout_Builder()->register_item( 'footer', new Ebbe_Builder_Item_Footer_Widget_1() );
Ebbe_Customize_Layout_Builder()->register_item( 'footer', new Ebbe_Builder_Item_Footer_Widget_2() );
Ebbe_Customize_Layout_Builder()->register_item( 'footer', new Ebbe_Builder_Item_Footer_Widget_3() );
Ebbe_Customize_Layout_Builder()->register_item( 'footer', new Ebbe_Builder_Item_Footer_Widget_4() );
Ebbe_Customize_Layout_Builder()->register_item( 'footer', new Ebbe_Builder_Item_Footer_Widget_5() );
Ebbe_Customize_Layout_Builder()->register_item( 'footer', new Ebbe_Builder_Item_Footer_Widget_6() );
