<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package prime_ecommerce_shop
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function prime_ecommerce_shop_body_classes( $classes ) {
  global $prime_ecommerce_shop_post;
  
    if( !is_page_template( 'template-home.php' ) ){
        $classes[] = 'inner';
        // Adds a class of group-blog to blogs with more than 1 published author.
    }

    if ( is_multi_author() ) {
        $classes[] = 'group-blog ';
    }

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    

    if( prime_ecommerce_shop_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }    

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_page() ) {
        $classes[] = 'hfeed ';
    }
  
    if( is_404() ||  is_search() ){
        $classes[] = 'full-width';
    }
  
    if( ! is_active_sidebar( 'right-sidebar' ) ) {
        $classes[] = 'full-width'; 
    }

    return $classes;
}
add_filter( 'body_class', 'prime_ecommerce_shop_body_classes' );

 /**
 * 
 * @link http://www.altafweb.com/2011/12/remove-specific-tag-from-php-string.html
 */
function prime_ecommerce_shop_strip_single( $tag, $string ){
    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
    return $string;
}

if ( ! function_exists( 'prime_ecommerce_shop_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function prime_ecommerce_shop_excerpt_more($more) {
  return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'prime_ecommerce_shop_excerpt_more' );


if( ! function_exists( 'prime_ecommerce_shop_footer_credit' ) ):
/**
 * Footer Credits
*/
function prime_ecommerce_shop_footer_credit() {
    $prime_ecommerce_shop_copyright_text = get_theme_mod('prime_ecommerce_shop_footer_copyright_text');

    $prime_ecommerce_shop_text = '<div class="site-info"><div class="container"><span class="copyright">';
    if ($prime_ecommerce_shop_copyright_text) {
        $prime_ecommerce_shop_text .= wp_kses_post($prime_ecommerce_shop_copyright_text); 
    } else {
        $prime_ecommerce_shop_text .= esc_html__('&copy; ', 'prime-ecommerce-shop') . date_i18n(esc_html__('Y', 'prime-ecommerce-shop')); 
        $prime_ecommerce_shop_text .= ' <a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>' . esc_html__('. All Rights Reserved.', 'prime-ecommerce-shop');
    }
    $prime_ecommerce_shop_text .= '</span>';
    $prime_ecommerce_shop_text .= '<span class="by"> <a href="' . esc_url('https://www.themeignite.com/products/free-ecommerce-wordpress-theme') . '" rel="nofollow" target="_blank">' . PRIME_ECOMMERCE_SHOP_THEME_NAME . '</a>' . esc_html__(' By ', 'prime-ecommerce-shop') . '<a href="' . esc_url('https://themeignite.com/') . '" rel="nofollow" target="_blank">' . esc_html__('Themeignite', 'prime-ecommerce-shop') . '</a>.';
    $prime_ecommerce_shop_text .= sprintf(esc_html__(' Powered By %s', 'prime-ecommerce-shop'), '<a href="' . esc_url(__('https://wordpress.org/', 'prime-ecommerce-shop')) . '" target="_blank">WordPress</a>.');
    if (function_exists('the_privacy_policy_link')) {
        $prime_ecommerce_shop_text .= get_the_privacy_policy_link();
    }
    $prime_ecommerce_shop_text .= '</span></div></div>';
    echo apply_filters('prime_ecommerce_shop_footer_text', $prime_ecommerce_shop_text);
}
add_action('prime_ecommerce_shop_footer', 'prime_ecommerce_shop_footer_credit');
endif;

/**
 * Is Woocommerce activated
*/
if ( ! function_exists( 'prime_ecommerce_shop_woocommerce_activated' ) ) {
  function prime_ecommerce_shop_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
  }
}

