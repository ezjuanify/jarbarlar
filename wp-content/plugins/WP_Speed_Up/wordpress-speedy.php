<?php
/*
Plugin Name: WP Speedup
Plugin URI: https://wp.websitespeedy.com/
Description: Upgrade Your WordPress Website Speed With Just-A-Click! No more revenue loss. Get higher conversion rates and more organic traffic with WP Speedup.
Version: 1.0
Author: Makkpress Technology Pvt. Ltd.
Author URI: https://makkpress.com/
Text Domain: WordpressSpeedy

*/


// Check if the 'ABSPATH' constant is defined to prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Load required files
require_once plugin_dir_path(__FILE__) . 'includes/class-cache-optimizer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-image-optimizer.php';

require_once plugin_dir_path(__FILE__) . 'includes/class-htaccess-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-config-handler.php';

require_once plugin_dir_path(__FILE__) . 'includes/class-test-htaccess-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-test-config-handler.php';

require_once plugin_dir_path(__FILE__) . 'includes/class-css-optimizer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-js-optimizer.php';
require_once plugin_dir_path(__FILE__) . 'includes/purge_cache.php';
//require_once plugin_dir_path(__FILE__) . 'includes/bunny.php';



// Load Full Page Cache class
require_once plugin_dir_path(__FILE__) . 'includes/class-fullpage-cache.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-database-optimizer.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-resource-preload.php';
// require_once plugin_dir_path(__FILE__) . 'includes/class-gzip-compression.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-html-minifier.php';


// Include dashboard and system report pages
require_once plugin_dir_path(__FILE__) . 'dashboard.php';
require_once plugin_dir_path(__FILE__) . 'system-report.php';
require_once plugin_dir_path(__FILE__) . 'visitors-analytics.php'; // New analytics page
require_once plugin_dir_path(__FILE__) . 'speed-report.php'; // New analytics page
require_once plugin_dir_path(__FILE__) . 'bunny-upload.php';



// Function to include the tracking URL in all pages
function add_tracking_file_hit() {
    // Dynamically generate the tracking file URL
    $site_url = get_site_url();
    $hostname = parse_url($site_url, PHP_URL_HOST);
    $tracking_url = "https://wordpressspeedy.b-cdn.net/{$hostname}/tracking/track.txt";

    // Output the tracking URL as an invisible request
    echo "
    <script>
        (function() {
            var img = new Image();
            img.src = '{$tracking_url}';
        })();
    </script>
    ";
}
add_action('wp_footer', 'add_tracking_file_hit');




function register_site_urls_api() {
    register_rest_route('site-urls/v1', '/all', [
        'methods'  => 'GET',
        'callback' => 'get_all_site_urls_api',
        'permission_callback' => '__return_true', // Allow public access
    ]);
}
add_action('rest_api_init', 'register_site_urls_api');

