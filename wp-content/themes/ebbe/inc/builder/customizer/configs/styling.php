<?php
if ( ! function_exists( 'ebbe_customizer_styling_config' ) ) {
	function ebbe_customizer_styling_config( $configs ) {
		$ebbe_buttons = ebbe_get_customizer_buttons_styling();
		$ebbe_buttons_hover = ebbe_get_customizer_buttons_hover_styling();
		$ebbe_fields = ebbe_get_customizer_fields_styling();
		$ebbe_fields_focus = ebbe_get_customizer_fields_styling_focus();
		$section = 'ebbe_styling_settings';
		$config = array(
			array(
				'name'     => 'styling_settings_panel',
				'type'     => 'panel',
				'priority' => 22,
				'title'    => esc_html__( 'Styling Settings', 'ebbe' ),
			),

			// I. General Tab
			array(
				'name'  => "ebbe_styling_settings_color",
				'type'  => 'section',
				'panel' => 'styling_settings_panel',
				'title' => esc_html__( 'General Site Colors', 'ebbe' ),
			),
			array(
				'name'    		=> 'ebbe_styling_settings_color_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_color',
				'title'   		=> esc_html__( 'Links Color Option', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_color_links_normal',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'		=> '#222',
				'title'      	=> esc_html__( 'Regular', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_color_links_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'title'      	=> esc_html__( 'Hover', 'ebbe' ),
			),
			array(
				'name'    => 'ebbe_styling_settings_color_links_weight',
				'type'    => 'select',
				'section' => 'ebbe_styling_settings_color',
				'label'   => esc_html__( 'Weight', 'ebbe' ),
				'choices' => array(
					'default'   => esc_html__( 'Default', 'ebbe' ),
					'bold' 		=> esc_html__( 'Bold', 'ebbe' ),
					'100'  		=> esc_html__( '100', 'ebbe' ),
					'200'  		=> esc_html__( '200', 'ebbe' ),
					'300' 		=> esc_html__( '300', 'ebbe' ),
					'400' 		=> esc_html__( '400', 'ebbe' ),
					'500' 		=> esc_html__( '500', 'ebbe' ),
					'600' 		=> esc_html__( '600', 'ebbe' ),
					'700' 		=> esc_html__( '700', 'ebbe' ),
					'800' 		=> esc_html__( '800', 'ebbe' ),
				)
			),

			// 1. Main colors and Background
			array(
				'name'    		=> 'ebbe_styling_settings_color_bg_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_color',
				'title'   		=> esc_html__( 'Main colors & Background', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_color_text_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'   	=> '#2695ff',
				'title'      	=> esc_html__( 'Text color', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_main_bg_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'   	=> '#2695ff',
				'title'      	=> esc_html__( 'Background color', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_main_border_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'   	=> '#2695ff',
				'title'      	=> esc_html__( 'Border color', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_main_bg_color_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'   	=> '#ffffff',
				'title'      	=> esc_html__( 'Background color (hover)', 'ebbe' ),
			),

			// 2. Text selection
			array(
				'name'    		=> 'ebbe_styling_settings_text_selection_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_color',
				'title'   		=> esc_html__( 'Text Selection Color & Background', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_selection_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'   	=> '#ffffff',
				'title'      	=> esc_html__( 'Color', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_selection_bg',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'   	=> 'format',
				'default'   	=> '#2695ff',
				'title'      	=> esc_html__( 'Background color', 'ebbe' ),
			),
			array(
				'name'    		=> 'ebbe_styling_settings_paragraph_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_color',
				'title'   		=> esc_html__( 'Body & Paragraphs Color', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_color_body_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_color',
				'selector'    	=> 'body',
				'css_format' 	=> 'color: {{value}};',
				'default'		=> '#6a6b76',
				'title'      	=> esc_html__( 'Color', 'ebbe' ),
			),

			// 3. Menu Styling Tab
			array(
				'name'  => "ebbe_styling_settings_navigation",
				'type'  => 'section',
				'panel' => 'styling_settings_panel',
				'title' => esc_html__( 'Primary Menu Styling', 'ebbe' ),
			),
			// a. Main Navigation
			array(
				'name'    		=> 'ebbe_styling_settings_main_navigation_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'title'   		=> esc_html__( 'Main Navigation', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_main_text_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'   	=> '.builder-item--primary-menu .nav-menu-desktop .menu>li>a',
				'css_format' 	=> 'color: {{value}};',
				'title'      	=> esc_html__( 'Text Color', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_main_text_color_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'   	=> '.builder-item--primary-menu .nav-menu-desktop .menu>li>a:hover',
				'css_format' 	=> 'color: {{value}};',
				'title'      	=> esc_html__( 'Hover Text Color', 'ebbe' ),
			),
			// b. Submenu Navigation
			array(
				'name'    		=> 'ebbe_styling_settings_submenu_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'title'   		=> esc_html__( 'Submenus Styling', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_submenu_background',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'    	=> ".nav-menu-desktop .sub-menu li a",
				'css_format' 	=> 'background-color: {{value}};',
				'title'      	=> esc_html__( 'Background Color', 'ebbe' ),
				'default'   	=> '#FFF',
			),
			array(
				'name'       	=> 'ebbe_styling_settings_submenu_text_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'    	=> ".nav-menu-desktop .sub-menu li a",
				'css_format' 	=> 'color: {{value}};',
				'title'      	=> esc_html__( 'Text Color', 'ebbe' ),
				'default'   	=> '#484848',
			),
			array(
				'name'       	=> 'ebbe_styling_settings_submenu_background_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'    	=> ".nav-menu-desktop .sub-menu li a:hover",
				'css_format' 	=> 'background-color: {{value}};',
				'title'      	=> esc_html__( 'Hover Background Color', 'ebbe' ),
				'default'   	=> '#FFF',
			),
			array(
				'name'       	=> 'ebbe_styling_settings_submenu_text_color_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'    	=> ".nav-menu-desktop .sub-menu li a:hover",
				'css_format' 	=> 'color: {{value}};',
				'title'      	=> esc_html__( 'Hover Text Color', 'ebbe' ),
				'default'   	=> '#2695ff',
			),
			array(
				'name'       	=> 'ebbe_styling_settings_submenu_border_color_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_navigation',
				'selector'    	=> ".nav-menu-desktop .sub-menu li",
				'css_format' 	=> 'border-bottom: 1px solid {{value}} !important;',
				'title'      	=> esc_html__( 'Border Color', 'ebbe' ),
				'default'   	=> '#ddd',
			),
			array(
				'name'        => 'ebbe_styling_settings_submenu_padding',
				'type'        => 'styling',
				'section'     => 'ebbe_styling_settings_navigation',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Styling Items', 'ebbe' ),
				'selector'    => array(
					'normal'            => ".nav-menu-desktop .sub-menu li a",
					'hover'             => ".nav-menu-desktop .sub-menu li a:hover"
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
				'name'        => 'ebbe_styling_settings_submenu_dropdown',
				'type'        => 'styling',
				'section'     => 'ebbe_styling_settings_navigation',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Styling Dropdown', 'ebbe' ),
				'selector'    => array(
					'normal'            => ".nav-menu-desktop .sub-menu",
					'hover'             => ".nav-menu-desktop .sub-menu:hover"
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

			// Mega Menu
			array(
				'name'  => "ebbe_styling_settings_mega_menu",
				'type'  => 'section',
				'panel' => 'styling_settings_panel',
				'title' => esc_html__( 'Mega Menu', 'ebbe' ),
			),
			// a. Main Navigation
			array(
				'name'    		=> 'ebbe_styling_settings_mega_menu_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_mega_menu',
				'title'   		=> esc_html__( 'Styling', 'ebbe' ),
			),
			array(
				'name'       	=> 'ebbe_styling_settings_mega_menu_color',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_mega_menu',
				'title'      	=> esc_html__( 'Links Color', 'ebbe' ),
				'selector'    	=> ".cf-mega-menu.sub-menu a",
				'css_format' 	=> 'color: {{value}};',
			),
			array(
				'name'       	=> 'ebbe_styling_settings_mega_menu_hover',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_mega_menu',
				'title'      	=> esc_html__( 'Links Hover', 'ebbe' ),
				'selector'    	=> ".cf-mega-menu.sub-menu a:hover",
				'css_format' 	=> 'color: {{value}};',
			),
			array(
				'name'            => 'ebbe_styling_settings_mega_menu_width',
				'type'            => 'slider',
				'device_settings' => true,
				'section' 		  => 'ebbe_styling_settings_mega_menu',
				'selector'        => ".cf-mega-menu.sub-menu",
				'css_format'      => 'width: {{value}};',
				'label'           => esc_html__( 'Width', 'ebbe' ),
			),

			// III. Buttons Tab
			array(
				'name'  => "ebbe_styling_settings_buttons",
				'type'  => 'section',
				'panel' => 'styling_settings_panel',
				'title' => esc_html__( 'Buttons', 'ebbe' ),
			),
			array(
				'name'        => "ebbe_styling_settings_buttons_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_buttons",
				'title'       => esc_html__( 'Typography', 'ebbe' ),
				'description' => esc_html__( 'Apply to buttons text.', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "{$ebbe_buttons}",
			), 
			array(
				'name'        => 'ebbe_styling_settings_buttons_styling',
				'type'        => 'styling',
				'section'     => 'ebbe_styling_settings_buttons',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Button Styling', 'ebbe' ),
				'selector'    => array(
					'normal'            => "{$ebbe_buttons}",
					'hover'             => "{$ebbe_buttons_hover}",
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
				)
			),
			

			// IV. Fields Tab
			array(
				'name'  => "ebbe_styling_settings_fields",
				'type'  => 'section',
				'panel' => 'styling_settings_panel',
				'title' => esc_html__( 'Fields', 'ebbe' ),
			),
			array(
				'name'        => 'ebbe_styling_settings_fields_styling',
				'type'        => 'styling',
				'section'     => 'ebbe_styling_settings_fields',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Fields Styling', 'ebbe' ),
				'selector'    => array(
					'normal'            => "{$ebbe_fields}"
				),
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
			array(
				'name'        => "ebbe_styling_settings_fields_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_fields",
				'title'       => esc_html__( 'Typography', 'ebbe' ),
				'description' => esc_html__( 'Apply to fields text.', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "{$ebbe_fields}",
			),
			array(
				'name'       	=> 'ebbe_styling_settings_fields_styling_focus',
				'type'       	=> 'color',
				'section' 		=> 'ebbe_styling_settings_fields',
				'selector'    	=> "{$ebbe_fields_focus}",
				'css_format' 	=> 'border-color: {{value}};',
				'title'      	=> esc_html__( 'Fields Color on Focus', 'ebbe' ),
				'default'   	=> '#d3d3d3',
			),
			// IV. Typography
			array(
				'name'  => "ebbe_styling_settings_typo",
				'type'  => 'section',
				'panel' => 'styling_settings_panel',
				'title' => esc_html__( 'Site Typography', 'ebbe' ),
			),
			array(
				'name'        => "ebbe_styling_settings_body_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Body Font family', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "body, ul li, ol li, p",
			),
			array(
				'name'        => "ebbe_styling_settings_h1_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H1', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "h1, h1 span",
			),
			array(
				'name'        => "ebbe_styling_settings_h2_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H2', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "h2",
			),
			array(
				'name'        => "ebbe_styling_settings_h3_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H3', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "h3, .post-name, .ebbe-post-name a",
			),
			array(
				'name'        => "ebbe_styling_settings_h4_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H4', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "h4",
			),
			array(
				'name'        => "ebbe_styling_settings_h5_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H5', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "h5",
			),
			array(
				'name'        => "ebbe_styling_settings_h6_typo",
				'type'        => 'typography',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H6', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => "h6",
			),
			array(
				'name'    		=> 'ebbe_styling_settings_mobile_typo_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_typo',
				'title'   		=> esc_html__( 'Mobile Typography', 'ebbe' ),
			),
			array(
				'name'        => "ebbe_styling_settings_h1_size_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H1 Font size', 'ebbe' ),
				'default'	  => '26px',
			),
			array(
				'name'        => "ebbe_styling_settings_h1_lh_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H1 Line height', 'ebbe' ),
				'default'	  => '38px',
			),
			array(
				'name'        => "ebbe_styling_settings_h2_size_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H2 Font size', 'ebbe' ),
				'default'	  => '24px',
			),
			array(
				'name'        => "ebbe_styling_settings_h2_lh_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H2 Line height', 'ebbe' ),
				'default'	  => '28px',
			),
			array(
				'name'        => "ebbe_styling_settings_h3_size_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H3 Font size', 'ebbe' ),
				'default'	  => '22px',
			),
			array(
				'name'        => "ebbe_styling_settings_h3_lh_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H3 Line height', 'ebbe' ),
				'default'	  => '26px',
			),
			array(
				'name'        => "ebbe_styling_settings_h4_size_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H4 Font size', 'ebbe' ),
				'default'	  => '20px',
			),
			array(
				'name'        => "ebbe_styling_settings_h4_lh_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H4 Line height', 'ebbe' ),
				'default'	  => '24px',
			),
			array(
				'name'        => "ebbe_styling_settings_h5_size_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H5 Font size', 'ebbe' ),
				'default'	  => '18px',
			),
			array(
				'name'        => "ebbe_styling_settings_h5_lh_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H5 Line height', 'ebbe' ),
				'default'	  => '22px',
			),
			array(
				'name'        => "ebbe_styling_settings_h6_size_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H6 Font size', 'ebbe' ),
				'default'	  => '16px',
			),
			array(
				'name'        => "ebbe_styling_settings_h6_lh_mobile",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H6 Line height', 'ebbe' ),
				'default'	  => '20px',
			),
			array(
				'name'    		=> 'ebbe_styling_settings_tablet_typo_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_typo',
				'title'   		=> esc_html__( 'Tablet Typography', 'ebbe' ),
			),
			array(
				'name'        => "ebbe_styling_settings_h1_size_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H1 Font size', 'ebbe' ),
				'default'	  => '28px',
			),
			array(
				'name'        => "ebbe_styling_settings_h1_lh_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H1 Line height', 'ebbe' ),
				'default'	  => '32px',
			),
			array(
				'name'        => "ebbe_styling_settings_h2_size_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H2 Font size', 'ebbe' ),
				'default'	  => '26px',
			),
			array(
				'name'        => "ebbe_styling_settings_h2_lh_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H2 Line height', 'ebbe' ),
				'default'	  => '30px',
			),
			array(
				'name'        => "ebbe_styling_settings_h3_size_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H3 Font size', 'ebbe' ),
				'default'	  => '24px',
			),
			array(
				'name'        => "ebbe_styling_settings_h3_lh_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H3 Line height', 'ebbe' ),
				'default'	  => '28px',
			),
			array(
				'name'        => "ebbe_styling_settings_h4_size_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H4 Font size', 'ebbe' ),
				'default'	  => '22px',
			),
			array(
				'name'        => "ebbe_styling_settings_h4_lh_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H4 Line height', 'ebbe' ),
				'default'	  => '26px',
			),
			array(
				'name'        => "ebbe_styling_settings_h5_size_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H5 Font size', 'ebbe' ),
				'default'	  => '20px',
			),
			array(
				'name'        => "ebbe_styling_settings_h5_lh_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H5 Line height', 'ebbe' ),
				'default'	  => '23px',
			),
			array(
				'name'        => "ebbe_styling_settings_h6_size_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H6 Font size', 'ebbe' ),
				'default'	  => '18px',
			),
			array(
				'name'        => "ebbe_styling_settings_h6_lh_tablet",
				'type'        => 'text',
				'section'     => "ebbe_styling_settings_typo",
				'title'       => esc_html__( 'Heading H6 Line height', 'ebbe' ),
				'default'	  => '21px',
			),

			// IV. Typography
			array(
				'name'  	=> "ebbe_styling_settings_widgets",
				'type'  	=> 'section',
				'panel' 	=> 'styling_settings_panel',
				'title' 	=> esc_html__( 'Widgets Styling', 'ebbe' ),
			),
			array(
				'name'    	=> 'ebbe_styling_widgets_heading_1',
				'type'    	=> 'heading',
				'section' 	=> 'ebbe_styling_settings_widgets',
				'title'   	=> esc_html__( 'Sidebar Widgets', 'ebbe' ),
			),
			array(
				'name'        => 'ebbe_blog_widget_card_styling',
				'type'        => 'styling',
				'section'     => 'ebbe_styling_settings_widgets',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Card Styling', 'ebbe' ),
				'selector'    => '.sidebar-content .widget',
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
			array(
				'name'        => 'ebbe_blog_sidebar_title_styling',
				'type'        => 'typography',
				'section'     => 'ebbe_styling_settings_widgets',
				'css_format'  => 'typography',
				'title'       => esc_html__( 'Title Typography', 'ebbe' ),
				'selector'    => '.sidebar-content .widget-title, .sidebar-content .widget h2, .sidebar-content .widget .wp-block-search__label'
			),
			array(
				'name'    		=> 'ebbe_styling_widgets_social_heading',
				'type'    		=> 'heading',
				'section' 		=> 'ebbe_styling_settings_widgets',
				'title'   		=> esc_html__( 'Widget: MT - Contact + Social Media', 'ebbe' ),
			),
			array(
				'name'        	=> 'ebbe_widget_contact_styling',
				'type'       	=> 'color',
				'section'     	=> 'ebbe_styling_settings_widgets',
				'title'       	=> esc_html__( 'Contact Links Styling', 'ebbe' ),
				'css_format' 	=> 'color: {{value}};',
				'selector'    	=> '.contact-details span, .contact-details span i',
			),
			array(
				'name'        	=> 'ebbe_widget_social_media_styling',
				'type'        	=> 'styling',
				'section'     	=> 'ebbe_styling_settings_widgets',
				'css_format'  	=> 'styling',
				'title'       	=> esc_html__( 'Social Icon Styling', 'ebbe' ),
				'selector'    	=> array(
					'normal'        => ".widget_mt_address_social_icons a",
					'hover'         => ".widget_mt_address_social_icons a:hover",
				),
				'fields'      	=> array(
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
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'margin'        => false,
					)
				)
			)
		);

		return array_merge( $configs, $config );
	}
}

add_filter( 'ebbe/customizer/config', 'ebbe_customizer_styling_config' );
