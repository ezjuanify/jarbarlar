<?php


function handle_purge_cache_rest_api(WP_REST_Request $request) {
    // Purge cache logic
    purge_wordpress_transients();
    purge_wordpress_object_cache();

    $current_time_mysql = current_time('mysql');
    $current_time_formatted = date('M j, Y, g:ia', strtotime($current_time_mysql));
    update_option('last_cache_purge_time', $current_time_formatted);

    return new WP_REST_Response(array(
        'success' => true,
        'message' => 'Cache has been purged!',
        'time' => $current_time_formatted
    ), 200);
}

// Register the REST API route
function register_purge_cache_rest_route() {
    register_rest_route('myplugin/v1', '/purge-cache', array(
        'methods'  => 'POST',
        'callback' => 'handle_purge_cache_rest_api',
        'permission_callback' => '__return_true', // Public access
    ));
}
add_action('rest_api_init', 'register_purge_cache_rest_route');

// Add CORS support to allow cross-domain access
function add_cors_headers_to_rest_api() {
    header("Access-Control-Allow-Origin: *"); // Public access from any domain
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
}
add_action('rest_api_init', function () {
    add_action('send_headers', 'add_cors_headers_to_rest_api');
});




function enqueue_purge_cache_script() {
    // Ensure jQuery is loaded
    wp_enqueue_script('jquery');

    // Localize script to pass the AJAX URL and nonce
    wp_localize_script('jquery', 'purgeCacheAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),  // WordPress AJAX handler
        'nonce'    => wp_create_nonce('purge_cache_nonce') // Security nonce
    ));
}
add_action('admin_enqueue_scripts', 'enqueue_purge_cache_script');

function handle_purge_cache_ajax() {
    // Check if nonce is valid
    if (!check_ajax_referer('purge_cache_nonce', 'nonce', false)) {
        wp_send_json_error('Nonce verification failed.');
        wp_die();
    }

    // Call your cache purging functions
    purge_wordpress_transients();
    purge_wordpress_object_cache();

    // Get the current timestamp
    $current_time_mysql = current_time('mysql'); // Get the current time in MySQL format
    $current_time_formatted = date('M j, Y, g:ia', strtotime($current_time_mysql)); // Format the time
    
    // Save the formatted time to the database
    update_option('last_cache_purge_time', $current_time_formatted);

    // Return the success response with the timestamp
    wp_send_json_success(array(
        'message' => 'Cache has been purged!',
        'time' => $current_time_formatted
    ));

    wp_die();
}

// Hook into the AJAX request (for logged-in users)
add_action('wp_ajax_purge_cache', 'handle_purge_cache_ajax');

// Non-logged-in users
add_action('wp_ajax_nopriv_purge_cache', 'handle_purge_cache_ajax');

// Purge Transients
function purge_wordpress_transients() {
    global $wpdb;
    // Clear all transients
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_%'");
}

// Purge Object Cache
function purge_wordpress_object_cache() {
    if (wp_using_ext_object_cache()) {
        wp_cache_flush(); // Flush the object cache
    }
}




function auto_purge_cache_on_update() {
    purge_wordpress_transients();
    purge_wordpress_object_cache();
}

?>
