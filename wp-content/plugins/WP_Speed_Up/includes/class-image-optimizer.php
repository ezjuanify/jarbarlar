<?php

class Image_Optimizer {
    public static function init() {
        add_filter('wp_handle_upload', [__CLASS__, 'optimize_image']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_lazy_load_script']);
    }

    // Image Optimization
    public static function optimize_image($image) {
        $imagick = new Imagick($image['file']);
        $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
        $imagick->setImageCompressionQuality(85);
        $imagick->stripImage();

        // Convert to WebP
        $webp_file = $image['file'] . '.webp';
        $imagick->setImageFormat('webp');
        $imagick->writeImage($webp_file);

        $imagick->writeImage($image['file']);
        return $image;
    }

    // Lazy Load Script
    public static function enqueue_lazy_load_script() {
        wp_enqueue_script(
            'lazy-load',
            'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.0/lazysizes.min.js',
            [],
            '5.3.0',
            true
        );
    }
}
