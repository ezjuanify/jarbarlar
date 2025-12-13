<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    load_features_assets($fn);
});

add_action('features/' . $fn, function () use ($fn) {
    get_template_part(get_features_base_path() . $fn . '/template');
});

if (is_admin()) {
    $admin_feature_fn = $fn;
    require __DIR__ . '/admin/index.php';
}

?>