<?php
// system-report.php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function wordpress_speedy_system_report_page() {
    echo '<div class="wrap">';
    echo '<h1>System Report</h1>';
    echo '<p>Here is your system information and diagnostics.</p>';

    // Styles for the layout and messages
    echo '<style>
            .system-report-container {
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-top: 20px;
            }
            .system-report-sections {
                display: flex;
                gap: 20px;
            }
            .system-report-section {
                flex: 1;
                min-width: 300px;
            }
            .system-report-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 14px;
                text-align: left;
            }
            .system-report-table th, .system-report-table td {
                padding: 10px;
                border: 1px solid #ddd;
            }
            .system-report-table th {
                background-color: #f4f4f4;
                font-weight: bold;
            }
            .status-green {
                color: green;
                font-weight: bold;
            }
            .status-red {
                color: red;
                font-weight: bold;
            }
            .update-button {
                background-color: #007cba;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 4px;
                cursor: pointer;
                text-decoration: none;
                position: relative;
            }
            .update-button.loading::after {
                content: "";
                position: absolute;
                right: 10px;
                width: 16px;
                height: 16px;
                border: 2px solid #fff;
                border-radius: 50%;
                border-top-color: transparent;
                animation: spin 0.6s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .update-message {
                margin-top: 10px;
                font-weight: bold;
            }
        </style>';

    // Boxed container start
    echo '<div class="system-report-container">';

    // Side-by-side layout for PHP and WordPress Information
    echo '<div class="system-report-sections">';

// PHP Information
echo '<div class="system-report-section">';
echo '<h2>PHP Information</h2>';
echo '<table class="system-report-table">';
echo '<tr><th>Item</th><th>Existing</th><th>Recommended</th></tr>';

// PHP Version
$php_version = phpversion();
$php_version_status = version_compare($php_version, '8.0', '>=') ? '<span class="status-green">✔</span>' : '<span class="status-red">✘</span>';
echo '<tr>
        <td>PHP Version</td>
        <td>' . $php_version . ' ' . $php_version_status . '</td>
        <td>8.0 or higher</td>
      </tr>';

// Memory Limit
$memory_limit = ini_get('memory_limit');
$memory_limit_bytes = wp_convert_hr_to_bytes($memory_limit);
$memory_limit_status = $memory_limit_bytes >= 512 * 1024 * 1024 ? '<span class="status-green">✔</span>' : '<span class="status-red">✘</span>';
echo '<tr>
        <td>Memory Limit</td>
        <td>' . $memory_limit . ' ' . $memory_limit_status . '</td>
        <td>512M or higher</td>
      </tr>';

// Max Execution Time
$max_execution_time = ini_get('max_execution_time');
$execution_time_status = $max_execution_time >= 300 ? '<span class="status-green">✔</span>' : '<span class="status-red">✘</span>';
echo '<tr>
        <td>Max Execution Time</td>
        <td>' . $max_execution_time . ' seconds ' . $execution_time_status . '</td>
        <td>300 seconds or higher</td>
      </tr>';

echo '</table>';
echo '</div>';

    // WordPress Information
    global $wp_version;
    echo '<div class="system-report-section">';
    echo '<h2>WordPress Information</h2>';
    echo '<table class="system-report-table">';
    echo '<tr><th>Item</th><th>Value</th></tr>';
    echo '<tr><td>WordPress Version</td><td>' . $wp_version;
    $latest_wp_version = get_transient('wp_latest_version');
    if (version_compare($wp_version, $latest_wp_version, '<')) {
        echo ' <span class="status-red">(Update available: ' . $latest_wp_version . ')</span>';
        echo ' <button class="update-button" id="core-update-button" onclick="updateCore()">Update</button>';
        echo '<div class="update-message" id="core-update-message"></div>';
    } else {
        echo ' <span class="status-green">(Up to date)</span>';
    }
    echo '</td></tr>';
    echo '<tr><td>Site URL</td><td>' . get_site_url() . '</td></tr>';
    echo '<tr><td>Home URL</td><td>' . get_home_url() . '</td></tr>';
    echo '</table>';
    echo '</div>';

    echo '</div>'; // End of side-by-side layout

    // Installed Plugins
    echo '<h2>Installed Plugins</h2>';
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $all_plugins = get_plugins();
    $update_plugins = get_site_transient('update_plugins');

    echo '<table class="system-report-table">';
    echo '<tr><th>Plugin Name</th><th>Version</th><th>Status</th></tr>';
    foreach ($all_plugins as $plugin_path => $plugin_data) {
        $plugin_name = esc_html($plugin_data['Name']);
        $plugin_version = esc_html($plugin_data['Version']);
        $plugin_update = isset($update_plugins->response[$plugin_path]) ? $update_plugins->response[$plugin_path]->new_version : false;

        if ($plugin_update && version_compare($plugin_version, $plugin_update, '<')) {
            $status = '<span class="status-red">Update available: ' . $plugin_update . '</span>';
            echo '<tr><td>' . $plugin_name . '</td><td>' . $plugin_version . '</td><td>' . $status;
            echo ' <button class="update-button" id="plugin-update-button-' . esc_attr(sanitize_title($plugin_name)) . '" onclick="updatePlugin(\'' . esc_js($plugin_path) . '\')">Update</button>';
            echo '<div class="update-message" id="plugin-update-message-' . esc_attr(sanitize_title($plugin_name)) . '"></div>';
            echo '</td></tr>';
        } else {
            $status = '<span class="status-green">Up to date</span>';
            echo '<tr><td>' . $plugin_name . '</td><td>' . $plugin_version . '</td><td>' . $status . '</td></tr>';
        }
    }
    echo '</table>';

    // Active Theme Information
    $theme = wp_get_theme();
    $theme_name = $theme->get('Name');
    $theme_version = $theme->get('Version');

    echo '<h2>Active Theme</h2>';
    echo '<table class="system-report-table">';
    echo '<tr><th>Theme Name</th><th>Version</th><th>Status</th></tr>';
    $update_themes = get_site_transient('update_themes');
    if ($update_themes && isset($update_themes->response[$theme->get_stylesheet()])) {
        $latest_theme_version = $update_themes->response[$theme->get_stylesheet()]['new_version'];
        if (version_compare($theme_version, $latest_theme_version, '<')) {
            $status = '<span class="status-red">Update available: ' . $latest_theme_version . '</span>';
            echo '<tr><td>' . $theme_name . '</td><td>' . $theme_version . '</td><td>' . $status;
            echo ' <button class="update-button" id="theme-update-button" onclick="updateTheme()">Update</button>';
            echo '<div class="update-message" id="theme-update-message"></div>';
            echo '</td></tr>';
        } else {
            $status = '<span class="status-green">Up to date</span>';
            echo '<tr><td>' . $theme_name . '</td><td>' . $theme_version . '</td><td>' . $status . '</td></tr>';
        }
    } else {
        $status = '<span class="status-green">Up to date</span>';
        echo '<tr><td>' . $theme_name . '</td><td>' . $theme_version . '</td><td>' . $status . '</td></tr>';
    }
    echo '</table>';

    // Boxed container end
    echo '</div>';

    // AJAX Script with Loader Animation
    echo '<script>
            function setLoading(button, isLoading) {
                if (isLoading) {
                    button.classList.add("loading");
                    button.disabled = true;
                } else {
                    button.classList.remove("loading");
                    button.disabled = false;
                }
            }

            function updateCore() {
                var button = document.getElementById("core-update-button");
                var messageElement = document.getElementById("core-update-message");
                setLoading(button, true);
                fetch(ajaxurl, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "action=update_core&_wpnonce=' . wp_create_nonce("update_core") . '"
                })
                .then(response => response.json())
                .then(data => {
                    setLoading(button, false);
                    if (data.success) {
                        messageElement.textContent = "Update successful!";
                        messageElement.style.color = "green";
                        // Update the version dynamically
                        button.parentElement.innerHTML = "WordPress Version: ' . $latest_wp_version . ' <span class=\'status-green\'>(Up to date)</span>";
                    } else {
                        messageElement.textContent = "Update failed: " + data.error;
                        messageElement.style.color = "red";
                    }
                });
            }

            function updatePlugin(pluginPath) {
                console.log("plugin-update-button-" + pluginPath.replace(/\/.*$/, ""));
                var button = document.getElementById("plugin-update-button-" + pluginPath.replace(/\/.*$/, ""));
                var messageElement = document.getElementById("plugin-update-message-" + pluginPath.replace(/\/.*$/, ""));
                setLoading(button, true);
                fetch(ajaxurl, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "action=update_plugin&plugin_path=" + encodeURIComponent(pluginPath) + "&_wpnonce=' . wp_create_nonce("update_plugin") . '"
                })

                .then(data => {
                    setLoading(button, false);
                    console.log(data);
                    if (data.status == 200) {
                        messageElement.textContent = "Update successful!";
                        messageElement.style.color = "green";
                        // Update the version dynamically
                        button.parentElement.innerHTML = "<span class=\'status-green\'>Up to date</span>";
                    } else {
                        messageElement.textContent = "Update failed: " + data.error;
                        messageElement.style.color = "red";
                    }
                });
            }

            function updateTheme() {
                var button = document.getElementById("theme-update-button");
                var messageElement = document.getElementById("theme-update-message");
                setLoading(button, true);
                fetch(ajaxurl, {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "action=update_theme&_wpnonce=' . wp_create_nonce("update_theme") . '"
                })
                .then(response => response.json())
                .then(data => {
                    setLoading(button, false);
                    if (data.success) {
                        messageElement.textContent = "Update successful!";
                        messageElement.style.color = "green";
                        // Update the version dynamically
                        button.parentElement.innerHTML = "<span class=\'status-green\'>Up to date</span>";
                    } else {
                        messageElement.textContent = "Update failed: " + data.error;
                        messageElement.style.color = "red";
                    }
                });
            }
        </script>';

    echo '</div>';
}

