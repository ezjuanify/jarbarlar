<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    if (!is_product() && !is_shop() && !is_product_category()) return;

    load_features_assets($fn);
});

?>