if( ! function_exists( 'prime_ecommerce_shop_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function prime_ecommerce_shop_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $prime_ecommerce_shop_commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $prime_ecommerce_shop_aria_req = ( $req ? " aria-required='true'" : '' );
    $prime_ecommerce_shop_required = ( $req ? " required" : '' );
    $prime_ecommerce_shop_author   = ( $req ? __( 'Name*', 'prime-ecommerce-shop' ) : __( 'Name', 'prime-ecommerce-shop' ) );
    $prime_ecommerce_shop_email    = ( $req ? __( 'Email*', 'prime-ecommerce-shop' ) : __( 'Email', 'prime-ecommerce-shop' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'prime-ecommerce-shop' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $prime_ecommerce_shop_author ) . '" type="text" value="' . esc_attr( $prime_ecommerce_shop_commenter['comment_author'] ) . '" size="30"' . $prime_ecommerce_shop_aria_req . $prime_ecommerce_shop_required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'prime-ecommerce-shop' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $prime_ecommerce_shop_email ) . '" type="text" value="' . esc_attr(  $prime_ecommerce_shop_commenter['comment_author_email'] ) . '" size="30"' . $prime_ecommerce_shop_aria_req . $prime_ecommerce_shop_required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'prime-ecommerce-shop' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'prime-ecommerce-shop' ) . '" type="text" value="' . esc_attr( $prime_ecommerce_shop_commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'prime_ecommerce_shop_change_comment_form_default_fields' );

if( ! function_exists( 'prime_ecommerce_shop_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function prime_ecommerce_shop_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'prime-ecommerce-shop' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'prime-ecommerce-shop' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'prime_ecommerce_shop_change_comment_form_defaults' );

if( ! function_exists( 'prime_ecommerce_shop_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 * @return string
 */
function prime_ecommerce_shop_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
    /**
     * Triggered after the opening <body> tag.
    */
    do_action( 'wp_body_open' );
}
endif;

if ( ! function_exists( 'prime_ecommerce_shop_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function prime_ecommerce_shop_get_fallback_svg( $prime_ecommerce_shop_post_thumbnail ) {
    if( ! $prime_ecommerce_shop_post_thumbnail ){
        return;
    }
    
    $prime_ecommerce_shop_image_size = prime_ecommerce_shop_get_image_sizes( $prime_ecommerce_shop_post_thumbnail );
     
    if( $prime_ecommerce_shop_image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $prime_ecommerce_shop_image_size['width'] ); ?> <?php echo esc_attr( $prime_ecommerce_shop_image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $prime_ecommerce_shop_image_size['width'] ); ?>" height="<?php echo esc_attr( $prime_ecommerce_shop_image_size['height'] ); ?>" style="fill:#dedddd;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

function prime_ecommerce_shop_enqueue_google_fonts() {

    require get_template_directory() . '/inc/wptt-webfont-loader.php';

    wp_enqueue_style(
            'google-fonts-archivo',
        wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap' ),
        array(),
        '1.0'
    );

    wp_enqueue_style(
        'google-fonts-inter',
        wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap' ),
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'prime_ecommerce_shop_enqueue_google_fonts' );


if( ! function_exists( 'prime_ecommerce_shop_site_branding' ) ) :
/**
 * Site Branding
*/
function prime_ecommerce_shop_site_branding(){
    $prime_ecommerce_shop_logo_site_title = get_theme_mod( 'header_site_title', 1 );
    $prime_ecommerce_shop_tagline = get_theme_mod( 'header_tagline', false );
    $prime_ecommerce_shop_logo_width = get_theme_mod('logo_width', 100); // Retrieve the logo width setting

    ?>
    <div class="site-branding" style="max-width: <?php echo esc_attr(get_theme_mod('logo_width', '-1'))?>px;">
        <?php 
        // Check if custom logo is set and display it
        if (function_exists('has_custom_logo') && has_custom_logo()) {
            the_custom_logo();
        }
        if ($prime_ecommerce_shop_logo_site_title):
             if (is_front_page()): ?>
            <h1 class="site-title" style="font-size: <?php echo esc_attr(get_theme_mod('prime_ecommerce_shop_site_title_size', '30')); ?>px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
          </h1>
            <?php else: ?>
                <p class="site-title" itemprop="name">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </p>
            <?php endif; ?>
        <?php endif; 
    
        if ($prime_ecommerce_shop_tagline) :
            $prime_ecommerce_shop_description = get_bloginfo('description', 'display');
            if ($prime_ecommerce_shop_description || is_customize_preview()) :
        ?>
                <p class="site-description" itemprop="description"><?php echo $prime_ecommerce_shop_description; ?></p>
            <?php endif;
        endif;
        ?>
    </div>
    <?php
}
endif;
if( ! function_exists( 'prime_ecommerce_shop_navigation' ) ) :
/**
 * Site Navigation
*/
function prime_ecommerce_shop_navigation(){
    ?>
    <nav class="main-navigation" id="site-navigation"  role="navigation">
        <?php 
        wp_nav_menu( array( 
            'theme_location' => 'primary', 
            'menu_id' => 'primary-menu' 
        ) ); 
        ?>
    </nav>
    <?php
}
endif;


if( ! function_exists( 'prime_ecommerce_shop_top_header' ) ) :
/**
 * Header Start
*/
function prime_ecommerce_shop_top_header(){
    $prime_ecommerce_shop_header_setting     = get_theme_mod( 'prime_ecommerce_shop_header_setting', false );
    $prime_ecommerce_shop_topbar_text        = get_theme_mod( 'prime_ecommerce_shop_topbar_text_1' );
    $prime_ecommerce_shop_social_icon  = get_theme_mod( 'prime_ecommerce_shop_social_icon_setting', false);

    ?>
    <?php if ( $prime_ecommerce_shop_header_setting ){?>
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 text-lg-start text-md-start align-self-center">
                        <?php if ( $prime_ecommerce_shop_topbar_text ){?>
                            <span><?php echo esc_html( $prime_ecommerce_shop_topbar_text);?></span>
                        <?php } ?>      
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 text-lg-end text-md-end align-self-center">
                        <?php if ( $prime_ecommerce_shop_social_icon ){?>
                            <span class="social-links">
                              <?php 
                                $prime_ecommerce_shop_social_link1 = get_theme_mod( 'prime_ecommerce_shop_social_link_1' );
                                $prime_ecommerce_shop_social_link2 = get_theme_mod( 'prime_ecommerce_shop_social_link_2' );
                                $prime_ecommerce_shop_social_link3 = get_theme_mod( 'prime_ecommerce_shop_social_link_3' );
                                $prime_ecommerce_shop_social_link4 = get_theme_mod( 'prime_ecommerce_shop_social_link_4' );

                                if ( ! empty( $prime_ecommerce_shop_social_link1 ) ) {
                                  echo '<a class="social1" href="' . esc_url( $prime_ecommerce_shop_social_link1 ) . '" target="_blank"><i class="fab fa-facebook-f"></i></a>';
                                }
                                if ( ! empty( $prime_ecommerce_shop_social_link2 ) ) {
                                  echo '<a class="social2" href="' . esc_url( $prime_ecommerce_shop_social_link2 ) . '" target="_blank"><i class="fab fa-twitter"></i></a>';
                                } 
                                if ( ! empty( $prime_ecommerce_shop_social_link3 ) ) {
                                  echo '<a class="social3" href="' . esc_url( $prime_ecommerce_shop_social_link3 ) . '" target="_blank"><i class="fab fa-instagram"></i></a>';
                                }
                                if ( ! empty( $prime_ecommerce_shop_social_link4 ) ) {
                                  echo '<a class="social4" href="' . esc_url( $prime_ecommerce_shop_social_link4 ) . '" target="_blank"><i class="fab fa-pinterest-p"></i></a>';
                                }
                              ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>              
            </div>
        </div>
    <?php } ?>
    <?php
}
endif;
add_action( 'prime_ecommerce_shop_top_header', 'prime_ecommerce_shop_top_header', 20 );


if( ! function_exists( 'prime_ecommerce_shop_header' ) ) :
/**
 * Header Start
*/
function prime_ecommerce_shop_header(){
    $prime_ecommerce_shop_header_image = get_header_image();
    $prime_ecommerce_shop_sticky_header = get_theme_mod('prime_ecommerce_shop_sticky_header');
    $prime_ecommerce_shop_header_btn_1     = get_theme_mod( 'prime_ecommerce_shop_header_btn_1' );
    $prime_ecommerce_shop_header_btn_1_url     = get_theme_mod( 'prime_ecommerce_shop_header_btn_1_url' );
    $prime_ecommerce_shop_header_btn_2     = get_theme_mod( 'prime_ecommerce_shop_header_btn_2' );
    $prime_ecommerce_shop_header_btn_2_url     = get_theme_mod( 'prime_ecommerce_shop_header_btn_2_url' );
    $prime_ecommerce_shop_contact_number        = get_theme_mod( 'prime_ecommerce_shop_contact_number' );
    ?>
<div id="page-site-header">
    <header id="masthead" style="background-image: url('<?php echo esc_url( $prime_ecommerce_shop_header_image ); ?>');" data-sticky="<?php echo $prime_ecommerce_shop_sticky_header; ?>" class="site-header header-inner" role="banner">
        <div class="topbar-header-2 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 align-self-center acc-order text-md-start">
                        <?php if ($prime_ecommerce_shop_header_btn_1) { ?>
                            <span>
                                <a href="<?php echo esc_url($prime_ecommerce_shop_header_btn_1_url); ?>">
                                    <?php echo esc_html($prime_ecommerce_shop_header_btn_1); ?>
                                </a>
                            </span>
                        <?php } ?>
                        <?php if ($prime_ecommerce_shop_header_btn_2) { ?>
                            <span class="acc">
                                <a href="<?php echo esc_url($prime_ecommerce_shop_header_btn_2_url); ?>">
                                    <?php echo esc_html($prime_ecommerce_shop_header_btn_2); ?>
                                </a>
                            </span>
                        <?php } ?>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 align-self-center text-center contact">
                        <?php if ($prime_ecommerce_shop_contact_number) { ?>
                            <span>
                                <?php esc_html_e('Need Help? Call Us:', 'prime-ecommerce-shop'); ?>
                                <a href="tel:<?php echo esc_attr($prime_ecommerce_shop_contact_number); ?>">
                                    <?php echo esc_html($prime_ecommerce_shop_contact_number); ?>
                                </a>
                            </span>
                        <?php } ?> 
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 align-self-center text-md-end g-box">
                        <span class="text-center translate-btn">
                            <?php if (class_exists('GTranslate')) { ?>
                                <?php echo do_shortcode('[gtranslate]', 'prime-ecommerce-shop'); ?>
                            <?php } ?>
                        </span>
                        <?php if (class_exists('WOOCS')) { ?>
                            <span class="currency">
                                <?php echo do_shortcode('[woocs]'); ?>
                            </span>
                        <?php } ?>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="topbar-header-3 py-3">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 align-self-center">
                        <?php prime_ecommerce_shop_site_branding(); ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-5 align-self-center product-search">
                        <?php if (class_exists('woocommerce')) { ?>
                            <?php get_product_search_form(); ?>
                        <?php } ?> 
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 align-self-center text-lg-end account-detail">
                        <?php if (class_exists('woocommerce')) { ?>
                            <span class="user-btn">
                                <?php if (is_user_logged_in()) { ?>
                                    <a class="account-btn" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php esc_attr_e('My Account','prime-ecommerce-shop'); ?>">
                                        <i class="far fa-user"></i>
                                    </a>
                                <?php } else { ?>
                                    <a class="account-btn" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="<?php esc_attr_e('My Account','prime-ecommerce-shop'); ?>"></a>
                                <?php } ?>
                            </span>
                        <?php } ?>
                        <?php if (get_theme_mod('prime_ecommerce_shop_wishlist_url') != "") { ?>
                            <span class="wish-btn">
                                <a href="<?php echo esc_url(get_theme_mod('prime_ecommerce_shop_wishlist_url')); ?>">
                                    <i class="far fa-heart"></i>
                                </a>
                            </span>
                        <?php } ?>
                        <?php if (class_exists('woocommerce')) { ?>
                            <span class="cart-count">
                                <a class="cart-customlocation" href="<?php if (function_exists('wc_get_cart_url')) { echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e('View Shopping Cart', 'prime-ecommerce-shop'); ?>">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="cart-item-box"><?php echo esc_html(wp_kses_data(WC()->cart->get_cart_contents_count())); ?></span>
                                </a>
                                <?php esc_html_e('My Cart', 'prime-ecommerce-shop'); ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div>  
        </div>
        <div class="topbar-header-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 align-self-center">
                        <?php if (class_exists('woocommerce')) { ?>
                            <button class="category-btn">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                                <?php echo esc_html(get_theme_mod('prime_ecommerce_shop_category_text', 'Select Categories', 'prime-ecommerce-shop')); ?>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="category-dropdown">
                                <?php
                                $args = array(
                                    'number'     => get_theme_mod('prime_ecommerce_shop_product_category_number'),
                                    'orderby'    => 'title',
                                    'order'      => 'ASC',
                                    'hide_empty' => 0,
                                    'parent'     => 0
                                );
                                $product_categories = get_terms('product_cat', $args);
                                $count = count($product_categories);
                                if ($count > 0) {
                                    foreach ($product_categories as $product_category) {
                                        $prime_ecommerce_shop_cat_id = $product_category->term_id;
                                        $cat_link = get_category_link($prime_ecommerce_shop_cat_id);
                                        if ($product_category->category_parent == 0) { ?>
                                            <li class="drp_dwn_menu">
                                                <a href="<?php echo esc_url(get_term_link($product_category)); ?>">
                                                    <?php echo esc_html($product_category->name); ?>
                                                </a>
                                            </li>
                                        <?php }
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>  
                    </div>
                    <div class="col-lg-9 align-self-center">
                        <?php prime_ecommerce_shop_navigation(); ?>
                    </div>
                </div> 
            </div>
        </div>
    </header>
</div>
    <?php
}
endif;
add_action( 'prime_ecommerce_shop_header', 'prime_ecommerce_shop_header', 20 );