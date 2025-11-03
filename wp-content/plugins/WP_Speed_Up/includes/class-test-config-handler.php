<?php

class Test_Config_Handler {
    /**
     * Add custom settings to wp-config.php
     */
    public static function update_wp_config() {
        $config_file = ABSPATH . 'wp-config.php';
        $settings = <<<EOD

/** Test Wordpress Speedy Settings */
if (isset(\$_GET['withspeedy'])) {
    if (!defined('WP_CACHE')) {
        define('WP_CACHE', true);
    }
}
/** Test Wordpress Speedy Settings End */

EOD;

        // Check if wp-config.php file is writable and doesn't already contain the settings
        if (is_writable($config_file)) {
            $current_content = file_get_contents($config_file);
            if ($current_content === false) {
                error_log('Failed to read wp-config.php');
                return;
            }

            if (strpos($current_content, 'Test Wordpress Speedy Settings') === false) {
                $result = file_put_contents($config_file, $settings, FILE_APPEND | LOCK_EX);
                if ($result === false) {
                    error_log('Failed to write to wp-config.php');
                }
            }
        } else {
            error_log('wp-config.php is not writable');
        }
    }

    /**
     * Remove custom settings from wp-config.php
     */
    public static function remove_wp_config_code() {
        $config_file = ABSPATH . 'wp-config.php';

        if (file_exists($config_file) && is_writable($config_file)) {
            $content = file_get_contents($config_file);
            if ($content === false) {
                error_log('Failed to read wp-config.php');
                return;
            }

            $settings = <<<EOD

/** Test Wordpress Speedy Settings */
if (isset(\$_GET['withspeedy'])) {
    if (!defined('WP_CACHE')) {
        define('WP_CACHE', true);
    }
}
/** Test Wordpress Speedy Settings End */

EOD;

            // Remove the custom settings
            $updated_content = str_replace($settings, '', $content);
            if ($updated_content !== $content) {
                $result = file_put_contents($config_file, $updated_content, LOCK_EX);
                if ($result === false) {
                    error_log('Failed to update wp-config.php');
                }
            }
        } else {
            error_log('wp-config.php is not writable');
        }
    }
}
