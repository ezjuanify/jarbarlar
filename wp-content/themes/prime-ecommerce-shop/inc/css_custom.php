<?php

$prime_ecommerce_shop_custom_css = "";

/*-------------------- Container Width-------------------*/

$prime_ecommerce_shop_theme_width = get_theme_mod( 'prime_ecommerce_shop_theme_width','full-width');

if($prime_ecommerce_shop_theme_width == 'full-width'){
$prime_ecommerce_shop_custom_css .='body{';
	$prime_ecommerce_shop_custom_css .='max-width: 100% !important;';
$prime_ecommerce_shop_custom_css .='}';
$prime_ecommerce_shop_custom_css .='.sticky-head{';
	$prime_ecommerce_shop_custom_css .='left: 0;';
$prime_ecommerce_shop_custom_css .='}';
}else if($prime_ecommerce_shop_theme_width == 'container'){
$prime_ecommerce_shop_custom_css .='body{';
	$prime_ecommerce_shop_custom_css .='width: 80% !important; padding-right: 15px; padding-left: 15px;  margin-right: auto !important; margin-left: auto !important;';
$prime_ecommerce_shop_custom_css .='}';
$prime_ecommerce_shop_custom_css .='.sticky-head{';
	$prime_ecommerce_shop_custom_css .='left: 0;';
$prime_ecommerce_shop_custom_css .='}';
}else if($prime_ecommerce_shop_theme_width == 'container-fluid'){
$prime_ecommerce_shop_custom_css .='body{';
	$prime_ecommerce_shop_custom_css .='width: 95% !important;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
$prime_ecommerce_shop_custom_css .='}';
$prime_ecommerce_shop_custom_css .='.sticky-head{';
	$prime_ecommerce_shop_custom_css .='left: 0;';
$prime_ecommerce_shop_custom_css .='}';
}

/*-------------------- Single Post Alignment-------------------*/

$prime_ecommerce_shop_single_post_align = get_theme_mod( 'prime_ecommerce_shop_single_post_align','left-align');

if($prime_ecommerce_shop_single_post_align == 'left-align'){
$prime_ecommerce_shop_custom_css .='body:not(.hide-post-meta) .post{';
	$prime_ecommerce_shop_custom_css .='text-align: left';
$prime_ecommerce_shop_custom_css .='}';
}else if($prime_ecommerce_shop_single_post_align == 'right-align'){
$prime_ecommerce_shop_custom_css .='body:not(.hide-post-meta) .post{';
	$prime_ecommerce_shop_custom_css .='text-align: right';
$prime_ecommerce_shop_custom_css .='}';
}else if($prime_ecommerce_shop_single_post_align == 'center-align'){
$prime_ecommerce_shop_custom_css .='body:not(.hide-post-meta) .post{';
	$prime_ecommerce_shop_custom_css .='text-align: center';
$prime_ecommerce_shop_custom_css .='}';
}