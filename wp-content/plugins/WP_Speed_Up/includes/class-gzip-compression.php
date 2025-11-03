<?php

class GZIP_Optimizer {
    public static function init() {
        // Hook into WordPress init to enable GZIP compression
        add_action('init', [__CLASS__, 'enable_gzip_compression']);
    }

    public static function enable_gzip_compression() {
        // Check if zlib extension is loaded, output compression is not already enabled, and headers are not already sent
        if (extension_loaded('zlib') && !ini_get('zlib.output_compression') && !headers_sent()) {
            // Enable GZIP compression using output buffering
            ob_start('ob_gzhandler');

            // Set the appropriate headers for GZIP
            header('Content-Encoding: gzip');
            header('Vary: Accept-Encoding');
        }
    }
}

// Initialize the GZIP Optimizer
GZIP_Optimizer::init();
