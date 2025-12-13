<?php

$dir = get_stylesheet_directory();
$uri = get_stylesheet_directory_uri();

/**
 * Enqueue Parent + Child Styles
 */
add_action('wp_enqueue_scripts', function () use ($uri) {

    // Parent theme
    wp_enqueue_style(
        'ebbe-parent-style',
        "$uri/style.css",
    );

    // Child theme
	wp_enqueue_style(
        'ebbe-child-style',
        "$uri/style.css",
        ['ebbe-parent-style'],
        wp_get_theme()->get('Version'),
    );

});


/**
 * Enqueue WooCommerce Dependencies
 */
add_action('wp_enqueue_scripts', function () {

    if (!class_exists('WooCommerce')) return;

    wp_enqueue_script('jquery');

    // Override bundled WC scripts (optional)
    wp_enqueue_script(
        'jquery-blockui',
        plugins_url('woocommerce/assets/js/packages/jquery-blockui/jquery.blockUI.min.js'),
        ['jquery'],
        '2.7.0',
        true,
    );

    wp_enqueue_script(
       'wc-add-to-cart',
       plugins_url('woocommerce/assets/js/frontend/add-to-cart.min.js'),
       ['jquery', 'jquery-blockui'],
       '10.3.4',
       true,
    );

    wp_enqueue_script(
        'wc-cart-fragments',
        plugins_url('woocommerce/assets/js/frontend/cart-fragments.min.js'),
        ['jquery', 'jquery-blockui', 'wc-add-to-cart'],
        '10.3.4',
        true,
    );

});


/**
 * Enqueue Slick
 */
add_action('wp_enqueue_scripts', function () use ($dir, $uri) {

    // Slick CSS
    wp_enqueue_style(
        'slick-style',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css',
        [],
        '1.8.1',
    );

    wp_enqueue_style(
        'slick-theme',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css',
        ['slick'],
        '1.8.1',
    );

    // Slick JS
    wp_enqueue_script(
        'slick',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',
        ['jquery'],
        '1.8.1',
        true,
    );
});


/**
 * Enqueue Custom CSS
 */
add_action('wp_enqueue_scripts', function () use ($dir, $uri) {

    wp_enqueue_style(
        'custom-products-style',
        $uri . '/assets/css/custom-products.css',
        [],
        filemtime($dir . '/assets/css/custom-products.css')
    );

    wp_enqueue_style(
        "usp-bar-style",
        $uri . '/assets/css/usp-bar.css',
        [],
        filemtime($dir . '/assets/css/usp-bar.css')
    );

});


/**
 * Enqueue Custom JS
 */
add_action('wp_enqueue_scripts', function () use ($dir, $uri) {});
?>
