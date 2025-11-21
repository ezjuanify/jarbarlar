<?php

if (!defined('ABSPATH')) exit;

// Load enqueue logic (CSS + JS)
require_once get_theme_file_path('/inc/enqueue.php');

// Load shortcodes
require_once get_theme_file_path('/inc/shortcodes/index.php');

// Load Features
require_once get_theme_file_path('/inc/features/index.php');

// Load Helpers
require_once get_theme_file_path('/inc/helpers.php');