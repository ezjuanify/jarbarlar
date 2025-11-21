<?php
add_action('wp_footer', function () {
    get_template_part('template-parts/whatsapp-button');
});

wp_enqueue_style(
    'whatsapp-button',
    get_stylesheet_directory_uri() . '/assets/css/whatsapp.css',
    [],
    filemtime(get_stylesheet_directory() . '/assets/css/whatsapp.css')
);
?>