<?php

class Database_Optimizer {
    public static function init() {
        // Schedule a daily event if it's not already scheduled
        if (!wp_next_scheduled('database_cleanup_event')) {
            wp_schedule_event(time(), 'daily', 'database_cleanup_event');
        }

        // Hook the cleanup function to the scheduled event
        add_action('database_cleanup_event', [__CLASS__, 'optimize_database']);
    }

    public static function optimize_database() {
        global $wpdb;

        // Delete old post revisions
        $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type = 'revision'");

        // Delete trashed posts and pages
        $wpdb->query("DELETE FROM $wpdb->posts WHERE post_status = 'trash'");

        // Delete spam comments
        $wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'");

        // Delete trashed comments
        $wpdb->query("DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'");

        // Delete expired transients
        $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%' AND option_value < NOW()");

        // Optimize database tables
        $tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);
        foreach ($tables as $table) {
            $wpdb->query("OPTIMIZE TABLE " . $table[0]);
        }

        // Log optimization success
        error_log('Database optimization completed successfully.');
    }

    // Clear scheduled event on plugin deactivation
    public static function deactivate() {
        $timestamp = wp_next_scheduled('database_cleanup_event');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'database_cleanup_event');
        }
    }
}

// Initialize the Database Optimizer
Database_Optimizer::init();
