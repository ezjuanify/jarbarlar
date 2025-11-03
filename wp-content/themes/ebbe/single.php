<?php
/**
 * The template for displaying all single posts.
 *
 * @package ebbe
 */
get_header();

do_action( 'ebbe_before_main_content' );

get_template_part('templates/content/templates/content-single');

do_action( 'ebbe_after_main_content' );

get_footer();