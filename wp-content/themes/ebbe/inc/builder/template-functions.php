<?php
/**
 * @package ebbe
 */

if ( ! function_exists( 'ebbe_is_builder_row_display' ) ) {
	function ebbe_is_builder_row_display( $builder_id, $row_id = false, $post_id = false ) {
		$show = true;
		if ( $row_id && $builder_id ) {
			$key     = $builder_id . '_' . $row_id;
			$disable = get_post_meta( $post_id, '_ebbe_disable_' . $key, true );
			if ( $disable ) {
				$show = false;
			}
		}
		return apply_filters( 'ebbe_is_builder_row_display', $show, $builder_id, $row_id, $post_id );
	}
}

if ( ! function_exists( 'ebbe_body_classes' ) ) {
    function ebbe_body_classes( $classes ) {

        if ( is_customize_preview() ) {
            $classes[] = 'customize-previewing';
        }
        return $classes;
    }
}
add_filter( 'body_class', 'ebbe_body_classes' );