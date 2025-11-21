<?php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'ajax-cart-count',
        get_stylesheet_directory_uri() . '/assets/js/ajax-cart-count.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/js/ajax-cart-count.js'),
        true
    );

    wp_localize_script('ajax-cart-count', 'ajaxCartCount', [
        'ajaxUrl' => admin_url('admin-ajax.php')
    ]);
});

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

function get_cart_count() {
    if (!defined('WC_VERSION')) wp_send_json_error(['error' => true, 'message' => 'WooCommerce not active']);
    wp_send_json_success(['error' => false, 'count' => WC()->cart->get_cart_contents_count()]);
}
?>