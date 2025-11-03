<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package prime_ecommerce_shop
 */
$prime_ecommerce_shop_heading_setting  = get_theme_mod( 'prime_ecommerce_shop_post_heading_setting' , true );
$prime_ecommerce_shop_meta_setting  = get_theme_mod( 'prime_ecommerce_shop_post_meta_setting' , true );
$prime_ecommerce_shop_content_setting  = get_theme_mod( 'prime_ecommerce_shop_post_content_setting' , true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		  if ( $prime_ecommerce_shop_heading_setting ){ 
			if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		  }

		if ( 'post' === get_post_type() ) : ?>
		<?php
		if ( $prime_ecommerce_shop_meta_setting ){ ?>
			<div class="entry-meta">
				<?php prime_ecommerce_shop_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	 <?php
			// Get the post ID
			$prime_ecommerce_shop_post_id = get_the_ID();

			// Check if there are audio embedded in the post content
			$prime_ecommerce_shop_post = get_post($prime_ecommerce_shop_post_id);
			$prime_ecommerce_shop_content = do_shortcode(apply_filters('the_content', $prime_ecommerce_shop_post->post_content));
			$prime_ecommerce_shop_embeds = get_media_embedded_in_content($prime_ecommerce_shop_content);

			if (!empty($prime_ecommerce_shop_embeds)) {
			    // Loop through embedded media and display only audio
			    foreach ($prime_ecommerce_shop_embeds as $embed) {
			        // Check if the embed code contains an audio tag or specific audio providers like SoundCloud
			        if (strpos($embed, 'audio') !== false || strpos($embed, 'soundcloud') !== false) {
			            ?>
			            <div class="custom-embedded-audio">
			                <div class="media-container">
			                    <?php echo $embed; ?>
			                </div>
			                <div class="media-comments">
			                    <?php
			                    // Add your comments section here
			                    comments_template(); // This will include the default WordPress comments template
			                    ?>
			                </div>
			            </div>
			            <?php
			        }
			    }
			}
		?>
    <?php
	if ( $prime_ecommerce_shop_content_setting ){ ?>
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
		</div><!-- .entry-content -->
    <?php } ?>
</article><!-- #post-## -->