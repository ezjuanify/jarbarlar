<?php
/**
 * Shortcode: Handler Functions
 */
function custom_shortcode_display_blog_articles_by_category_handler($atts) {
    return render_blog_engine($atts);
}

/**
 * Shortcode: Blog Render Engine
 */
function render_blog_engine($atts) {
    $context = build_blog_query_context($atts);
    if ($context['error']) return $context['message'];

    $query = new WP_Query($context['args']);

    ob_start();
    custom_render_blog_articles($query);
    return ob_get_clean();
}


/**
 * Shortcode: Build Query Context for Blog
 */
function build_blog_query_context($atts, $defaults = []) {
    // Merge defaults
    $atts = shortcode_atts(
        wp_parse_args($defaults, [
            'category'       => '',
            'posts_per_page' => 5,
        ]),
        $atts,
    );

    // Sanitize
    $category_slug  = sanitize_text_field($atts['category']);
    $posts_per_page = (int) $atts['posts_per_page'];

    // Query args
    $args = [
        'category_name'  => $category_slug,
        'posts_per_page' => $posts_per_page,
        'meta_query'     => [[
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS',
        ]]
    ];

    // Return both args and query for flexibility
    return [
        'error' => false,
        'atts'  => $atts,
        'args'  => $args,
    ];
}


/**
 * Shortcode: Render Blog HTML Elements
 */
function custom_render_blog_articles(WP_Query $query) {
    // Generate HTML
    echo '<div class="blog-articles-container">';
    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('template_parts/blog-articles');
    }
    echo '</div>';

    wp_reset_postdata();
}
?>