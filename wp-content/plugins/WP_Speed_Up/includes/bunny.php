<?php

add_action('rest_api_init', function () {
    register_rest_route('my-plugin/v1', '/all-assets', array(
        'methods' => 'GET',
        'callback' => 'fetch_all_assets',
        'permission_callback' => '__return_true', // Make it public
    ));
});

function fetch_all_assets() {
    // Example response for debugging
    return rest_ensure_response(array(
        'images' => array('https://example.com/wp-content/uploads/2024/09/sample.jpg'),
        'js' => array('https://example.com/wp-content/plugins/plugin-name/assets/js/script.js'),
        'css' => array('https://example.com/wp-content/plugins/plugin-name/assets/css/style.css'),
    ));
}


// add_action('rest_api_init', function () {
//     register_rest_route('my-plugin/v1', '/all-assets', array(
//         'methods' => 'GET',
//         'callback' => 'fetch_all_assets',
//         'permission_callback' => '__return_true', // Public endpoint
//     ));
// });

// function fetch_all_assets() {
//     // Fetch all images
//     $images_query = new WP_Query(array(
//         'post_type' => 'attachment',
//         'post_mime_type' => 'image',
//         'posts_per_page' => -1,
//     ));
//     $images = array();
//     while ($images_query->have_posts()) {
//         $images_query->the_post();
//         $images[] = wp_get_attachment_url(get_the_ID());
//     }
//     wp_reset_postdata();

//     // Fetch all enqueued JS and CSS
//     global $wp_scripts, $wp_styles;
//     $js_urls = array();
//     $css_urls = array();

//     foreach ($wp_scripts->queue as $handle) {
//         $script = $wp_scripts->registered[$handle];
//         $js_urls[] = $script->src;
//     }

//     foreach ($wp_styles->queue as $handle) {
//         $style = $wp_styles->registered[$handle];
//         $css_urls[] = $style->src;
//     }

//     return rest_ensure_response(array(
//         'images' => $images,
//         'js' => $js_urls,
//         'css' => $css_urls,
//     ));
// }


?>