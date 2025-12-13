<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    if (!class_exists('WooCommerce')) return;

    load_features_assets($fn, ['jquery', 'jquery-blockui', 'wc-add-to-cart']);
});
?>