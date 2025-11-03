<?php

class HTML_Minifier {
    public static function init() {
        // Start output buffering for HTML minification
        add_action('wp', [__CLASS__, 'start_buffering']);
    }

    public static function start_buffering() {
        // Only minify HTML for visitors, not for logged-in users or in the admin area
        if (!is_user_logged_in() && !is_admin()) {
            ob_start([__CLASS__, 'minify_html']);
        }
    }

    public static function minify_html($buffer) {
        // Check if buffer is empty to avoid errors
        if (empty($buffer)) {
            return $buffer;
        }

        // Remove HTML comments (except for conditional comments for IE)
        $buffer = preg_replace('/<!--(?!\[if).*?-->/', '', $buffer);

        // Collapse whitespace, newlines, and tabs into a single space
        $buffer = preg_replace('/\s{2,}/', ' ', $buffer);

        // Remove spaces between HTML tags
        $buffer = preg_replace('/>\s+</', '><', $buffer);

        // Trim leading and trailing whitespace
        return trim($buffer);
    }
}

// Initialize the HTML Minifier
HTML_Minifier::init();