// Hook to handle AJAX requests for updates
add_action('wp_ajax_update_core', 'wordpress_speedy_update_core');
add_action('wp_ajax_update_plugin', 'wordpress_speedy_update_plugin');
add_action('wp_ajax_update_theme', 'wordpress_speedy_update_theme');

function wordpress_speedy_update_core() {
    // Verify nonce
    check_ajax_referer('update_core');

    // Perform the core update
    if (current_user_can('update_core')) {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        wp_version_check(); // Perform the core update check
        wp_send_json_success(['message' => 'Core updated successfully.']);
    } else {
        wp_send_json_error(['error' => 'You do not have permission to update WordPress core.']);
    }
}

function wordpress_speedy_update_plugin() {
    // Verify nonce
    check_ajax_referer('update_plugin');

    $plugin_path = sanitize_text_field($_POST['plugin_path']);
    if (current_user_can('update_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $upgrader = new Plugin_Upgrader();
        $result = $upgrader->upgrade($plugin_path);

        if (!is_wp_error($result)) {
            wp_send_json_success(['message' => 'Plugin updated successfully.']);
        } else {
            wp_send_json_error(['error' => $result->get_error_message()]);
        }
    } else {
        wp_send_json_error(['error' => 'You do not have permission to update plugins.']);
    }
}

function wordpress_speedy_update_theme() {
    // Verify nonce
    check_ajax_referer('update_theme');

    if (current_user_can('update_themes')) {
        require_once ABSPATH . 'wp-admin/includes/theme.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

        $theme = wp_get_theme();
        $theme_slug = $theme->get_stylesheet();
        $upgrader = new Theme_Upgrader();
        $result = $upgrader->upgrade($theme_slug);

        if (!is_wp_error($result)) {
            wp_send_json_success(['message' => 'Theme updated successfully.']);
        } else {
            wp_send_json_error(['error' => $result->get_error_message()]);
        }
    } else {
        wp_send_json_error(['error' => 'You do not have permission to update themes.']);
    }
}
