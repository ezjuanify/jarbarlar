<?php
function ebbe_global_section_customizer( $wp_customize ) {
    // Add a section in the Customizer
    $wp_customize->add_section( 'global_section', array(
        'title'    => __( 'Global Section', 'ebbe' ),
        'priority' => 10,
        'panel'    => 'header_settings',
    ) );

    // Add a setting to enable/disable the global section
    $wp_customize->add_setting( 'show_global_section', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );

    // Add a checkbox control to enable/disable the Global Section
    $wp_customize->add_control( 'show_global_section', array(
        'label'    => __( 'Show Global Section', 'ebbe' ),
        'section'  => 'global_section',
        'type'     => 'checkbox',
    ) );

    // Add a setting for global section content
    $wp_customize->add_setting( 'global_section_content', array(
        'default'           => __( '<p>This is the <strong>global section</strong> content.</p>', 'ebbe' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );

    // Add a textarea control for the content
    $wp_customize->add_control( 'global_section_content', array(
        'label'       => __( 'Global Section Content', 'ebbe' ),
        'section'     => 'global_section',
        'type'        => 'textarea',
        'description' => __( 'You can use basic HTML here.', 'ebbe' ),
    ) );

    // Add a setting for specific page types
    $wp_customize->add_setting( 'global_section_page_types', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Add a text field for entering page types
   
}
add_action( 'customize_register', 'ebbe_global_section_customizer' );

// Function to render the Global Section
function display_global_section() {
    $show_section    = get_theme_mod( 'show_global_section', false );
    $page_types      = get_theme_mod( 'global_section_page_types', '' );

    // Exit if the Global Section is disabled
    if ( ! $show_section || empty( $page_types ) ) {
        return;
    }

    // Convert comma-separated page types into an array
    $page_types_array = array_map( 'trim', explode( ',', strtolower( $page_types ) ) );

    // Determine the current page
    $is_valid_page = false;

    if ( in_array( 'home', $page_types_array ) && is_front_page() ) {
        $is_valid_page = true;
    }
    if ( in_array( 'blog', $page_types_array ) && is_home() ) {
        $is_valid_page = true;
    }
    if ( in_array( 'product', $page_types_array ) && function_exists( 'is_product' ) && is_product() ) {
        $is_valid_page = true;
    }
    if ( in_array( 'category', $page_types_array ) && is_category() ) {
        $is_valid_page = true;
    }
    if ( in_array( 'single', $page_types_array ) && is_single() ) {
        $is_valid_page = true;
    }
    if ( in_array( '404', $page_types_array ) && is_404() ) {
        $is_valid_page = true;
    }
    if ( in_array( 'page', $page_types_array ) && is_page() ) {
        $is_valid_page = true;
    }

    // Render the section if it's a valid page
    if ( $is_valid_page ) {
        $content = get_theme_mod( 'global_section_content', '' );
        if ( ! empty( $content ) ) {
            echo '<div class="global-section" style="background: #1c1caa; color: #fff; text-align: center; padding: 10px 0;">';
            echo wp_kses_post( $content );
            echo '</div>';
        }
    }
}
add_action( 'wp_footer', 'display_global_section' );
