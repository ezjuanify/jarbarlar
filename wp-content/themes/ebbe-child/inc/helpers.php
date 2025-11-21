<?php
/**
 * Helpers: Print PHP Variables (Debug Only)
 */
function console_log($data) {
    echo '<script>';
    echo 'console.log("' . $data . '");';
    echo '</script>';
}
?>