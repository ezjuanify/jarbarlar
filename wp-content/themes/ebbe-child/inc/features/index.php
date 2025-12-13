<?php

$disabled_features = [
    'whatsapp-button',
    'product-sliders',
    'search-live',
    'price-difference',
    'product-attributes-cleanup',
    'myaccount-cleanup'
];

foreach (glob(__DIR__ . '/*/index.php') as $file) {
    $features = basename(dirname($file));
    if (in_array($features, $disabled_features, true)) continue;

    require_once $file;
}

?>