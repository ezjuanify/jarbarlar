<?php
add_action('wp_enqueue_scripts', function () {
    if (!is_checkout() && !is_account_page()) return;

    wp_enqueue_script(
        'phone-mask',
        get_stylesheet_directory_uri() . '/assets/js/phone-mask.js',
        ['jquery'],
        filemtime(get_stylesheet_directory(). '/assets/js/phone-mask.js'),
        true
    );
});

add_filter('woocommerce_checkout_fields', 'bbloomer_checkout_phone_us_format');

function bbloomer_checkout_phone_us_format( $fields ) {
    $fields['billing']['billing_phone']['placeholder']  = '123-456-7890';
    $fields['billing']['billing_phone']['maxlength']    = 12;
    $fields['billing']['billing_postcode']['maxlength'] = 10;
    return $fields;
}
?>