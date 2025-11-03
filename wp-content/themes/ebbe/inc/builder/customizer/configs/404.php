<?php
if ( ! function_exists( 'ebbe_customizer_404_config' ) ) {
	function ebbe_customizer_404_config( $configs ) {

		$section = 'ebbe_not_found';

		$config = array(
			array(
				'name'     => 'not_found_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( '404 Page Settings', 'ebbe' ),
			),

			// Image.
			array(
				'name'  => "ebbe_not_found_404",
				'type'  => 'section',
				'panel' => 'not_found_panel',
				'title' => esc_html__( '404 Image', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_not_found_404_img',
				'type'            => 'image',
				'section'         => 'ebbe_not_found_404',
				'title'           => esc_html__( 'Image for 404 Not found page', 'ebbe' ),
			),

			// Content.
			array(
				'name'  => "ebbe_not_found_404_content",
				'type'  => 'section',
				'panel' => 'not_found_panel',
				'title' => esc_html__( '404 Content', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_page_404_heading',
				'type'            => 'textarea',
				'section'         => 'ebbe_not_found_404_content',
				'title'           => esc_html__( 'Heading', 'ebbe' ),
				'default'         => esc_html__( 'Sorry, this page does not exist!', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_page_404_paragraph',
				'type'            => 'textarea',
				'section'         => 'ebbe_not_found_404_content',
				'title'           => esc_html__( 'Paragraph (sub-heading)', 'ebbe' ),
				'default'         => esc_html__( 'The link you clicked might be corrupted, or the page may have been removed.', 'ebbe' ),
			),

		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'ebbe/customizer/config', 'ebbe_customizer_404_config' );
