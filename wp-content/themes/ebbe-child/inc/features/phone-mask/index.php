<?php

$fn  = basename(__DIR__);

add_action('wp_enqueue_scripts', function () use ($fn) {
    if (!is_checkout() && !is_account_page()) return;

    load_features_assets($fn);
});

add_filter('woocommerce_checkout_fields', function ($fields) {
    $fields['billing']['billing_phone']['placeholder']  = '123-456-7890';
    $fields['billing']['billing_phone']['maxlength']    = 12;
    $fields['billing']['billing_postcode']['maxlength'] = 10;
    return $fields;
});

?>