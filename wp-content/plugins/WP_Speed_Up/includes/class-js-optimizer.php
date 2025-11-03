<?php

class JS_Optimizer {
    public static function init() {
        add_filter('script_loader_tag', [__CLASS__, 'defer_js'], 10, 2);
    }

    public static function defer_js($tag, $handle) {
        if (is_admin()) return $tag; // Skip for admin area
        if (strpos($tag, 'async') === false && strpos($tag, 'defer') === false) {
            return str_replace('src', 'defer="defer" src', $tag);
        }
        return $tag;
    }
}
