<?php

class Full_Page_Cache {
    private static $cache_dir;

    public static function init() {
        self::$cache_dir = plugin_dir_path(__FILE__) . 'cache';

        // Check and create cache directory
        if (!file_exists(self::$cache_dir)) {
            if (!mkdir(self::$cache_dir, 0755, true)) {
                error_log('Failed to create cache directory: ' . self::$cache_dir);
                return;
            } else {
                error_log('Cache directory created: ' . self::$cache_dir);
            }
        } else {
            error_log('Cache directory already exists: ' . self::$cache_dir);
        }

        // Add hooks for caching and clearing cache
        add_action('wp', [__CLASS__, 'start_caching']);
        add_action('save_post', [__CLASS__, 'clear_cache']);
    }

    public static function start_caching() {
        if (!is_user_logged_in() && !is_admin()) {
            error_log('Starting output buffering for caching.');
            ob_start([__CLASS__, 'cache_page']);
        }
    }

    public static function cache_page($buffer) {
        $cache_file = self::get_cache_file();
        if (file_put_contents($cache_file, $buffer) === false) {
            error_log('Failed to write cache file: ' . $cache_file);
        } else {
            error_log('Cache file created: ' . $cache_file);
        }
        return $buffer;
    }

    private static function get_cache_file() {
        $url = $_SERVER['REQUEST_URI'];
        $hash = md5($url);
        return self::$cache_dir . '/' . $hash . '.html';
    }

    public static function clear_cache() {
        $files = glob(self::$cache_dir . '/*.html');
        if ($files) {
            foreach ($files as $file) {
                if (unlink($file)) {
                    error_log('Deleted cache file: ' . $file);
                } else {
                    error_log('Failed to delete cache file: ' . $file);
                }
            }
        } else {
            error_log('No cache files found to delete.');
        }
    }
}

Full_Page_Cache::init();
