<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    if (!is_product()) return;

    load_features_assets($fn);
});

?>