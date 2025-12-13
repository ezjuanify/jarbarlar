<?php

$fn = basename(__DIR__);

add_action("wp_enqueue_scripts", function () use ($fn) {
    load_features_assets($fn);
});

?>