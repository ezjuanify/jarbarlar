<?php
if ( ! function_exists( 'ebbe_customizer_blog_config' ) ) {
	function ebbe_customizer_blog_config( $configs ) {

		$section = 'ebbe_blog';

		$config = array(
			// Panel
			array(
				'name'     => 'blog_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Blog Settings', 'ebbe' ),
			),

			// I. Blog Archive
			array(
				'name'  => "ebbe_blog_archive",
				'type'  => 'section',
				'panel' => 'blog_panel',
				'title' => esc_html__( 'Blog Archive', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_blog_archive_layout',
				'type'            => 'radio_group',
				'section'         => 'ebbe_blog_archive',
				'default'         => 'right-sidebar',
				'title'           => esc_html__( 'Blog Layout', 'ebbe' ),
				'choices'         => array(
					'left-sidebar'  	=> esc_html__( 'Left Sidebar', 'ebbe' ),
					'no-sidebar' 		=> esc_html__( 'Fullwidth', 'ebbe' ),
					'right-sidebar'  	=> esc_html__( 'Right Sidebar', 'ebbe' ),
				),
			),
			array(
				'name'        => 'ebbe_blog_article_card_styling',
				'type'        => 'styling',
				'section'     => 'ebbe_blog_archive',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Article Card Styling', 'ebbe' ),
				'selector'    => '.ebbe-article-wrapper .ebbe-article-inner',
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					)
				)
			),

			// II. Single Post
			array(
				'name'  => "ebbe_blog_single",
				'type'  => 'section',
				'panel' => 'blog_panel',
				'title' => esc_html__( 'Blog Single Article', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_blog_single_layout',
				'type'            => 'radio_group',
				'section'         => 'ebbe_blog_single',
				'default'         => 'no-sidebar',
				'title'           => esc_html__( 'Single Blog Layout', 'ebbe' ),
				'choices'         => array(
					'left-sidebar'  	=> esc_html__( 'Left Sidebar', 'ebbe' ),
					'no-sidebar' 		=> esc_html__( 'Fullwidth', 'ebbe' ),
					'right-sidebar'  	=> esc_html__( 'Right Sidebar', 'ebbe' ),
				),
			),
			array(
				'name'            => 'ebbe_blog_single_featured_image',
				'type'            => 'checkbox',
				'section'         => 'ebbe_blog_single',
				'default'         => 1,
				'title'           => esc_html__( 'Featured Image', 'ebbe' ),
				'description'     => esc_html__( 'Show or Hide the featured image from blog post page', 'ebbe' ),
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'ebbe/customizer/config', 'ebbe_customizer_blog_config' );