function get_all_site_urls_api() {
    $urls = [];

    // 1. Fetch standard posts and pages in chunks
    $args = [
        'post_type'      => ['post', 'page'],
        'post_status'    => 'publish',
        'posts_per_page' => 100, // Fetch 100 at a time
    ];
    $paged = 1;

    do {
        $args['paged'] = $paged;
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $urls[] = get_permalink();
            }
        }
        $paged++;
    } while ($query->have_posts());

    wp_reset_postdata();

    // 2. Fetch WooCommerce products in chunks
    if (post_type_exists('product')) {
        $product_args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 100, // Fetch 100 at a time
        ];
        $paged = 1;

        do {
            $product_args['paged'] = $paged;
            $product_query = new WP_Query($product_args);

            if ($product_query->have_posts()) {
                while ($product_query->have_posts()) {
                    $product_query->the_post();
                    $urls[] = get_permalink();
                }
            }
            $paged++;
        } while ($product_query->have_posts());

        wp_reset_postdata();
    }

    // 3. Fetch product categories
    if (taxonomy_exists('product_cat')) {
        $product_categories = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ]);
        foreach ($product_categories as $category) {
            $urls[] = get_term_link($category);
        }
    }

    // 4. Fetch product tags
    if (taxonomy_exists('product_tag')) {
        $product_tags = get_terms([
            'taxonomy'   => 'product_tag',
            'hide_empty' => false,
        ]);
        foreach ($product_tags as $tag) {
            $urls[] = get_term_link($tag);
        }
    }

    // 5. Fetch custom post types in chunks
    $custom_post_types = get_post_types(['_builtin' => false], 'objects');
    foreach ($custom_post_types as $post_type) {
        $args = [
            'post_type'      => $post_type->name,
            'post_status'    => 'publish',
            'posts_per_page' => 100,
        ];
        $paged = 1;

        do {
            $args['paged'] = $paged;
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $urls[] = get_permalink();
                }
            }
            $paged++;
        } while ($query->have_posts());

        wp_reset_postdata();
    }

    // 6. Fetch all taxonomy terms
    $taxonomies = get_taxonomies([], 'objects');
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(['taxonomy' => $taxonomy->name, 'hide_empty' => false]);
        foreach ($terms as $term) {
            $urls[] = get_term_link($term);
        }
    }

    // 7. Add home, archive, and special pages
    $urls[] = home_url(); // Homepage
    if (post_type_exists('product')) {
        $urls[] = get_post_type_archive_link('product'); // Product archive
    }
    $urls[] = get_post_type_archive_link('post'); // Blog archive

    // Return the JSON response
    return rest_ensure_response(array_unique($urls)); // Remove duplicates
}




function custom_hello_world_endpoint() {
    $namespace = 'custom/v1';
    $route = '/current_images';

    register_rest_route($namespace, $route, array(
        'methods' => 'GET',
        'callback' => 'custom_hello_world_callbacka',
        'args' => array(),
        'permission_callback' => '__return_true', // Allow public access
    ));
}

function custom_hello_world_callbacka() {
    
    
    global $wpdb; // This gives us access to the WordPress database.
    
    // Query to get all file paths from the wp_postmeta table where the meta key is '_wp_attached_file'.
    $query = "SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file'";
    $results = $wpdb->get_col($query);

    // Construct full URLs from the results.
    $upload_urls = array_map(function($path) {
        return home_url('/wp-content/uploads/' . $path);
    }, $results);

    // Return the result.
    return rest_ensure_response(array(
        'message' => json_encode($upload_urls),
    ));
    

    // $directories = [
    //     WP_CONTENT_DIR . '/uploads',
    //     WP_CONTENT_DIR . '/plugins',
    //     WP_CONTENT_DIR . '/themes'
    // ];
    
    // // File extensions to look for (CSS, JS, images)
    // $allowed_extensions = [
    //     'jpg',  // JPEG
    //     'jpeg', // JPEG
    //     'png',  // PNG
    //     'gif',  // GIF
    //     'bmp',  // Bitmap
    //     'svg',  // Scalable Vector Graphics
    //     'webp', // WebP (modern, optimized format)
    //     'tiff', // Tagged Image File Format
    //     'tif',  // Tagged Image File Format (alternative extension)
    //     'ico'   // Icon files (favicons, etc.)
    // ];
    
    // // Collect all file paths and construct URLs
    // $upload_urls = [];
    // foreach ($directories as $directory) {
    //     $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    //     foreach ($iterator as $file) {
    //         if ($file->isFile() && in_array(strtolower($file->getExtension()), $allowed_extensions)) {
    //             $relative_path = str_replace(ABSPATH, '', $file->getPathname());
    //             $upload_urls[] = '/'.$relative_path;
    //         }
            
       
    //     }
      
    // }
    

    // $upload_urls = json_encode($upload_urls);

    // return rest_ensure_response(array(
    //     'message' => $upload_urls,
    // ));
}

add_action('rest_api_init', 'custom_hello_world_endpoint');


function allow_rest_api_cors($value) {
    header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Allowed HTTP methods
    header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Allowed headers
    return $value;
}
add_action('rest_api_init', function () {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers'); // Remove default CORS filter
    add_filter('rest_pre_serve_request', 'allow_rest_api_cors'); // Add custom CORS filter
});



