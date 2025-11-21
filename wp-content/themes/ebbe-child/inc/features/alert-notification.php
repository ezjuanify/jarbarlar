<?php
add_action('wp_enqueue_scripts', function () {
    if (!class_exists('WooCommerce')) return;

    wp_enqueue_script(
        'alert-notification',
        get_stylesheet_directory_uri() . '/assets/js/alert-notification.js',
        ['jquery', 'jquery-blockui', 'wc-add-to-cart'],
        filemtime(get_stylesheet_directory() . '/assets/js/alert-notification.js'),
        true
    );
});
?>