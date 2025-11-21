<?php

// Load shortcode modules
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/blogs.php';
require_once __DIR__ . '/utils.php';

// Register shortcodes
add_action('after_setup_theme', function () {
    // Multi-collection (homepage)
    add_shortcode('custom_products_grid', 'custom_shortcode_products_grid_by_category_handler');
    add_shortcode('custom_products_slider', 'custom_shortcode_products_slider_by_category_handler');

    // Single collection (full section)
    add_shortcode('custom_products_grid_single_collection', 'custom_shortcode_products_grid_single_collection_handler');
    add_shortcode('custom_products_slider_single_collection', 'custom_shortcode_products_slider_single_collection_handler');

    // Misc: Blog Articles
    add_shortcode('blog_articles', 'custom_shortcode_display_blog_articles_by_category_handler');
});

?>