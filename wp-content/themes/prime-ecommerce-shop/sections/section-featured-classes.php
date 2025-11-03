<?php 
/**
 * Template part for displaying Featured Classes Section
 *
 * @package Prime Ecommerce Shop
 */

$prime_ecommerce_shop_args = array(
  'post_type' => 'post',
  'post_status' => 'publish',
  'category_name' =>  get_theme_mod('prime_ecommerce_shop_student_category'),
); 
$prime_ecommerce_shop_classes = get_theme_mod( 'prime_ecommerce_shop_classes_setting',false );
$prime_ecommerce_shop_hot_products_cat = get_theme_mod('prime_ecommerce_shop_hot_products_cat');
$prime_ecommerce_shop_timer_text = get_theme_mod( 'prime_ecommerce_shop_timer_text' );
?>
<?php if ( $prime_ecommerce_shop_classes ){?>
<div class="our-classes">
    <div class="container">
        <?php if(class_exists('woocommerce')){ ?>
        <div class="owl-carousel">
            <?php
            $args = array(
              'post_type' => 'product',
              'posts_per_page' => 50,
              'product_cat' => get_theme_mod('prime_ecommerce_shop_hot_products_cat'),
              'order' => 'ASC'
            );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product;
              $prime_ecommerce_shop_regular_price = $product->get_regular_price();
              $prime_ecommerce_shop_sale_price = $product->get_sale_price();
              ?>
                  <div class="product-image">
                    <?php
                      if (has_post_thumbnail($loop->post->ID)) {
                          echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                      } else {
                          echo '<img src="' . esc_url(wc_placeholder_img_src()) . '" alt="" />';
                      }
                    ?>

                    <div class="box-content-main">
                      <div class="timer-boxx">
                         <?php if ( $prime_ecommerce_shop_timer_text ){?>
                          <h6><?php echo esc_html( $prime_ecommerce_shop_timer_text );?></h6>
                      <?php } ?>
                      <div class="countdowntimer text-center mt-2">
                        <p id="timer" class="countdown">
                          <?php 
                          $prime_ecommerce_shop_dateday = get_theme_mod('prime_ecommerce_shop_clock_timer_end','December 12, 2025 11:00:00'); ?>
                          <input type="hidden" class="date" value="<?php echo esc_html($prime_ecommerce_shop_dateday); ?>"></p>
                      </div>
                      </div>
                      <div class="box-content">
                      <div class="part-1">
                          <?php 
                            $selected_category_slug = get_theme_mod('prime_ecommerce_shop_hot_products_cat');
                            $product_categories = wp_get_post_terms($product->get_id(), 'product_cat');
                            if (!empty($product_categories)) {
                                foreach ($product_categories as $category) {
                                    if ($category->slug === $selected_category_slug) {
                                        echo '<p class="product-category">' . esc_html($category->name) . '</p>';
                                        break;
                                    }
                                }
                            }
                          ?>
                          <h3 class="product-text">
                            <a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>">
                              <?php the_title(); ?>
                            </a>
                          </h3>
                          <div class="product-rating mb-lg-3">
                            <?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_rating( $loop->post, $product ); } ?>
                          </div>
                          <div class="price mb-2">
                            <?php echo $product->get_price_html(); ?>
                          </div>
                      </div>
                      <div class="part-2">
                        <div class="pro-icons">
                          <?php if( $product->is_type( 'simple' ) ){ 
                            woocommerce_template_loop_add_to_cart( $loop->post, $product ); 
                          } ?>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
            <?php endwhile; 
            wp_reset_postdata(); ?>
        </div>
        <?php }?>
    </div>
</div>
<?php } ?>