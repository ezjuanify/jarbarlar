<?php
/**
 * Prime Ecommerce Shop Theme Customizer.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package prime_ecommerce_shop
 */

if( ! function_exists( 'prime_ecommerce_shop_customize_register' ) ):  
/**
 * Add postMessage support for site title and description for the Theme Customizer.F
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function prime_ecommerce_shop_customize_register( $wp_customize ) {
    require get_parent_theme_file_path('/inc/controls/changeable-icon.php');
    

    if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'prime-ecommerce-shop' );
    }
	
    /* Option list of all post */	
    $prime_ecommerce_shop_options_posts = array();
    $prime_ecommerce_shop_options_posts_obj = get_posts('posts_per_page=-1');
    $prime_ecommerce_shop_options_posts[''] = esc_html__( 'Choose Post', 'prime-ecommerce-shop' );
    foreach ( $prime_ecommerce_shop_options_posts_obj as $prime_ecommerce_shop_posts ) {
    	$prime_ecommerce_shop_options_posts[$prime_ecommerce_shop_posts->ID] = $prime_ecommerce_shop_posts->post_title;
    }
    
    /* Option list of all categories */
    $prime_ecommerce_shop_args = array(
	   'type'                     => 'post',
	   'orderby'                  => 'name',
	   'order'                    => 'ASC',
	   'hide_empty'               => 1,
	   'hierarchical'             => 1,
	   'taxonomy'                 => 'category'
    ); 
    $prime_ecommerce_shop_option_categories = array();
    $prime_ecommerce_shop_category_lists = get_categories( $prime_ecommerce_shop_args );
    $prime_ecommerce_shop_option_categories[''] = esc_html__( 'Choose Category', 'prime-ecommerce-shop' );
    foreach( $prime_ecommerce_shop_category_lists as $prime_ecommerce_shop_category ){
        $prime_ecommerce_shop_option_categories[$prime_ecommerce_shop_category->term_id] = $prime_ecommerce_shop_category->name;
    }
    
    /** Default Settings */    
    $wp_customize->add_panel( 
        'wp_default_panel',
         array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Default Settings', 'prime-ecommerce-shop' ),
            'description' => esc_html__( 'Default section provided by wordpress customizer.', 'prime-ecommerce-shop' ),
        ) 
    );
    
    $wp_customize->get_section( 'title_tagline' )->panel                  = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel                         = 'wp_default_panel';
    $wp_customize->get_section( 'header_image' )->panel                   = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel               = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel              = 'wp_default_panel';
    
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    /** Default Settings Ends */
    
    /** Site Title control */
    $wp_customize->add_setting( 
        'header_site_title', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'header_site_title',
        array(
            'label'       => __( 'Show / Hide Site Title', 'prime-ecommerce-shop' ),
            'section'     => 'title_tagline',
            'type'        => 'checkbox',
        )
    );

    /** Tagline control */
    $wp_customize->add_setting( 
        'header_tagline', 
        array(
            'default'           => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'header_tagline',
        array(
            'label'       => __( 'Show / Hide Tagline', 'prime-ecommerce-shop' ),
            'section'     => 'title_tagline',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting('logo_width', array(
        'sanitize_callback' => 'absint', 
    ));

    // Add a control for logo width
    $wp_customize->add_control('logo_width', array(
        'label' => __('Logo Width', 'prime-ecommerce-shop'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => '50', 
            'max' => '500', 
            'step' => '5', 
    ),
        'default' => '100', 
    ));

    $wp_customize->add_setting( 'prime_ecommerce_shop_site_title_size', array(
        'default'           => 30, // Default font size in pixels
        'sanitize_callback' => 'absint', // Sanitize the input as a positive integer
    ) );

    // Add control for site title size
    $wp_customize->add_control( 'prime_ecommerce_shop_site_title_size', array(
        'type'        => 'number',
        'section'     => 'title_tagline', // You can change this section to your preferred section
        'label'       => __( 'Site Title Font Size (px)', 'prime-ecommerce-shop' ),
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 1,
        ),
    ) );

    /** Sidebar Settings for pages & Post */
    $wp_customize->add_section(
        'prime_ecommerce_shop_sidebar_settings',
        array(
            'title' => esc_html__( 'Sidebar Settings', 'prime-ecommerce-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
        )
    );

    $wp_customize->add_setting('prime_ecommerce_shop_sidebar_text_align', array(
    'default'           => 'left',
    'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add Sidebar Text Align Control
    $wp_customize->add_control('sidebar_text_align_control', array(
        'label'    => __('Sidebar Heading Text Align', 'prime-ecommerce-shop'),
        'section'  => 'prime_ecommerce_shop_sidebar_settings',
        'settings' => 'prime_ecommerce_shop_sidebar_text_align',
        'type'     => 'select',
        'choices'  => array(
            'left'   => __('Left', 'prime-ecommerce-shop'),
            'center' => __('Center', 'prime-ecommerce-shop'),
        ),
    ));


    $wp_customize->add_setting( 'prime_ecommerce_shop_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_sidebar_position',
    ) );

    // Add Sidebar Position Control
    $wp_customize->add_control( 'prime_ecommerce_shop_sidebar_position', array(
        'label'       => __( 'Sidebar Position', 'prime-ecommerce-shop' ),
        'description' => __( 'Choose the position of the sidebar no sidebar option is not applicable for shop and product pages', 'prime-ecommerce-shop' ),
        'section'     => 'prime_ecommerce_shop_sidebar_settings',
        'type'        => 'radio',
        'choices'     => array(
            'left'  => __( 'Left Sidebar', 'prime-ecommerce-shop' ),
            'right' => __( 'Right Sidebar', 'prime-ecommerce-shop' ),
            'no-sidebar' => __( 'No Sidebar', 'prime-ecommerce-shop' ),
        ),
    ) );
     /** Sidebar Settings for pages & Post End */

    /** Post Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_post_settings',
        array(
            'title' => esc_html__( 'Post Settings', 'prime-ecommerce-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
        )
    );

    /** Post Heading control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_post_heading_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_post_heading_setting',
        array(
            'label'       => __( 'Show / Hide Post Heading', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Meta control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_post_meta_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_post_meta_setting',
        array(
            'label'       => __( 'Show / Hide Post Meta', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Image control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_post_image_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_post_image_setting',
        array(
            'label'       => __( 'Show / Hide Post Image', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Content control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_post_content_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_post_content_setting',
        array(
            'label'       => __( 'Show / Hide Post Content', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_post_settings',
            'type'        => 'checkbox',
        )
    );
    /** Post ReadMore control */
     $wp_customize->add_setting( 'prime_ecommerce_shop_read_more_setting`', array(
        'default'           => true,
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'prime_ecommerce_shop_read_more_setting`', array(
        'type'        => 'checkbox',
        'section'     => 'prime_ecommerce_shop_post_settings', 
        'label'       => __( 'Display Read More Button', 'prime-ecommerce-shop' ),
    ) );

    $wp_customize->add_setting('prime_ecommerce_shop_single_post_align',array(
        'default' => 'left-align',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_single_post_align'
    ));
    $wp_customize->add_control('prime_ecommerce_shop_single_post_align',array(
        'type' => 'select',
        'label' => __('Post Content Alignment','prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_post_settings',
        'choices' => array(
            'left-align' => __('Left Alignment','prime-ecommerce-shop'),
            'right-align' => __('Right Alignment','prime-ecommerce-shop'),
            'center-align' => __('Center Alignment','prime-ecommerce-shop'),
        ),
    ) );

    /** Post Settings Ends */

     /** Single Post Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_single_post_settings',
        array(
            'title' => esc_html__( 'Single Post Settings', 'prime-ecommerce-shop' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
        )
    );

    /** Single Post Meta control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_single_post_meta_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_single_post_meta_setting',
        array(
            'label'       => __( 'Show / Hide Single Post Meta', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_single_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Single Post Content control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_single_post_content_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_single_post_content_setting',
        array(
            'label'       => __( 'Show / Hide Single Post Content', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_single_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Single Post Settings Ends */

         // Typography Settings Section
    $wp_customize->add_section('prime_ecommerce_shop_typography_settings', array(
        'title'      => esc_html__('Typography Settings', 'prime-ecommerce-shop'),
        'priority'   => 30,
        'capability' => 'edit_theme_options',
    ));

    // Array of fonts to choose from
    $font_choices = array(
        ''               => __('Select', 'prime-ecommerce-shop'),
        'Arial'          => 'Arial, sans-serif',
        'Verdana'        => 'Verdana, sans-serif',
        'Helvetica'      => 'Helvetica, sans-serif',
        'Times New Roman'=> '"Times New Roman", serif',
        'Georgia'        => 'Georgia, serif',
        'Courier New'    => '"Courier New", monospace',
        'Trebuchet MS'   => '"Trebuchet MS", sans-serif',
        'Tahoma'         => 'Tahoma, sans-serif',
        'Palatino'       => '"Palatino Linotype", serif',
        'Garamond'       => 'Garamond, serif',
        'Impact'         => 'Impact, sans-serif',
        'Comic Sans MS'  => '"Comic Sans MS", cursive, sans-serif',
        'Lucida Sans'    => '"Lucida Sans Unicode", sans-serif',
        'Arial Black'    => '"Arial Black", sans-serif',
        'Gill Sans'      => '"Gill Sans", sans-serif',
        'Segoe UI'       => '"Segoe UI", sans-serif',
        'Open Sans'      => '"Open Sans", sans-serif',
        'Roboto'         => 'Roboto, sans-serif',
        'Lato'           => 'Lato, sans-serif',
        'Montserrat'     => 'Montserrat, sans-serif',
        'Libre Baskerville' => 'Libre Baskerville',
    );

    // Heading Font Setting
    $wp_customize->add_setting('prime_ecommerce_shop_heading_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_choicess',
    ));
    $wp_customize->add_control('prime_ecommerce_shop_heading_font_family', array(
        'type'    => 'select',
        'choices' => $font_choices,
        'label'   => __('Select Font for Heading', 'prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_typography_settings',
    ));

    // Body Font Setting
    $wp_customize->add_setting('prime_ecommerce_shop_body_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_choicess',
    ));
    $wp_customize->add_control('prime_ecommerce_shop_body_font_family', array(
        'type'    => 'select',
        'choices' => $font_choices,
        'label'   => __('Select Font for Body', 'prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_typography_settings',
    ));

    /** Typography Settings Section End */

    /** General Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_general_settings',
        array(
            'title' => esc_html__( 'General Settings', 'prime-ecommerce-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** Scroll to top control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_footer_scroll_to_top', 
        array(
            'default' => 1,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_footer_scroll_to_top',
        array(
            'label'       => __( 'Show Scroll To Top', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_general_settings',
            'type'        => 'checkbox',
        )
    );

     $wp_customize->add_setting('prime_ecommerce_shop_scroll_icon',array(
        'default'   => 'fas fa-arrow-up',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Prime_Ecommerce_Shop_Changeable_Icon(
        $wp_customize,'prime_ecommerce_shop_scroll_icon',array(
        'label' => __('Scroll Top Icon','prime-ecommerce-shop'),
        'transport' => 'refresh',
        'section'   => 'prime_ecommerce_shop_general_settings',
        'type'      => 'icon'
    )));

    /** Preloader control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_header_preloader', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_header_preloader',
        array(
            'label'       => __( 'Show Preloader', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_general_settings',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting('prime_ecommerce_shop_loader_layout_setting', array(
        'default' => 'load',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add control for loader layout
    $wp_customize->add_control('prime_ecommerce_shop_loader_layout_control', array(
        'label' => __('Preloader Layout', 'prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_general_settings',
        'settings' => 'prime_ecommerce_shop_loader_layout_setting',
        'type' => 'select',
        'choices' => array(
            'load' => __('Preloader 1', 'prime-ecommerce-shop'),
            'load-one' => __('Preloader 2', 'prime-ecommerce-shop'),
            'ctn-preloader' => __('Preloader 3', 'prime-ecommerce-shop'),
        ),
    ));
    /** Sticky Header control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_sticky_header', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_sticky_header',
        array(
            'label'       => __( 'Show Sticky Header', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_general_settings',
            'type'        => 'checkbox',
        )
    );

    // Add Setting for Menu Font Weight
    $wp_customize->add_setting( 'prime_ecommerce_shop_menu_font_weight', array(
        'default'           => '500',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_font_weight',
    ) );

    // Add Control for Menu Font Weight
    $wp_customize->add_control( 'prime_ecommerce_shop_menu_font_weight', array(
        'label'    => __( 'Menu Font Weight', 'prime-ecommerce-shop' ),
        'section'  => 'prime_ecommerce_shop_general_settings',
        'type'     => 'select',
        'choices'  => array(
            '100' => __( '100 - Thin', 'prime-ecommerce-shop' ),
            '200' => __( '200 - Extra Light', 'prime-ecommerce-shop' ),
            '300' => __( '300 - Light', 'prime-ecommerce-shop' ),
            '400' => __( '400 - Normal', 'prime-ecommerce-shop' ),
            '500' => __( '500 - Medium', 'prime-ecommerce-shop' ),
            '600' => __( '600 - Semi Bold', 'prime-ecommerce-shop' ),
            '700' => __( '700 - Bold', 'prime-ecommerce-shop' ),
            '800' => __( '800 - Extra Bold', 'prime-ecommerce-shop' ),
            '900' => __( '900 - Black', 'prime-ecommerce-shop' ),
        ),
    ) );

    // Add Setting for Menu Text Transform
    $wp_customize->add_setting( 'prime_ecommerce_shop_menu_text_transform', array(
        'default'           => 'Uppercase',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_text_transform',
    ) );

    // Add Control for Menu Text Transform
    $wp_customize->add_control( 'prime_ecommerce_shop_menu_text_transform', array(
        'label'    => __( 'Menu Text Transform', 'prime-ecommerce-shop' ),
        'section'  => 'prime_ecommerce_shop_general_settings',
        'type'     => 'select',
        'choices'  => array(
            'none'       => __( 'None', 'prime-ecommerce-shop' ),
            'capitalize' => __( 'Capitalize', 'prime-ecommerce-shop' ),
            'uppercase'  => __( 'Uppercase', 'prime-ecommerce-shop' ),
            'lowercase'  => __( 'Lowercase', 'prime-ecommerce-shop' ),
        ),
    ) );

    $wp_customize->add_setting('prime_ecommerce_shop_theme_width',array(
    'default' => 'full-width',
    'sanitize_callback' => 'prime_ecommerce_shop_sanitize_theme_width'
    ));
    $wp_customize->add_control('prime_ecommerce_shop_theme_width',array(
        'type' => 'select',
        'label' => __('Theme Width Option','prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_general_settings',
        'choices' => array(
            'full-width' => __('Fullwidth','prime-ecommerce-shop'),
            'container' => __('Container','prime-ecommerce-shop'),
            'container-fluid' => __('Container Fluid','prime-ecommerce-shop'),
        ),
    ) );

    /** Header Section Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_header_section_settings',
        array(
            'title' => esc_html__( 'Header Section Settings', 'prime-ecommerce-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** Header Section control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_header_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_header_setting',
        array(
            'label'       => __( 'Show Header', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_header_section_settings',
            'type'        => 'checkbox',
        )
    );

     /** Topbar Text */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_topbar_text_1',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_topbar_text_1',
        array(
            'label' => esc_html__( 'Topbar Text', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'text',
        )
    );

     /** Order Tacking Text */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_header_btn_1',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_header_btn_1',
        array(
            'label' => esc_html__( 'Order Tracking', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'text',
        )
    );

    /** Order Tacking URL */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_header_btn_1_url',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_header_btn_1_url',
        array(
            'label' => esc_html__( 'Order Tracking URL', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'url',
        )
    );

    /** My Account Text */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_header_btn_2',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_header_btn_2',
        array(
            'label' => esc_html__( 'My Account Text', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'text',
        )
    );

    /** Order Tacking URL */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_header_btn_2_url',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_header_btn_2_url',
        array(
            'label' => esc_html__( 'My Account URL', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'url',
        )
    );

     /** Phone */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_contact_number',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_contact_number',
        array(
            'label' => esc_html__( 'Contact Number', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'text',
        )
    );

   /** WISHLIST URL */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_wishlist_url',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_wishlist_url',
        array(
            'label' => esc_html__( 'Wishlist URL', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'type' => 'url',
        )
    );


        $wp_customize->add_setting(
        'prime_ecommerce_shop_category_text',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_category_text',
        array(
            'default' => esc_html__( 'Select Category', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_header_section_settings',
            'label' => __('Add Category Text', 'prime-ecommerce-shop'),
            'type' => 'text',
        )
    );

    $wp_customize->add_setting('prime_ecommerce_shop_product_category_number',array(
        'default' => '',
        'sanitize_callback' => 'absint', 
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_control( 'prime_ecommerce_shop_product_category_number', array(
       'settings' => 'prime_ecommerce_shop_product_category_number',
       'section'   => 'prime_ecommerce_shop_header_section_settings',
       'label' => __('Add Category Limit', 'prime-ecommerce-shop'),
       'type'      => 'number'
    ));

    /** Socail Section Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_social_section_settings',
        array(
            'title' => esc_html__( 'Social Media Section Settings', 'prime-ecommerce-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** Socail Section control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_social_icon_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_social_icon_setting',
        array(
            'label'       => __( 'Show Social Icon', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_social_section_settings',
            'type'        => 'checkbox',
        )
    );

    /**  Social Link 1 */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_social_link_1',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_social_link_1',
        array(
            'label' => esc_html__( 'Add Facebook Link', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_social_section_settings',
            'type' => 'url',
        )
    );

    /**  Social Link 2 */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_social_link_2',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_social_link_2',
        array(
            'label' => esc_html__( 'Add Twitter Link', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_social_section_settings',
            'type' => 'url',
        )
    );

    /**  Social Link 3 */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_social_link_3',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_social_link_3',
        array(
            'label' => esc_html__( 'Add Instagram Link', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_social_section_settings',
            'type' => 'url',
        )
    );

    /**  Social Link 4 */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_social_link_4',
        array( 
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_social_link_4',
        array(
            'label' => esc_html__( 'Add Pintrest Link', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_social_section_settings',
            'type' => 'url',
        )
    );


    /** Social Section Settings End */


    /** Home Page Settings */
    $wp_customize->add_panel( 
        'prime_ecommerce_shop_home_page_settings',
         array(
            'priority' => 40,
            'capability' => 'edit_theme_options',
            'title' => esc_html__( 'Home Page Settings', 'prime-ecommerce-shop' ),
            'description' => esc_html__( 'Customize Home Page Settings', 'prime-ecommerce-shop' ),
        ) 
    );

    /** Slider Section Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_slider_section_settings',
        array(
            'title' => esc_html__( 'Slider Section Settings', 'prime-ecommerce-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'prime_ecommerce_shop_home_page_settings',
        )
    );

    /** Slider Section control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_slider_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_slider_setting',
        array(
            'label'       => __( 'Show Slider', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_slider_section_settings',
            'type'        => 'checkbox',
        )
    );

     // Section Text
    $wp_customize->add_setting(
        'prime_ecommerce_shop_slider_extra_text', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',    
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_slider_extra_text', 
        array(
            'label'       => __('Section Extra Heading', 'prime-ecommerce-shop'),
            'section'     => 'prime_ecommerce_shop_slider_section_settings',
            'settings'    => 'prime_ecommerce_shop_slider_extra_text',
            'type'        => 'text'
        )
    );
    
    $categories = get_categories();
        $cat_posts = array();
            $i = 0;
            $cat_posts[]='Select';
        foreach($categories as $category){
            if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cat_posts[$category->slug] = $category->name;
    }

    $wp_customize->add_setting(
        'prime_ecommerce_shop_blog_slide_category',
        array(
            'default'   => 'select',
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_choices',
        )
    );
    $wp_customize->add_control(
        'prime_ecommerce_shop_blog_slide_category',
        array(
            'type'    => 'select',
            'choices' => $cat_posts,
            'label' => __('Select Category to display Slides','prime-ecommerce-shop'),
            'section' => 'prime_ecommerce_shop_slider_section_settings',
        )
    );

    /** Classes Section Settings */
    $wp_customize->add_section(
        'prime_ecommerce_shop_classes_section_settings',
        array(
            'title' => esc_html__( 'Product Section Settings', 'prime-ecommerce-shop' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'prime_ecommerce_shop_home_page_settings',
        )
    );

    /** Classes Section control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_classes_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_classes_setting',
        array(
            'label'       => __( 'Show product Section', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_classes_section_settings',
            'type'        => 'checkbox',
        )
    );

    $args = array(
        'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
    $categories = get_categories($args);
    $cat_posts = array();
    $m = 0;
    $cat_posts[]='Select';
    foreach($categories as $category){
        if($m==0){
            $default = $category->slug;
            $m++;
        }
        $cat_posts[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('prime_ecommerce_shop_hot_products_cat',array(
        'default'   => 'select',
        'sanitize_callback' => 'prime_ecommerce_shop_sanitize_choices',
    ));
    $wp_customize->add_control('prime_ecommerce_shop_hot_products_cat',array(
        'type'    => 'select',
        'choices' => $cat_posts,
        'label' => __('Select category to display products ','prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_classes_section_settings',
    ));

     // Section Text
    $wp_customize->add_setting(
        'prime_ecommerce_shop_timer_text', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',    
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_timer_text', 
        array(
            'label'       => __('Timer Heading', 'prime-ecommerce-shop'),
            'section'     => 'prime_ecommerce_shop_classes_section_settings',
            'settings'    => 'prime_ecommerce_shop_timer_text',
            'type'        => 'text'
        )
    );

    $wp_customize->add_setting(
        'prime_ecommerce_shop_clock_timer_end',
        array(
            'default'=> '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(
        'prime_ecommerce_shop_clock_timer_end',
        array(
            'label' => __('Enter End Date of Timer','prime-ecommerce-shop'),
            'section'=> 'prime_ecommerce_shop_classes_section_settings',
            'description'=>'Timer get the current date and time. So you just need to add the end date. Please Use the following format to add the date "Month date year hours:minutes:seconds" example "August 11 2020 11:00:00".',
            'type'=> 'text'
    ));
    
    /** Home Page Settings Ends */
    
    /** Footer Section */
    $wp_customize->add_section(
        'prime_ecommerce_shop_footer_section',
        array(
            'title' => __( 'Footer Settings', 'prime-ecommerce-shop' ),
            'priority' => 70,
        )
    );

    /** Footer Copyright control */
    $wp_customize->add_setting( 
        'prime_ecommerce_shop_footer_setting', 
        array(
            'default' => true,
            'sanitize_callback' => 'prime_ecommerce_shop_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_ecommerce_shop_footer_setting',
        array(
            'label'       => __( 'Show Footer Copyright', 'prime-ecommerce-shop' ),
            'section'     => 'prime_ecommerce_shop_footer_section',
            'type'        => 'checkbox',
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'prime_ecommerce_shop_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'prime_ecommerce_shop_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'prime-ecommerce-shop' ),
            'section' => 'prime_ecommerce_shop_footer_section',
            'type' => 'text',
        )
    );  
$wp_customize->add_setting('prime_ecommerce_shop_footer_background_image',
        array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        )
    );


    $wp_customize->add_control(
         new WP_Customize_Cropped_Image_Control($wp_customize, 'prime_ecommerce_shop_footer_background_image',
            array(
                'label' => esc_html__('Footer Background Image', 'prime-ecommerce-shop'),
                'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'prime-ecommerce-shop'), 1024, 800),
                'section' => 'prime_ecommerce_shop_footer_section',
                'width' => 1024,
                'height' => 800,
                'flex_width' => true,
                'flex_height' => true,
                'priority' => 100,
            )
        )
    );

    /* Footer Background Color*/
    $wp_customize->add_setting(
        'prime_ecommerce_shop_footer_background_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'prime_ecommerce_shop_footer_background_color',
            array(
                'label' => __('Footer Widget Area Background Color', 'prime-ecommerce-shop'),
                'section' => 'prime_ecommerce_shop_footer_section',
                'type' => 'color',
            )
        )
    );

    // 404 PAGE SETTINGS
    $wp_customize->add_section(
        'prime_ecommerce_shop_404_section',
        array(
            'title' => __( '404 Page Settings', 'prime-ecommerce-shop' ),
            'priority' => 70,
        )
    );
   
    $wp_customize->add_setting('404_page_image', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw', // Sanitize as URL
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '404_page_image', array(
        'label' => __('404 Page Image', 'prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_404_section',
        'settings' => '404_page_image',
    )));

    $wp_customize->add_setting('404_pagefirst_header', array(
        'default' => __('404', 'prime-ecommerce-shop'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
    ));

    $wp_customize->add_control('404_pagefirst_header', array(
        'type' => 'text',
        'label' => __('Heading', 'prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_404_section',
    ));

    // Setting for 404 page header
    $wp_customize->add_setting('404_page_header', array(
        'default' => __('Sorry, that page can\'t be found!', 'prime-ecommerce-shop'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
    ));

    $wp_customize->add_control('404_page_header', array(
        'type' => 'text',
        'label' => __('Heading', 'prime-ecommerce-shop'),
        'section' => 'prime_ecommerce_shop_404_section',
    ));
}
add_action( 'customize_register', 'prime_ecommerce_shop_customize_register' );
endif;

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function prime_ecommerce_shop_customize_preview_js() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $prime_ecommerce_shop_build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $prime_ecommerce_shop_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'prime_ecommerce_shop_customizer', get_template_directory_uri() . '/js' . $prime_ecommerce_shop_build . '/customizer' . $prime_ecommerce_shop_suffix . '.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'prime_ecommerce_shop_customize_preview_js' );