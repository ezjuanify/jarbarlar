<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package prime_ecommerce_shop
 */
$prime_ecommerce_shop_single_meta_setting  = get_theme_mod( 'prime_ecommerce_shop_single_post_meta_setting' , true );
$prime_ecommerce_shop_single_content_setting  = get_theme_mod( 'prime_ecommerce_shop_single_post_content_setting' , true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php

		if ( 'post' === get_post_type() ) : ?>
		<?php
		if ( $prime_ecommerce_shop_single_meta_setting ){ ?>
			<div class="entry-meta">
				<?php prime_ecommerce_shop_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	
    <?php
	if ( $prime_ecommerce_shop_single_content_setting ){ ?>
		<div class="entry-content" itemprop="text">
			<?php
			if( is_single()){
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'prime-ecommerce-shop' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
				}else{
				the_excerpt();
				}
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'prime-ecommerce-shop' ),
					'after'  => '</div>',
				) );
			?>
		</div>
		<!-- .entry-content -->
    <?php } ?>
</article><!-- #post-## -->