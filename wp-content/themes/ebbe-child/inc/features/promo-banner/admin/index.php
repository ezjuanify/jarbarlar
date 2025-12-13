<?php

$fn  = $admin_feature_fn;
$dir = get_stylesheet_directory();
$uri = get_stylesheet_directory_uri();

add_action('admin_enqueue_scripts', function ($hook) use ($fn, $dir, $uri) {
    if ($hook !== 'settings_page_promo-banner-settings') return;

    wp_enqueue_style(
        'flatpickr-style',
        $uri . '/inc/vendor/flatpickr/flatpickr.min.css',
        [],
        filemtime($dir . '/inc/vendor/flatpickr/flatpickr.min.css')
    );

    wp_enqueue_script(
        'flatpickr',
        $uri . '/inc/vendor/flatpickr/flatpickr.min.js',
        [],
        filemtime($dir . '/inc/vendor/flatpickr/flatpickr.min.js'),
        true
    );

    load_features_admin_assets($fn, ['jquery', 'flatpickr']);
});

add_action('admin_menu', function () {
    add_options_page(
        'Promo Banner Settings',
        'Promo Banner',
        'manage_options',
        'promo-banner-settings',
        'promo_banner_settings_page'
    );
});

function promo_banner_settings_page() {
    require __DIR__ . '/template.php';
}

add_action('admin_init', function () {
    register_setting('promo_banner_settings_group', 'promo_banner_heading');
    register_setting('promo_banner_settings_group', 'promo_banner_countdown_enabled');
    register_setting('promo_banner_settings_group', 'promo_banner_countdown_end');

    add_settings_section(
        'promo_banner_main_section',
        'Promo Banner Settings',
        null,
        'promo-banner-settings'
    );

    add_settings_field(
        'promo_banner_heading',
        'Heading',
        'promo_banner_heading_field',
        'promo-banner-settings',
        'promo_banner_main_section'
    );

    add_settings_field(
        'promo_banner_countdown_enabled',
        'Enable Countdown',
        'promo_banner_countdown_enabled_field',
        'promo-banner-settings',
        'promo_banner_main_section'
    );

    add_settings_field(
        'promo_banner_countdown_end',
        'Date End',
        'promo_banner_countdown_end_field',
        'promo-banner-settings',
        'promo_banner_main_section'
    );
});

function promo_banner_heading_field() {
    $value = get_option('promo_banner_heading', '');
    echo '<input type="text" name="promo_banner_heading" value="' . esc_attr($value) . '" style="width:1200px">';
}

function promo_banner_countdown_enabled_field() {
    $enabled = get_option('promo_banner_countdown_enabled', '0');

    echo '<label>';
    echo '<input id="promo_banner_countdown_enabled" name="promo_banner_countdown_enabled" type="checkbox" value="1" ' . checked(1, $enabled, false) . ' />';
    echo '</label>';
}

function promo_banner_countdown_end_field() {
    $value = get_option('promo_banner_countdown_end', '');

    echo '<input id="promo_banner_countdown_end" name="promo_banner_countdown_end" type="text" value="' . esc_attr($value) . '" style="width:250px" />';
}

?>