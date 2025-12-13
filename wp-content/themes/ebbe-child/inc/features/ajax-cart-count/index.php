<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    load_features_assets($fn);

    wp_localize_script(
        $fn,
        'ajaxCartCount',
        ['ajaxUrl' => admin_url('admin-ajax.php')]
    );
});

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

function get_cart_count() {
    if (!defined('WC_VERSION')) wp_send_json_error(['error' => true, 'message' => 'WooCommerce not active']);
    wp_send_json_success(['error' => false, 'count' => WC()->cart->get_cart_contents_count()]);
}
?>