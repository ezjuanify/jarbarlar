<?php

class Resource_Preload {
    public static function init() {
        add_action('wp_head', [__CLASS__, 'add_preload_links']);
    }

    public static function add_preload_links() {
        // Preload Google Fonts if detected
        global $wp_styles;
        if (isset($wp_styles) && is_object($wp_styles)) {
            foreach ($wp_styles->queue as $style_handle) {
                $style_url = $wp_styles->registered[$style_handle]->src;
                if (strpos($style_url, 'fonts.googleapis.com') !== false) {
                    echo '<link rel="preload" href="' . esc_url($style_url) . '" as="style">' . "\n";
                }
            }
        }

        // Preload the featured image on the homepage
        if (is_front_page() || is_home()) {
            $featured_image_id = get_post_thumbnail_id(get_queried_object_id());
            if ($featured_image_id) {
                $featured_image_url = wp_get_attachment_url($featured_image_id);
                echo '<link rel="preload" href="' . esc_url($featured_image_url) . '" as="image">' . "\n";
            }
        }

        // Preload main CSS file from the active theme
        $main_css_url = get_stylesheet_uri();
        echo '<link rel="preload" href="' . esc_url($main_css_url) . '" as="style">' . "\n";

        // Preload main JavaScript file (typically jQuery)
        if (wp_script_is('jquery', 'registered')) {
            $jquery_url = wp_scripts()->registered['jquery']->src;
            echo '<link rel="preload" href="' . esc_url($jquery_url) . '" as="script">' . "\n";
        }
    }
}

Resource_Preload::init();