function replace_final_output_urls($buffer) {
    $origin_url = get_site_url();
    $parsed_origin = parse_url($origin_url);
    $domain = isset($parsed_origin['host']) ? $parsed_origin['host'] : '';

    // Construct BunnyCDN URL correctly
    $bunny_cdn_url = 'https://wordpressspeedy.b-cdn.net/' . $domain;

    // Ensure images, CSS, and JS assets use BunnyCDN while keeping the rest of the site intact
    $buffer = preg_replace_callback(
        '/<(img|script|link)[^>]+(src|href)=["\']([^"\']+)["\']/i',
        function ($matches) use ($origin_url, $bunny_cdn_url) {
            $tag = $matches[1]; // img, script, or link
            $attribute = $matches[2]; // src or href
            $url = $matches[3]; // Current URL
            
            // Only replace assets (images, CSS, JS)
            if (strpos($url, $origin_url) === 0 && preg_match('/\.(jpg|jpeg|png|gif|webp|svg|css|js)$/i', $url)) {
                $updated_url = str_replace($origin_url, $bunny_cdn_url, $url);
                return "<{$tag} {$attribute}=\"{$updated_url}\"";
            }

            return $matches[0]; // Return original tag if no change
        },
        $buffer
    );

    return $buffer;
}

// function start_output_buffering() {
    
