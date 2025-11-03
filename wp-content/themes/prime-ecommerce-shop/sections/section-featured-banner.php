<?php
/**
 * Banner Section
 * 
 * @package prime_ecommerce_shop
 */
$prime_ecommerce_shop_slider = get_theme_mod( 'prime_ecommerce_shop_slider_setting',false );
$prime_ecommerce_shop_slider_extra_text = get_theme_mod( 'prime_ecommerce_shop_slider_extra_text' );
$prime_ecommerce_shop_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('prime_ecommerce_shop_blog_slide_category'),
  'posts_per_page' => 3,
); ?>

<?php if ( $prime_ecommerce_shop_slider ){?>
  <div class="banner mt-3">
    <div class="container">
      <div class="owl-carousel">
      <?php $prime_ecommerce_shop_arr_posts = new WP_Query( $prime_ecommerce_shop_args );
      if ( $prime_ecommerce_shop_arr_posts->have_posts() ) :
        while ( $prime_ecommerce_shop_arr_posts->have_posts() ) :
          $prime_ecommerce_shop_arr_posts->the_post();
          ?>
          <div class="banner_inner_box">
            <?php
              if ( has_post_thumbnail() ) :
                the_post_thumbnail();
              else:
                ?>
                <div class="banner_inner_box">
                  <img src="<?php echo get_stylesheet_directory_uri() . '/images/default-header.jpg'; ?>">
                </div>
                <?php
              endif;
            ?>
            <div class="banner_box">
              <h3 class="my-3"><?php the_title(); ?></a></h3>
              <?php if ( $prime_ecommerce_shop_slider_extra_text ){?>
                  <h6><?php echo esc_html( $prime_ecommerce_shop_slider_extra_text );?></h6>
              <?php } ?>
              <p class="btn-green mt-4">
                <a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php esc_html_e('SHOP NOW','prime-ecommerce-shop'); ?></a>
              </p>
            </div>
          </div>
        <?php
      endwhile;
      wp_reset_postdata();
      endif; ?>
    </div>
    </div>
    
  </div>
<?php } ?>