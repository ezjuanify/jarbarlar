<?php
/**
 * Shortcode: Handler Functions
 */
function custom_shortcode_products_grid_by_category_handler($atts) {
    return render_products_engine($atts, 'grid');
}

function custom_shortcode_products_slider_by_category_handler($atts) {
    return render_products_engine($atts, 'slider');
}

function custom_shortcode_products_grid_single_collection_handler($atts) {
    return render_products_engine($atts, 'grid', true);
}

function custom_shortcode_products_slider_single_collection_handler($atts) {
    return render_products_engine($atts, 'slider', true);
}


/**
 * Shortcode: Products Render Engine
 */
function render_products_engine($atts, $layout, $show_header = false) {
    $context = build_products_query_context($atts);
    if ($context['error']) return $context['message'];

    $meta = get_collection_metadata($context['atts']['category']);
    if ($meta['error']) return $meta['message'];

    $query = new WP_Query($context['args']);

    ob_start();

    if ($show_header) render_products_collection_header($meta);
    render_products_collection($query, $layout);
    return ob_get_clean();
}


/**
 * Shortcode: Build Query Context for Products
 */
function build_products_query_context($atts, $defaults = []) {
    // Merge defaults
    $atts = shortcode_atts(
        wp_parse_args($defaults, [
            'category'       => '',
            'posts_per_page' => 4,
        ]),
        $atts,
    );

    // Sanitize
    $category_slug  = sanitize_text_field($atts['category']);
    $posts_per_page = (int) $atts['posts_per_page'];

    // Query args
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category_slug,
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
 * Shortcode: Render Products Collection Header HTML Elements
 */
function render_products_collection_header($meta) {
    get_template_part(
        'template-parts/collection-header',
        null,
        ['meta_data' => $meta]
    );
}


/**
 * Shortcode: Render Products Collection
 */
function render_products_collection($query, $layout) {
    if (!$query->have_posts()) {
        echo '<p>No products found.</p>';
        return;
    }
    
    echo '<div class="custom-products ' . esc_attr($layout) . '">';

    while ($query->have_posts()) {
        $query->the_post();
        global $product;
        if (!is_a($product, 'WC_Product')) continue;

        $product_data = custom_get_product_display_data($product);

        get_template_part(
            'template-parts/product-card',
            null,
            ['product_data' => $product_data]
        );
    }

    echo '</div>';

    wp_reset_postdata();
}


/**
 * Shortcode: Prepare Products Display Data
 */
function custom_get_product_display_data($product) {
    if (!$product instanceof WC_Product) {
        return [];
    }

    $data = [
        'id'          => $product->get_id(),
        'title'       => $product->get_name(),
        'url'         => get_permalink($product->get_id()),
        'thumbnail'   => $product->get_image(),
        'stock'       => $product->is_in_stock(),
        'category'    => '',
        'quantity'    => '',
        'country'     => $product->get_county,
        'flag_url'    => '',
        'points'      => 0,
        'rating'      => '',
        'rating_html' => wc_get_rating_html($product->get_average_rating()),
        'type'        => $product->get_type(),
        'variations'  => [],
    ];

    // Get first category
    $categories = get_the_terms($product->get_id(), 'product_cat');
    if ($categories && !is_wp_error($categories)) {
        $data['category'] = esc_html($categories[0]->name);
    }

    // Loyalty points
    // $data['points'] = get_loyalty_points($product);

    // Quantity parsing from SKU
    $sku = $product->get_sku();
    if ($sku && preg_match('/\d+$/', $sku, $matches)) {
        $data['quantity'] = ltrim($matches[0], '0') . ' ml';
    }

    // Base country (no API calls)
    $data['flag_url'] = get_country_flag_url($product);

    // Variations
    $data['variations'] = get_products_variations($product);

    return $data;
}


/**
 * Shortcode: Get Product Variations
 */
function get_products_variations($product) {
    if (!$product || !$product->is_type('variable')) {
        return [];
    }

    $variations = [];

    foreach ($product->get_available_variations() as $variation) {
        $variation_label = implode(' ', array_map('esc_html', $variation['attributes']));
        $variation_price = wc_price($variation['display_price']);

        $variations[] = [
            'id'    => $variation['variation_id'],
            'label' => $variation_label,
            'price' => $variation_price,
        ];
    }

    return $variations;
}
?>