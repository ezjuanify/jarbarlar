<?php
/*
* Template Name: Blog
*/
get_header();

do_action( 'ebbe_before_main_content' );

get_template_part('templates/content/templates/content-blog');

do_action( 'ebbe_after_main_content' );

get_footer();