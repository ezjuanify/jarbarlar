<?php
if ( ! function_exists( 'ebbe_customizer_social_media_config' ) ) {
	function ebbe_customizer_social_media_config( $configs ) {

		$section = 'ebbe_social_media';

		$config = array(
			array(
				'name'     => 'social_media_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Social Media', 'ebbe' ),
			),

			// Social Shares Tab.
			array(
				'name'  => "ebbe_social_media_shares",
				'type'  => 'section',
				'panel' => 'social_media_panel',
				'title' => esc_html__( 'Social Shares', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_twitter',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Twitter', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_facebook',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Facebook', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_whatsapp',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Whatsapp', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_pinterest',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Pinterest', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_linkedin',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Linkedin', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_telegram',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Telegram', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_shares_email',
				'type'            => 'checkbox',
				'section'         => 'ebbe_social_media_shares',
				'title'           => esc_html__( 'Email', 'ebbe' ),
			),

			// Social Links Tab.
			array(
				'name'  => "ebbe_social_media_links",
				'type'  => 'section',
				'panel' => 'social_media_panel',
				'title' => esc_html__( 'Social Links', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_social_media_links_twitter',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Twitter', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_facebook',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Facebook', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_youtube',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Youtube', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_pinterest',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Pinterest', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_linkedin',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Linkedin', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_skype',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Skype', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_instagram',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Instagram', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_dribble',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Dribble', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_social_media_links_vimeo',
				'type'            => 'text',
				'section'         => 'ebbe_social_media_links',
				'title'           => esc_html__( 'Vimeo', 'ebbe' ),
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'ebbe/customizer/config', 'ebbe_customizer_social_media_config' );
