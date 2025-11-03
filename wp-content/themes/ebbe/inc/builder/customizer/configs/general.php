<?php
if ( ! function_exists( 'ebbe_customizer_general_settings_config' ) ) {
	function ebbe_customizer_general_settings_config( $configs ) {

		$section = 'ebbe_general_settings';

		$config = array(
			array(
				'name'     => 'general_settings_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'General Settings', 'ebbe' ),
			),

			// Breadcrumbs
			array(
				'name'  => "ebbe_general_settings_breadcrumbs",
				'type'  => 'section',
				'panel' => 'general_settings_panel',
				'title' => esc_html__( 'Breadcrumbs', 'ebbe' ),
			),

			array(
				'name'            => 'ebbe_enable_breadcrumbs',
				'type'            => 'checkbox',
				'section'         => 'ebbe_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Breadcrumbs', 'ebbe' ),
				'description'     => esc_html__('Enable or disable breadcrumbs', 'ebbe'),
				'default'         => 1
			),
			array(
                'name'       	=> 'ebbe_breadcrumbs_delimitator',
                'type'     		=> 'text',
				'section'         => 'ebbe_general_settings_breadcrumbs',
                'title'    		=> esc_html__('Breadcrumbs delimitator', 'ebbe'),
                'description' 	=> esc_html__('(The theme is also compatible with Breadcrumb NavXT plugin, for an enhanced Breadcrumbs / SEO Ready Breadcrumbs feature. Install it and it will automatically replace the default breadcrumbs feature).', 'ebbe'),
                'default'  		=> '/'
            ),
			array(
				'name'    		=> 'ebbe_breadcrumbs_styling_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_general_settings_breadcrumbs',
				'title'   		=> esc_html__( 'Styling', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_breadcrumbs_alignment',
				'type'            => 'text_align_no_justify',
				'section'         => 'ebbe_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Alignment', 'ebbe' ),
				'default'		  => 'left'	
			),
			array(
				'name'            => 'ebbe_breadcrumbs_bg_image',
				'type'            => 'image',
				'section'         => 'ebbe_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Background', 'ebbe' ),
				'description' 	  => esc_html__('(Change the background color of the breadcrumbs with an image.)', 'ebbe'),
				'selector'   	  => ".ebbe-breadcrumbs, .youzify-search-landing-image-container",
				'css_format' 	  => 'background-image: url({{value}});',
			),
			array(
				'name'            => 'ebbe_enable_parallax',
				'type'            => 'checkbox',
				'section'         => 'ebbe_general_settings_breadcrumbs',
				'title'           => esc_html__( 'Parallax', 'ebbe' ),
				'description'     => esc_html__('Parallax on background', 'ebbe'),
				'default'         => 0
			),
			array(
				'name'        => 'ebbe_breadcrumbs_styling',
				'type'        => 'styling',
				'section'     => 'ebbe_general_settings_breadcrumbs',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Styling', 'ebbe' ),
				'selector'    => array(
					'normal'            => ".ebbe-breadcrumbs .row",
					'hover'             => ".ebbe-breadcrumbs:hover"
				),
				'fields'      => array(
					'normal_fields' => array(
						'text_color'    => false,
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
					'hover_fields'  => array(
						'text_color'    => false,
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
				),
			),
			array(
				'name'    		=> 'ebbe_breadcrumbs_title_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_general_settings_breadcrumbs',
				'title'   		=> esc_html__( 'Breadcrumb Title', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_breadcrumbs_title_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_general_settings_breadcrumbs',
				'selector'   	=> 'format',
				'title'      	=> esc_html__( 'Title Color', 'ebbe' ),
				'selector'   	=> ".ebbe-breadcrumbs h2, .ebbe-breadcrumbs h1, .ebbe-breadcrumbs h1 span",
				'css_format' 	=> 'color: {{value}};',
			),
			array(
				'name'        	=> "ebbe_breadcrumbs_title_typo",
				'type'        	=> 'typography',
				'section'     	=> "ebbe_general_settings_breadcrumbs",
				'title'       	=> esc_html__( 'Title Typography', 'ebbe' ),
				'css_format'  	=> 'typography',
				'selector'    	=> ".ebbe-breadcrumbs h2, .ebbe-breadcrumbs h1, .ebbe-breadcrumbs h1 span",
			),
			array(
				'name'    		=> 'ebbe_breadcrumbs_subtitle_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_general_settings_breadcrumbs',
				'title'   		=> esc_html__( 'Breadcrumb Subtitle', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_breadcrumbs_subtitle_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_general_settings_breadcrumbs',
				'selector'   	=> 'format',
				'title'      	=> esc_html__( 'Subtitle Color', 'ebbe' ),
				'selector'   	  => ".ebbe-breadcrumbs .breadcrumb .active, .breadcrumb, .breadcrumb a::after,.ebbe-breadcrumbs .breadcrumb a",
				'css_format' 	  => 'color: {{value}};',
			),
			array(
				'name'        	=> "ebbe_breadcrumbs_subtitle_typo",
				'type'        	=> 'typography',
				'section'     	=> "ebbe_general_settings_breadcrumbs",
				'title'       	=> esc_html__( 'Subtitle Typography', 'ebbe' ),
				'css_format'  	=> 'typography',
				'selector'    	=> ".ebbe-breadcrumbs .breadcrumb .active, .breadcrumb,.ebbe-breadcrumbs .breadcrumb a",
			),
			array(
				'name'    			=> 'ebbe_breadcrumbs_delimitator_heading',
				'type'    			=> 'heading',
				'section' 			=> 'ebbe_general_settings_breadcrumbs',
				'title'   			=> esc_html__( 'Delimitator', 'ebbe' ),
			),
			array(
				'name'       		=> 'ebbe_breadcrumbs_delimitator_color',
				'type'       		=> 'color',
				'section' 			=> 'ebbe_general_settings_breadcrumbs',
				'selector'   		=> 'format',
				'default'			=> 'rgba(0,150,57,0)',
				'title'      		=> esc_html__( 'Delimitator', 'ebbe' ),
				'selector'   	  	=> ".ebbe-breadcrumbs .row",
				'css_format' 	  	=> 'border-color: {{value}};',
			),

			// Preloader
			array(
				'name'  			=> "ebbe_general_settings_preloader",
				'type'  			=> 'section',
				'panel' 			=> 'general_settings_panel',
				'title' 			=> esc_html__( 'Preloader', 'ebbe' ),
			),
			array(
				'name'           	=> 'ebbe_enable_preloader',
				'type'            	=> 'checkbox',
				'section'         	=> 'ebbe_general_settings_preloader',
				'title'           	=> esc_html__( 'Preloader', 'ebbe' ),
				'description'     	=> esc_html__('Enable or disable preloader', 'ebbe'),
				'default'         	=> 0
			),
			array(
				'name'            	=> 'ebbe_preloader_image',
				'type'            	=> 'image',
				'section'         	=> 'ebbe_general_settings_preloader',
				'title'           	=> esc_html__( 'Image', 'ebbe' )
			),
			array(
				'name'            => 'ebbe_preloader_bg_color',
				'type'            => 'color',
				'section'         => 'ebbe_general_settings_preloader',
				'title'           => esc_html__( 'Background Color', 'ebbe' ),
				'default'         => '#000',
				'selector'    	  => ".ebbe_preloader_holder",
				'css_format' 	  => 'background-color: {{value}};'
			),

			// Popup
			array(
				'name'  			=> "ebbe_general_settings_popup",
				'type'  			=> 'section',
				'panel' 			=> 'general_settings_panel',
				'title' 			=> esc_html__( 'Popup', 'ebbe' ),
			),
			array(
				'name'           	=> 'ebbe_enable_popup',
				'type'            	=> 'checkbox',
				'section'         	=> 'ebbe_general_settings_popup',
				'title'           	=> esc_html__( 'Popup', 'ebbe' ),
				'description'     	=> esc_html__('Enable or disable popup', 'ebbe'),
				'default'         	=> 0
			),
			array(
				'name'    			=> 'ebbe_popup_design_heading',
				'type'    			=> 'heading',
				'section' 			=> 'ebbe_general_settings_popup',
				'title'   			=> esc_html__( 'Design', 'ebbe' ),
			),
			array(
				'name'            	=> 'ebbe_popup_image',
				'type'            	=> 'image',
				'section'         	=> 'ebbe_general_settings_popup',
				'title'           	=> esc_html__( 'Image', 'ebbe' ),
				'description' 	  	=> esc_html__('Set your popup image', 'ebbe'),
			),
			array(
				'name'            	=> 'ebbe_popup_content',
				'type'            	=> 'textarea',
				'section'         	=> 'ebbe_general_settings_popup',
				'default'         	=> esc_html__( 'Add custom text here or remove it', 'ebbe' ),
				'title'           	=> esc_html__( 'Content', 'ebbe' ),
				'description'     	=> esc_html__( 'Set texts and images to the content.', 'ebbe' ),
			),
			array(
				'name'    			=> 'ebbe_popup_settings_heading',
				'type'    			=> 'heading',
				'section' 			=> 'ebbe_general_settings_popup',
				'title'   			=> esc_html__( 'Settings', 'ebbe' ),
			),
			array(
                'name'       		=> 'ebbe_popup_url',
                'type'     			=> 'text',
                'title'    			=> esc_html__('URL', 'ebbe'),
                'section'       	=> 'ebbe_general_settings_popup',
            ),
			array(
				'name'            	=> 'ebbe_popup_expiring_cookie',
				'type'            	=> 'select',
				'section'         	=> 'ebbe_general_settings_popup',
				'title'           	=> esc_html__('Expiring Cookie', 'ebbe' ),
				'description'     	=> esc_html__('Select the days for when the cookies to expire.', 'ebbe'),
				'choices'         	=> array(
					'1' 	=> esc_html__( '1 Day', 'ebbe' ),
					'3'  	=> esc_html__( '3 Days', 'ebbe' ),
					'7'  	=> esc_html__( '1 Week', 'ebbe' ),
					'30'  	=> esc_html__( '1 Month', 'ebbe' ),
					'3000' 	=> esc_html__( 'Be Remembered', 'ebbe' ),
				),
				'default'   		=> '1',
			),
			array(
				'name'            	=> 'ebbe_popup_show_time',
				'type'            	=> 'select',
				'section'         	=> 'ebbe_general_settings_popup',
				'title'           	=> esc_html__('Show Popup', 'ebbe' ),
				'description'     	=> esc_html__('Select a specific time to show the popup.', 'ebbe'),
				'choices'         	=> array(
					'5000' 	=> esc_html__( '5 seconds', 'ebbe' ),
					'10000' => esc_html__( '10 seconds', 'ebbe' ),
					'20000' => esc_html__( '20 seconds', 'ebbe' )
				),
				'default'   		=> '5000',
			),

            // Contact Information
			array(
				'name'  => "ebbe_general_settings_contact",
				'type'  => 'section',
				'panel' => 'general_settings_panel',
				'title' => esc_html__( 'Contact Information', 'ebbe' ),
			),

			array(
                'name'       	=> 'ebbe_contact_address',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Address', 'ebbe'),
                'section'       => 'ebbe_general_settings_contact',
            ),
            array(
                'name'       	=> 'ebbe_contact_email',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Email', 'ebbe'),
                'section'       => 'ebbe_general_settings_contact',
            ),
            array(
                'name'       	=> 'ebbe_contact_phone',
                'type'     		=> 'text',
                'title'    		=> esc_html__('Phone', 'ebbe'),
                'section'       => 'ebbe_general_settings_contact',
            ),

			//Back to top
			array(
				'name'  => "ebbe_general_settings_back_to_top",
				'type'  => 'section',
				'panel' => 'general_settings_panel',
				'title' => esc_html__( 'Back to Top', 'ebbe' ),
			),
			array(
				'name'            => 'ebbe_backtotop_status',
				'type'            => 'checkbox',
				'section'         => 'ebbe_general_settings_back_to_top',
				'title'           => esc_html__( 'Back to Top Button Status', 'ebbe' ),
				'default'         => 1
			),
			array(
				'name'            => 'ebbe_backtotop_bg_color',
				'type'            => 'color',
				'section'         => 'ebbe_general_settings_back_to_top',
				'title'           => esc_html__( 'Background Color', 'ebbe' ),
				'default'         => '#2695FF',
				'selector'    	  => ".ebbe-back-to-top",
				'css_format' 	  => 'background-color: {{value}};'
			),
			array(
				'name'            => 'ebbe_backtotop_icon_color',
				'type'            => 'color',
				'section'         => 'ebbe_general_settings_back_to_top',
				'title'           => esc_html__( 'Icon Color', 'ebbe' ),
				'default'         => '#FFF',
				'selector'    	  => ".ebbe-back-to-top, .ebbe-back-to-top.ebbe-is-visible:visited",
				'css_format' 	  => 'color: {{value}};'
			),
			array(
				'name'            => 'ebbe_backtotop_bg_color_hover',
				'type'            => 'color',
				'section'         => 'ebbe_general_settings_back_to_top',
				'title'           => esc_html__( 'Background Color (Hover)', 'ebbe' ),
				'default'         => '#222',
				'selector'    	  => ".ebbe-back-to-top:hover",
				'css_format' 	  => 'background-color: {{value}};'
			),
			array(
				'name'            => 'ebbe_backtotop_icon_color_hover',
				'type'            => 'color',
				'section'         => 'ebbe_general_settings_back_to_top',
				'title'           => esc_html__( 'Icon Color (Hover)', 'ebbe' ),
				'default'         => '#FFF',
				'selector'    	  => ".ebbe-back-to-top:hover",
				'css_format' 	  => 'color: {{value}};'
			),
			array(
				'name'            	=> 'ebbe_backtotop_radius',
				'type'            	=> 'css_ruler',
				'section'    		=> 'ebbe_general_settings_back_to_top',
				'device_settings' 	=> true,
				'css_format'      	=> array(
					'top'    => 'border-bottom-right-radius: {{value}};',
					'right'  => 'border-top-right-radius: {{value}};',
					'bottom' => 'border-bottom-left-radius: {{value}};',
					'left'   => 'border-top-left-radius: {{value}};',
				),
				'selector'        	=> "body .ebbe-back-to-top",
				'label'           	=> esc_html__( 'Border Radius', 'ebbe' ),
			),
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'ebbe/customizer/config', 'ebbe_customizer_general_settings_config' );
