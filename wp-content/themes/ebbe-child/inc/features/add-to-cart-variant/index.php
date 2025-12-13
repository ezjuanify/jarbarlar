<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    if (!is_shop() && !is_product_category() && !is_front_page()) return;

    load_features_assets($fn, ['jquery', 'wc-add-to-cart']);
});
?>