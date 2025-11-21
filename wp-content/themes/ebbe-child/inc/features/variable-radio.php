<?php
add_action('wp_enqueue_scripts', function () {
    if (!is_product()) return;

    wp_enqueue_script(
        'variable-radio',
        get_stylesheet_directory_uri() . '/assets/js/variable-radio.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/js/variable-radio.js'),
        true
    );
});

wp_enqueue_style(
    'variable-radio',
    get_stylesheet_directory_uri() . '/assets/css/variable-radio.css',
    [],
    filemtime(get_stylesheet_directory() . '/assets/css/variable-radio.css')
);
?>