<?php

class Cache_Optimizer {
    public static function init() {
        add_action('wp', [__CLASS__, 'start_cache']);
        add_filter('the_content', [__CLASS__, 'lazy_load_images']);
    }

    public static function start_cache() {
        ob_start([__CLASS__, 'cache_callback']);
    }

    public static function cache_callback($buffer) {
        // Minify HTML
        $buffer = self::minify_html($buffer);
        return $buffer;
    }

    private static function minify_html($buffer) {
        $search = ['/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'];
        $replace = ['>', '<', '\\1'];
        return preg_replace($search, $replace, $buffer);
    }

    public static function lazy_load_images($content) {
        if (is_singular() && !is_admin()) {
            $content = preg_replace('/<img(.*?)src=/', '<img$1loading="lazy" src=', $content);
        }
        return $content;
    }
}
