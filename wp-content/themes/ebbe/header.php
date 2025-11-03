<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Ebbe
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=10.0, user-scalable=yes">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>
<div id="page">
	<a class="skip-link screen-reader-text" href="#ebbe-site-content"><?php esc_html_e( 'Skip to content', 'ebbe' ); ?></a>
	<?php
	do_action( 'ebbe/site-start/before' );
	
		/**
		 * Site start
		 *
		 * Hooked
		 *
		 * @see ebbe_customize_render_header - 10
		 * @see ebbe_Page_Header::render - 35
		 */
		do_action( 'ebbe/site-start' );
	
	/**
	 * Hook before main content
	 */
	do_action( 'ebbe/before-site-content' );
	?>
	<div id="ebbe-site-content" >
		<div>
			<div>
			<?php
if ( get_theme_mod( 'show_global_section', false ) ) : ?>
    <div class="global-section">
        <?php echo wp_kses_post( get_theme_mod( 'global_section_content', '' ) ); ?>
    </div>
<?php endif; ?>

				<?php do_action( 'ebbe/main/before' );
