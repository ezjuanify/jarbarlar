<?php
add_action('wp_enqueue_scripts', function () {
    if (!is_shop() && !is_product_category() && !is_front_page()) return;

    wp_enqueue_script(
        'add-to-cart-variant',
        get_stylesheet_directory_uri() . '/assets/js/add-to-cart-variant.js',
        ['jquery', 'wc-add-to-cart'],
        filemtime(get_stylesheet_directory() . '/assets/js/add-to-cart-variant.js'),
        true
    );
});
?>