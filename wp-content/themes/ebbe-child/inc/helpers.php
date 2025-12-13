<?php
/**
 * Helpers: Print PHP Variables (Debug Only)
 */

function get_features_base_path() {
    return '/inc/features/';
}

function get_script_file() {
    return 'script.js';
}

function get_style_file() {
    return 'style.css';
}

function get_features_dir($fn, $name) {
    return get_stylesheet_directory() . get_features_base_path() . $fn . '/' . $name;
}

function get_features_uri($fn, $name) {
    return get_stylesheet_directory_uri() . get_features_base_path() . $fn .  '/' . $name;
}

function load_features_assets($fn, $deps = ['jquery']) {
    load_feature_asset_group($fn, '', $deps);
}

function load_features_admin_assets($fn, $deps = ['jquery']) {
    load_feature_asset_group($fn, 'admin/', $deps);
}

function load_feature_asset_group($fn, $prefix = '', $deps = ['jquery']) {
    $script_file = $prefix . get_script_file();
    $style_file  = $prefix . get_style_file();

    $script_path = get_features_dir($fn, $script_file);
    $style_path  = get_features_dir($fn, $style_file);

    if (file_exists($script_path)) {
        wp_enqueue_script(
            $fn . ($prefix ? '-admin' : ''),
            get_features_uri($fn, $script_file),
            $deps,
            filemtime($script_path),
            true
        );
    }

    if (file_exists($style_path)) {
        wp_enqueue_style(
            $fn . ($prefix ? '-admin-style' : '-style'),
            get_features_uri($fn, $style_file),
            [],
            filemtime($style_path)
        );
    }
}

function console_log($data) {
    echo '<script>';
    echo 'console.log("' . $data . '");';
    echo '</script>';
}


?>