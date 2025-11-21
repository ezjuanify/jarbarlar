<?php

/**
 * Enqueue Parent + Child Styles
 */
function ebbe_enqueue_styles() {
    // Parent theme
    wp_enqueue_style(
        'ebbe-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // Child theme
	wp_enqueue_style(
        'ebbe-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['ebbe-parent-style'],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'ebbe_enqueue_styles');


/**
 * WooCommerce Dependencies
 */
function ebbe_enqueue_woocommerce_scripts() {
    if (!class_exists('WooCommerce')) return;

    wp_enqueue_script('jquery');

    // Override bundled WC scripts (optional)
    wp_enqueue_script(
        'jquery-blockui',
        plugins_url('woocommerce/assets/js/packages/jquery-blockui/jquery.blockUI.min.js'),
        ['jquery'],
        '2.7.0',
        true
    );

    wp_enqueue_script(
       'wc-add-to-cart',
       plugins_url('woocommerce/assets/js/frontend/add-to-cart.min.js'),
       ['jquery', 'jquery-blockui'],
       '10.3.4',
       true
    );

    wp_enqueue_script(
        'wc-cart-fragments',
        plugins_url('woocommerce/assets/js/frontend/cart-fragments.min.js'),
        ['jquery', 'jquery-blockui', 'wc-add-to-cart'],
        '10.3.4',
        true
    );
}
add_action('wp_enqueue_scripts', 'ebbe_enqueue_woocommerce_scripts');


/**
 * Custom CSS
 */
function ebbe_enqueue_custom_css() {
    wp_enqueue_style(
        'custom-products',
        get_stylesheet_directory_uri() . '/assets/css/custom-products.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/css/custom-products.css')
    );
}
add_action('wp_enqueue_scripts', 'ebbe_enqueue_custom_css');
?>