//     ob_start('replace_final_output_urls');
// }
// Enqueue styles
function wordpress_speedy_enqueue_styles() {
    wp_enqueue_style(
        'my-site-optimizer-styles',
        plugin_dir_url(__FILE__) . 'assets/styles.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'wordpress_speedy_enqueue_styles');

// Enqueue custom JavaScript for status update
function wordpress_speedy_enqueue_custom_js() {
    wp_enqueue_script(
        'wordpress-speedy-status-js',
        plugin_dir_url(__FILE__) . 'assets/scripts.js', // Path to your JS file
        ['jquery'],
        '1.0.0',
        true
    );

    // Pass the AJAX URL to the script
    wp_localize_script('wordpress-speedy-status-js', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}
add_action('admin_enqueue_scripts', 'wordpress_speedy_enqueue_custom_js');




// Add custom meta links below the plugin description
function wordpress_speedy_plugin_meta_links($links, $file) {
    // Check if it's your plugin
    if ($file == plugin_basename(__FILE__)) {
        // Add custom meta links
        $custom_links = array(
            '<a href="https://help.websitespeedy.com/" target="_blank">Documentation</a>',
            '<a href="https://help.websitespeedy.com/" target="_blank">Support</a>',
            '<a href="https://wp.websitespeedy.com/pricing" target="_blank">Premium Version</a>'
        );

        // Merge the custom links with existing ones
        $links = array_merge($links, $custom_links);
    }
    
    return $links;
}
add_filter('plugin_row_meta', 'wordpress_speedy_plugin_meta_links', 10, 2);




// Initialize the plugin
function wordpress_speedy_init() {

//     if (class_exists('Cache_Optimizer')) {
//         Cache_Optimizer::init();
//     }
//     if (class_exists('Image_Optimizer')) {
//         Image_Optimizer::init();
//     }


// if (class_exists('CSS_Optimizer')) {
//         CSS_Optimizer::init();
//     }
//     if (class_exists('JS_Optimizer')) {
//         JS_Optimizer::init();
//     }

//   if (class_exists('Htaccess_Handler')) {
//         Htaccess_Handler::update_htaccess();
//     }
//     if (class_exists('Config_Handler')) {
//         Config_Handler::update_wp_config();
//     }

    
}
add_action('plugins_loaded', 'wordpress_speedy_init');

// Add Settings Link on the Plugins Page
function wordpress_speedy_settings_link($links) {
    $settings_link = '<a href="admin.php?page=wordpress-speedy-dashboard">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wordpress_speedy_settings_link');

/// Add Dynamic Status in the Admin Menu Header
function wordpress_speedy_admin_bar_status($wp_admin_bar) {
    // Get the logo URL
    $logo_url = plugin_dir_url(__FILE__) . 'assets/favicon.ico'; // Adjust this path if necessary

    // Add the status node with a placeholder that will be updated via JavaScript
    $args = [
        'id'    => 'wordpress_speedy_status',
        'title' => '<img src="' . esc_url($logo_url) . '" alt="Logo" style="height:16px; vertical-align:middle; margin-right:5px;"> 
                    <span id="speedy-status-indicator" style="font-weight: bold;"></span>',
        'meta'  => ['class' => 'my-site-optimizer-status']
    ];

    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'wordpress_speedy_admin_bar_status', 100);




// Add Sidebar Menu in Admin with Visitor Analytics
function wordpress_speedy_sidebar_menu() {
    add_menu_page(
        'WordPressSpeedy',
        'WordPressSpeedy',
        'manage_options',
        'wordpress-speedy-dashboard',
        'wp_speedy_dashboard',
        plugin_dir_url(__FILE__) . 'assets/favicon.ico',
        2
    );
    add_submenu_page(
        'wordpress-speedy-dashboard',
        'Dashboard',
        'Dashboard',
        'manage_options',
        'wordpress-speedy-dashboard',
        'wp_speedy_dashboard'
    );
    add_submenu_page(
        'wordpress-speedy-dashboard',
        'System Report',
        'System Report',
        'manage_options',
        'wordpress-speedy-system-report',
        'wordpress_speedy_system_report_page'
    );
    
        add_submenu_page(
        'wordpress-speedy-dashboard',
        'Bunny Upload',
        'Bunny Upload',
        'manage_options',
        'wordpress-speedy-bunny-upload',
        'wordpress_speedy_bunny_upload_page'
    );
    // add_submenu_page(
    //     'wordpress-speedy-dashboard',
    //     'Visitor Analytics',
    //     'Visitor Analytics',
    //     'manage_options',
    //     'wordpress-speedy-visitor-analytics',
    //     'wp_speedy_visitor_analytics_page'
    // );
    // add_submenu_page(
    //     'wordpress-speedy-dashboard',
    //     'Boost Report',
    //     'Boost Report',
    //     'manage_options',
    //     'wordpress-speedy-boost-report',
    //     'wp_speedy_boost_report_page'
    // );
    // add_submenu_page(
    //     'wordpress-speedy-dashboard',
    //     'Speed Report',
    //     'Speed Report',
    //     'manage_options',
    //     'wordpress-speedy-speed-report',
    //     'wordpress_speedy_speed_report_page'
    // );
}

add_action('admin_menu', 'wordpress_speedy_sidebar_menu');



// Register plugin lifecycle hooks
register_activation_hook(__FILE__, function() {
    $hostname = parse_url(get_site_url(), PHP_URL_HOST);
    $plugin_status = 1;

    // Send data to the external API
    $response = wp_remote_post('https://ausdigital.agency/api/user/plugin_status', [
        'method'    => 'POST',
        'headers'   => [
            'Content-Type' => 'application/json',
        ],
        'body'      => json_encode([
            'hostname'      => $hostname,
            'plugin_status' => $plugin_status,
        ]),
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        error_log('Failed to send plugin status: ' . $response->get_error_message());
    } else {
        error_log('Plugin activation status sent successfully');
    }
});

register_deactivation_hook(__FILE__, function() {
    $hostname = parse_url(get_site_url(), PHP_URL_HOST);
    $plugin_status = 0;

    // Send data to the external API
    $response = wp_remote_post('https://ausdigital.agency/api/user/plugin_status', [
        'method'    => 'POST',
        'headers'   => [
            'Content-Type' => 'application/json',
        ],
        'body'      => json_encode([
            'hostname'      => $hostname,
            'plugin_status' => $plugin_status,
        ]),
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        error_log('Failed to send plugin status: ' . $response->get_error_message());
    } else {
        error_log('Plugin deactivation status sent successfully');
    }

    // Remove custom code from .htaccess and wp-config.php
    if (class_exists('Htaccess_Handler')) {
        Htaccess_Handler::remove_htaccess_code();
    }
    if (class_exists('Config_Handler')) {
        Config_Handler::remove_wp_config_code();
    }
});

// Uninstall logic
register_uninstall_hook(__FILE__, 'speedy_handle_uninstall');

function speedy_handle_uninstall() {
    $hostname = parse_url(get_site_url(), PHP_URL_HOST);
    $plugin_status = 0;

    // Send data to the external API
    $response = wp_remote_post('https://ausdigital.agency/api/user/plugin_status', [
        'method'    => 'POST',
        'headers'   => [
            'Content-Type' => 'application/json',
        ],
        'body'      => json_encode([
            'hostname'      => $hostname,
            'plugin_status' => $plugin_status,
        ]),
    ]);

    // Check for errors
    if (is_wp_error($response)) {
        error_log('Failed to send plugin status: ' . $response->get_error_message());
    } else {
        error_log('Plugin uninstall status sent successfully');
    }

    // Remove custom code from .htaccess and wp-config.php
    if (class_exists('Htaccess_Handler')) {
        Htaccess_Handler::remove_htaccess_code();
    }
    if (class_exists('Config_Handler')) {
        Config_Handler::remove_wp_config_code();
    }
}


if(!isset($_GET['nospeedy'])){


$hostname = parse_url(get_site_url(), PHP_URL_HOST);
$response = wp_remote_post('https://ausdigital.agency/api/wordpress/get_site_data', array(
    'method'    => 'POST',
    'headers'   => array(
        'Content-Type' => 'application/json'
    ),
    'body'      => json_encode([
        'hostname'      => $hostname,
    ]),

));



// Check if the response is an error
if (is_wp_error($response)) {
        

        // Remove custom code from .htaccess and wp-config.php
        if (class_exists('Htaccess_Handler')) {
            Htaccess_Handler::remove_htaccess_code();
        }
        if (class_exists('Config_Handler')) {
            Config_Handler::remove_wp_config_code();
        }
        
             // Remove test code from .htaccess and wp-config.php
            if (class_exists('Test_Htaccess_Handler')) {
                Test_Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Test_Config_Handler')) {
                Test_Config_Handler::remove_wp_config_code();
            }
        

} else {
  

    $body = wp_remote_retrieve_body($response);


    if(isset($body)){

    

    // Decode JSON response into an associative array
    $response = json_decode($body, true);

    $response = isset($response['message'][0])?$response['message'][0]:'';
    
   
    if(!empty($response)){
        

        


        $plugin_installed = isset($response['plugin_install'])?$response['plugin_install']:'';
        $speed_boost = isset($response['speed_boost'])?$response['speed_boost']:'';
        $plugin_connected = isset($response['plugin_connected'])?$response['plugin_connected']:'';
        $bunny_cdn_optimization = isset($response['bunny_cdn_optimization'])?$response['bunny_cdn_optimization']:1;
        $auto_purge = isset($response['auto_purge'])?$response['auto_purge']:1;
        $test_mode  = isset($response['test_mode'])?$response['test_mode']:0; 
        
        if($auto_purge == 1){
            
            add_action('save_post', 'auto_purge_cache_on_update');
            add_action('wp_update_nav_menu', 'auto_purge_cache_on_update');
            add_action('switch_theme', 'auto_purge_cache_on_update');
        }

    

        if($plugin_installed == 1 && $speed_boost == 1 && $plugin_connected == 1 && $test_mode == 0){
    
 
            
            if (class_exists('Cache_Optimizer')) {
                Cache_Optimizer::init();
            }
            if (class_exists('Image_Optimizer')) {
                Image_Optimizer::init();
            }
        
            if (class_exists('Full_Page_Cache')) {
                Full_Page_Cache::init();
            }
            
            
             if (class_exists('Database_Optimizer')) {
                Database_Optimizer::init(); // Initialize Database Optimizer
            }
            
            
             if (class_exists('Resource_Preload')) {
                Resource_Preload::init(); // Initialize Resource Preload
            }
            
            
            //  if (class_exists('GZIP_Optimizer')) {
            //     GZIP_Optimizer::init(); // Initialize GZIP Compression
            // }
            
            if (class_exists('HTML_Minifier')) {
                HTML_Minifier::init(); // Initialize HTML Minifier
            }
            
        
        if (class_exists('CSS_Optimizer')) {
                CSS_Optimizer::init();
            }
            if (class_exists('JS_Optimizer')) {
                JS_Optimizer::init();
            }
        
          if (class_exists('Htaccess_Handler')) {
                Htaccess_Handler::update_htaccess();
            }
            if (class_exists('Config_Handler')) {
                Config_Handler::update_wp_config();
            }
            
            if($bunny_cdn_optimization == 1){
                
            // add_action('template_redirect', 'start_output_buffering');
                
            }
    
    
    
    
        }else if($plugin_installed == 1 && $speed_boost == 1 && $plugin_connected == 1 && $test_mode == 1){
            
    
            
            if(isset($_GET['withspeedy'])){
                
                  if (class_exists('Cache_Optimizer')) {
                Cache_Optimizer::init();
            }
            if (class_exists('Image_Optimizer')) {
                Image_Optimizer::init();
            }
        
            if (class_exists('Full_Page_Cache')) {
                Full_Page_Cache::init();
            }
            
            
             if (class_exists('Database_Optimizer')) {
                Database_Optimizer::init(); // Initialize Database Optimizer
            }
            
            
             if (class_exists('Resource_Preload')) {
                Resource_Preload::init(); // Initialize Resource Preload
            }
            
            
            //  if (class_exists('GZIP_Optimizer')) {
            //     GZIP_Optimizer::init(); // Initialize GZIP Compression
            // }
            
            if (class_exists('HTML_Minifier')) {
                HTML_Minifier::init(); // Initialize HTML Minifier
            }
            
        
        if (class_exists('CSS_Optimizer')) {
                CSS_Optimizer::init();
            }
            if (class_exists('JS_Optimizer')) {
                JS_Optimizer::init();
            }
            
            
                     if($bunny_cdn_optimization == 1){
                
            add_action('template_redirect', 'start_output_buffering');
                
            }
                
                
            }
            
            
        //add test htaccess and wpconfig code if test mode is on
          if (class_exists('Test_Htaccess_Handler')) {
                Test_Htaccess_Handler::update_htaccess();
            }
            if (class_exists('Test_Config_Handler')) {
                Test_Config_Handler::update_wp_config();
            }
            
            
            //remove og htaccess and wpconfig code if test mode is on
            if (class_exists('Htaccess_Handler')) {
                Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Config_Handler')) {
                Config_Handler::remove_wp_config_code();
            }
            
   
        
        }
        else{
    
            // Remove live custom code from .htaccess and wp-config.php
            if (class_exists('Htaccess_Handler')) {
                Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Config_Handler')) {
                Config_Handler::remove_wp_config_code();
            }
    
    
        }
        
        
        
        
        if($test_mode == 0){
            
            
         // Remove test code from .htaccess and wp-config.php
            if (class_exists('Test_Htaccess_Handler')) {
                Test_Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Test_Config_Handler')) {
                Test_Config_Handler::remove_wp_config_code();
            }
        
        }


    }
    else{
    
            // Remove custom code from .htaccess and wp-config.php
            if (class_exists('Htaccess_Handler')) {
                Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Config_Handler')) {
                Config_Handler::remove_wp_config_code();
            }
            
            
            // Remove test code from .htaccess and wp-config.php
            if (class_exists('Test_Htaccess_Handler')) {
                Test_Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Test_Config_Handler')) {
                Test_Config_Handler::remove_wp_config_code();
            }
    
    
        }



  
    }else{
        
        
                // Remove live code from .htaccess and wp-config.php
            if (class_exists('Htaccess_Handler')) {
                Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Config_Handler')) {
                Config_Handler::remove_wp_config_code();
            }
        
        // Remove test code from .htaccess and wp-config.php
            if (class_exists('Test_Htaccess_Handler')) {
                Test_Htaccess_Handler::remove_htaccess_code();

               
            }
            if (class_exists('Test_Config_Handler')) {
                Test_Config_Handler::remove_wp_config_code();
            }
        
        
    }
}


}


add_action('wp_ajax_get_connected_status', 'get_connected_status');
function get_connected_status() {
    // Check if the plugin is connected
    $is_connected = (get_option('connected_status') == 1);
    wp_send_json_success(['connected' => $is_connected]);
}
