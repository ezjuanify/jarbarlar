<?php
/*
Plugin Name: WordPress Speedy BunnyCDN Upload (Fixed)
Description: Fixed version with proper AJAX handling and error management
*/

if (!defined('ABSPATH')) exit;

// Configuration
define('BUNNY_CONCURRENT_LIMIT', 2); // Reduced concurrency for stability
define('BUNNY_HOSTNAME', 'storage.bunnycdn.com');
define('BUNNY_STORAGE_ZONE', 'wordpressspeedy');
define('BUNNY_ACCESS_KEY', '7052ed2a-4f9a-4f78-97c9d318ae0c-874c-4a14');

// Register AJAX handlers properly
add_action('admin_init', function() {
    add_action('wp_ajax_wordpress_speedy_upload', 'handle_upload_request');
    add_action('wp_ajax_wordpress_speedy_upload_progress', 'handle_progress_request');
});

// Admin interface
add_action('admin_menu', function() {
    add_menu_page(
        'BunnyCDN Upload',
        'BunnyCDN Upload',
        'manage_options',
        'bunnycdn-upload',
        'render_upload_page',
        'dashicons-cloud'
    );
});

function render_upload_page() {
    ?>
    <div class="wrap">
        <h1>Upload Files to BunnyCDN</h1>
        <form id="uploadForm">
            <?php wp_nonce_field('bunnycdn_upload_nonce', 'bunnycdn_nonce'); ?>
            <button type="submit" class="button button-primary">Start Upload</button>
        </form>

        <div class="progress-container" style="margin: 20px 0; background: #f1f1f1;">
            <div id="progress-bar" style="width: 0%; height: 30px; background: #0073aa; transition: width 0.5s ease; text-align: center; line-height: 30px; color: white;">
                0%
            </div>
        </div>
        <div id="upload-status" style="margin-top: 15px;"></div>
    </div>

    <script>
    (function($) {
        $(document).ready(function() {
            let progressInterval;
            const form = $('#uploadForm');
            const statusDiv = $('#upload-status');

            function updateProgress() {
                $.get("<?php echo admin_url('admin-ajax.php'); ?>", {
                    action: 'wordpress_speedy_upload_progress'
                }).done(function(response) {
                    const progress = response.progress || 0;
                    $('#progress-bar').css('width', progress + '%').text(progress.toFixed(0) + '%';
                    if(progress >= 100) {
                        statusDiv.html('<p style="color: green;">Upload completed!</p>');
                        clearInterval(progressInterval);
                    }
                }).fail(function(xhr) {
                    console.error('Progress check failed:', xhr.responseText);
                });
            }

            form.on('submit', function(e) {
                e.preventDefault();
                statusDiv.html('<p style="color: blue;">Starting upload...</p>');
                
                progressInterval = setInterval(updateProgress, 3000);

                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    method: 'POST',
                    data: {
                        action: 'wordpress_speedy_upload',
                        bunnycdn_nonce: $('#bunnycdn_nonce').val()
                    }
                }).done(function(response) {
                    if(!response.success) {
                        statusDiv.html('<p style="color: red;">Error: ' + (response.data || 'Unknown error') + '</p>');
                    }
                }).fail(function(xhr) {
                    statusDiv.html('<p style="color: red;">Server error: ' + xhr.statusText + '</p>');
                    clearInterval(progressInterval);
                });
            });
        });
    })(jQuery);
    </script>
    <?php
}

// Upload handler
function handle_upload_request() {
    check_ajax_referer('bunnycdn_upload_nonce', 'bunnycdn_nonce');
    
    @ini_set('max_execution_time', 0);
    @ini_set('memory_limit', '512M');

    try {
        global $wpdb;
        $files = $wpdb->get_col("SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file'");
        $upload_urls = array_map(fn($path) => ABSPATH . 'wp-content/uploads/' . $path, $files);
        
        $total = count($upload_urls);
        $processed = 0;
        update_option('bunnycdn_progress', 0);

        $mh = curl_multi_init();
        $handles = [];

        while ($processed < $total || count($handles)) {
            // Add new handles
            while (count($handles) < BUNNY_CONCURRENT_LIMIT && $processed < $total) {
                $file = $upload_urls[$processed];
                
                if (file_exists($file)) {
                    $url = sprintf('https://%s/%s/%s', 
                        BUNNY_HOSTNAME, 
                        BUNNY_STORAGE_ZONE, 
                        str_replace(ABSPATH, sanitize_text_field($_SERVER['HTTP_HOST']).'/', $file)
                    );

                    $fh = fopen($file, 'r');
                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_PUT => true,
                        CURLOPT_INFILE => $fh,
                        CURLOPT_INFILESIZE => filesize($file),
                        CURLOPT_HTTPHEADER => ["AccessKey: ".BUNNY_ACCESS_KEY]
                    ]);
                    
                    curl_multi_add_handle($mh, $ch);
                    $handles[(int)$ch] = ['handle' => $ch, 'file' => $fh];
                    $processed++;
                } else {
                    $processed++;
                }
            }

            // Process handles
            $active = null;
            do {
                $status = curl_multi_exec($mh, $active);
            } while ($active && $status === CURLM_OK);

            // Update progress
            if ($processed > 0) {
                $progress = ($processed / $total) * 100;
                if ($progress % 5 === 0) {
                    update_option('bunnycdn_progress', $progress);
                }
            }

            // Cleanup completed handles
            while ($info = curl_multi_info_read($mh)) {
                $ch = $info['handle'];
                if (isset($handles[(int)$ch])) {
                    fclose($handles[(int)$ch]['file']);
                    curl_multi_remove_handle($mh, $ch);
                    curl_close($ch);
                    unset($handles[(int)$ch]);
                }
            }
            
            usleep(1000000); // 1 second delay between batches
        }

        curl_multi_close($mh);
        update_option('bunnycdn_progress', 100);
        wp_send_json_success();
    } catch (Exception $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
}

// Progress handler
function handle_progress_request() {
    wp_send_json(['progress' => (float)get_option('bunnycdn_progress', 0)]);
}