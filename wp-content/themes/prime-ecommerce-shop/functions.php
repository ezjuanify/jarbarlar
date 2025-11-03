<?php
/**
 * Prime Ecommerce Shop functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package prime_ecommerce_shop
 */

if ( ! defined( 'PRIME_ECOMMERCE_SHOP_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_URL', esc_url( 'https://www.themeignite.com/products/ecommerce-shop-wordpress-theme', 'prime-ecommerce-shop') );
}
if ( ! defined( 'PRIME_ECOMMERCE_SHOP_FREE_DOC_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_FREE_DOC_URL', esc_url( 'https://demo.themeignite.com/documentation/prime-ecommerce-shop-free', 'prime-ecommerce-shop') );
}
if ( ! defined( 'PRIME_ECOMMERCE_SHOP_PRO_DOC_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_PRO_DOC_URL', esc_url( 'https://demo.themeignite.com/documentation/prime-ecommerce-shop-pro/', 'prime-ecommerce-shop') );
}
if ( ! defined( 'PRIME_ECOMMERCE_SHOP_DEMO_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_DEMO_URL', esc_url( 'https://demo.themeignite.com/prime-ecommerce-shop/', 'prime-ecommerce-shop') );
}
if ( ! defined( 'PRIME_ECOMMERCE_SHOP_REVIEW_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_REVIEW_URL', esc_url( 'https://wordpress.org/support/theme/prime-ecommerce-shop/reviews/#new-post', 'prime-ecommerce-shop') );
}
if ( ! defined( 'PRIME_ECOMMERCE_SHOP_SUPPORT_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_SUPPORT_URL', esc_url( 'https://wordpress.org/support/theme/prime-ecommerce-shop/', 'prime-ecommerce-shop') );
}
if ( ! defined( 'PRIME_ECOMMERCE_SHOP_BUNDLE_URL' ) ) {
    define( 'PRIME_ECOMMERCE_SHOP_BUNDLE_URL', esc_url( 'https://www.themeignite.com/products/wp-theme-bundle', 'prime-ecommerce-shop') );
}

$prime_ecommerce_shop_theme_data = wp_get_theme();
if( ! defined( 'PRIME_ECOMMERCE_SHOP_THEME_VERSION' ) ) define ( 'PRIME_ECOMMERCE_SHOP_THEME_VERSION', $prime_ecommerce_shop_theme_data->get( 'Version' ) );
if( ! defined( 'PRIME_ECOMMERCE_SHOP_THEME_NAME' ) ) define( 'PRIME_ECOMMERCE_SHOP_THEME_NAME', $prime_ecommerce_shop_theme_data->get( 'Name' ) );

if ( ! function_exists( 'prime_ecommerce_shop_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function prime_ecommerce_shop_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'prime-ecommerce-shop' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
        'status',
        'audio', 
        'chat'
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'prime_ecommerce_shop_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


	/* Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

    load_theme_textdomain( 'prime-ecommerce-shop', get_template_directory() . '/languages' );
}
endif;
add_action( 'after_setup_theme', 'prime_ecommerce_shop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $prime_ecommerce_shop_content_width
 */
function prime_ecommerce_shop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'prime_ecommerce_shop_content_width', 780 );
}
add_action( 'after_setup_theme', 'prime_ecommerce_shop_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function prime_ecommerce_shop_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Option', 'prime-ecommerce-shop' ),
		'id'            => 'right-sidebar',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer One', 'prime-ecommerce-shop' ),
		'id'            => 'footer-one',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Two', 'prime-ecommerce-shop' ),
		'id'            => 'footer-two',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer Three', 'prime-ecommerce-shop' ),
		'id'            => 'footer-three',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Four', 'prime-ecommerce-shop' ),
		'id'            => 'footer-four',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'prime_ecommerce_shop_widgets_init' );

if( ! function_exists( 'prime_ecommerce_shop_scripts' ) ) :

/**
 * Enqueue scripts and styles.
 */
function prime_ecommerce_shop_scripts() {

	// Use minified libraries if SCRIPT_DEBUG is false
    $prime_ecommerce_shop_build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $prime_ecommerce_shop_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_style( 'prime-ecommerce-shop-bootstrap-style', get_template_directory_uri().'/css/build/bootstrap.css' );
    wp_enqueue_style( 'prime-ecommerce-shop-owl-carousel', get_template_directory_uri() . '/css/build/owl.carousel.css' );

	wp_enqueue_style( 'prime-ecommerce-shop-style', get_stylesheet_uri(), array(), PRIME_ECOMMERCE_SHOP_THEME_VERSION );

	require get_parent_theme_file_path( '/inc/css_custom.php' );
	wp_add_inline_style( 'prime-ecommerce-shop-style',$prime_ecommerce_shop_custom_css );

	if( prime_ecommerce_shop_woocommerce_activated() ) 
    wp_enqueue_style( 'prime-ecommerce-shop-woocommerce-style', get_template_directory_uri(). '/css' . $prime_ecommerce_shop_build . '/woocommerce' . $prime_ecommerce_shop_suffix . '.css', array('prime-ecommerce-shop-style'), PRIME_ECOMMERCE_SHOP_THEME_VERSION );
	
  	wp_enqueue_script( 'prime-ecommerce-shop-all', get_template_directory_uri() . '/js' . $prime_ecommerce_shop_build . '/all' . $prime_ecommerce_shop_suffix . '.js', array( 'jquery' ), '6.1.1', true );
  	wp_enqueue_script( 'prime-ecommerce-shop-v4-shims', get_template_directory_uri() . '/js' . $prime_ecommerce_shop_build . '/v4-shims' . $prime_ecommerce_shop_suffix . '.js', array( 'jquery' ), '6.1.1', true );
  	wp_enqueue_script( 'prime-ecommerce-shop-modal-accessibility', get_template_directory_uri() . '/js' . $prime_ecommerce_shop_build . '/modal-accessibility' . $prime_ecommerce_shop_suffix . '.js', array( 'jquery' ), PRIME_ECOMMERCE_SHOP_THEME_VERSION, true );
	wp_enqueue_script( 'prime-ecommerce-shop-owl-carousel', get_template_directory_uri() . '/js/build/owl.carousel.js', array('jquery'), '2.6.0', true );
	wp_enqueue_script( 'prime-ecommerce-shop-js', get_template_directory_uri() . '/js/build/custom.js', array('jquery'), PRIME_ECOMMERCE_SHOP_THEME_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'prime_ecommerce_shop_scripts' );

if( ! function_exists( 'prime_ecommerce_shop_admin_scripts' ) ) :
/**
 * Addmin scripts
*/
function prime_ecommerce_shop_admin_scripts() {
	wp_enqueue_style( 'prime-ecommerce-shop-admin-style',get_template_directory_uri().'/inc/css/admin.css', PRIME_ECOMMERCE_SHOP_THEME_VERSION, 'screen' );
}
endif;
add_action( 'admin_enqueue_scripts', 'prime_ecommerce_shop_admin_scripts' );

function prime_ecommerce_shop_customize_enque_js(){
	wp_enqueue_script( 'customizer', get_template_directory_uri() . '/inc/js/customizer.js', array('jquery'), '2.6.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'prime_ecommerce_shop_customize_enque_js', 0 );


if( ! function_exists( 'prime_ecommerce_shop_block_editor_styles' ) ) :
/**
 * Enqueue editor styles for Gutenberg
 */
function prime_ecommerce_shop_block_editor_styles() {
	// Use minified libraries if SCRIPT_DEBUG is false
	$prime_ecommerce_shop_build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
	$prime_ecommerce_shop_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	
	// Block styles.
	wp_enqueue_style( 'prime-ecommerce-shop-block-editor-style', get_template_directory_uri() . '/css' . $prime_ecommerce_shop_build . '/editor-block' . $prime_ecommerce_shop_suffix . '.css' );
}
endif;
add_action( 'enqueue_block_editor_assets', 'prime_ecommerce_shop_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extra.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Social Links Widget
 */
require get_template_directory() . '/inc/widget-social-links.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Info Theme
 */
require get_template_directory() . '/inc/info.php';

/**
 * TGM Recommendation
 */
require get_template_directory() .  '/inc/TGM/tgm.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/getting-started/getting-started.php';

/**
 * sanitization Theme
 */
require get_template_directory() . '/inc/sanitization.php';

/**
 * Load plugin for right and no sidebar
 */
if( prime_ecommerce_shop_woocommerce_activated() ) {
	require get_template_directory() . '/inc/woocommerce-functions.php';
}

/**
 * Remove header text setting and control from the Customizer.
 */
function prime_ecommerce_shop_remove_customizer_setting($wp_customize) {
    // Replace 'your_setting_id' with the actual ID or name of the setting you want to remove
    $wp_customize->remove_control('display_header_text');
    $wp_customize->remove_setting('display_header_text');
}
add_action('customize_register', 'prime_ecommerce_shop_remove_customizer_setting');


function prime_ecommerce_shop_menu_customizer_css() {
	$prime_ecommerce_shop_sidebar_text_align = get_theme_mod('prime_ecommerce_shop_sidebar_text_align', 'left');
    ?>
    <style type="text/css">
        .main-navigation ul li a {
            font-weight: <?php echo esc_html( get_theme_mod( 'prime_ecommerce_shop_menu_font_weight', '500' ) ); ?>;
            text-transform: <?php echo esc_html( get_theme_mod( 'prime_ecommerce_shop_menu_text_transform', 'uppercase' ) ); ?>;
        }
        .widget-area h2 {
            text-align: <?php echo esc_attr($prime_ecommerce_shop_sidebar_text_align); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'prime_ecommerce_shop_menu_customizer_css' );

function prime_ecommerce_shop_custom_blog_banner_title() {
    if (is_404()) {
        echo '<h1 class="entry-title">'. esc_html__( 'Comments are closed.', 'prime-ecommerce-shop' ).'</h1>';
    } elseif (is_search()) {
        echo '<h1 class="entry-title">'. esc_html__( 'Search Result For.', 'prime-ecommerce-shop' ).' ' . get_search_query() . '</h1>';
    } elseif (is_home() && !is_front_page()) {
        echo '<h1 class="entry-title">'. esc_html__( 'Blogs', 'prime-ecommerce-shop' ).'</h1>';
    } elseif (function_exists('is_shop') && is_shop()) {
        echo '<h1 class="entry-title">'. esc_html__( 'Shop', 'prime-ecommerce-shop' ).'</h1>';
    } elseif (is_page_template('template-homepage.php')) {
    } elseif (is_page()) {
        the_title('<h1 class="entry-title">', '</h1>');
    } elseif (is_single()) {
        the_title('<h1 class="entry-title">', '</h1>');
    } elseif (is_archive()) {
        the_archive_title('<h1 class="entry-title">', '</h1>');
    } else {
        the_archive_title('<h1 class="entry-title">', '</h1>');
    }
}

/**
 * Display the admin notice unless dismissed.
 */
function prime_ecommerce_shop_dashboard_notice() {
    // Check if the notice is dismissed
    $dismissed = get_user_meta(get_current_user_id(), 'prime_ecommerce_shop_dismissable_notice', true);

    // Display the notice only if not dismissed
    if (!$dismissed) {
        ?>
        <div class="updated notice notice-success is-dismissible notice-get-started-class" data-notice="get-start" style="display: flex;padding: 10px;">
            <p><?php echo esc_html('Clicking the "Getting Started" button will launch your theme discovery.', 'prime-ecommerce-shop'); ?></p>
            <a style="margin-left: 30px; padding: 8px 15px;" class="button button-primary"
               href="<?php echo esc_url(admin_url('themes.php?page=prime-ecommerce-shop')); ?>"><?php esc_html_e('Getting Started', 'prime-ecommerce-shop') ?></a>
           <a style="margin-left: 30px; padding: 8px 15px;" class="button button-primary"
           target="_blank" href="<?php echo esc_url('https://demo.themeignite.com/documentation/prime-ecommerce-shop-free'); ?>"><?php esc_html_e('Free Documentation', 'prime-ecommerce-shop') ?></a>
           
        </div>
        <?php
    }
}

// Hook to display the notice
add_action('admin_notices', 'prime_ecommerce_shop_dashboard_notice');

/**
 * AJAX handler to dismiss the notice.
 */
function prime_ecommerce_shop_dismissable_notice() {
    // Set user meta to indicate the notice is dismissed
    update_user_meta(get_current_user_id(), 'prime_ecommerce_shop_dismissable_notice', true);
    die();
}

// Hook for the AJAX action
add_action('wp_ajax_prime_ecommerce_shop_dismissable_notice', 'prime_ecommerce_shop_dismissable_notice');

/**
 * Clear dismissed notice state when switching themes.
 */
function prime_ecommerce_shop_switch_theme() {
    // Clear the dismissed notice state when switching themes
    delete_user_meta(get_current_user_id(), 'prime_ecommerce_shop_dismissable_notice');
}

// Hook for switching themes
add_action('after_switch_theme', 'prime_ecommerce_shop_switch_theme');

function prime_ecommerce_shop_enqueue_google_fontss() {
    $prime_ecommerce_shop_heading_font_family = get_theme_mod('prime_ecommerce_shop_heading_font_family', '');
    $prime_ecommerce_shop_body_font_family = get_theme_mod('prime_ecommerce_shop_body_font_family', '');

    // Google Fonts URL builder
    $google_fonts = array(
        'Arial'          => '',
        'Verdana'        => '',
        'Helvetica'      => '',
        'Times New Roman'=> '',
        'Georgia'        => '',
        'Courier New'    => '',
        'Trebuchet MS'   => '',
        'Tahoma'         => '',
        'Palatino'       => '',
        'Garamond'       => '',
        'Impact'         => '',
        'Comic Sans MS'  => '',
        'Lucida Sans'    => '',
        'Arial Black'    => '',
        'Gill Sans'      => '',
        'Segoe UI'       => '',
        'Open Sans'      => 'Open+Sans:wght@400;700',
        'Roboto'         => 'Roboto:wght@400;700',
        'Lato'           => 'Lato:wght@400;700',
        'Montserrat'     => 'Montserrat:wght@400;700',
        'Libre Baskerville' => 'Libre+Baskerville:wght@400;700'
    );

    $prime_ecommerce_shop_google_fonts_url = '';

    if (!empty($google_fonts[$prime_ecommerce_shop_heading_font_family]) || !empty($google_fonts[$prime_ecommerce_shop_body_font_family])) {
        $fonts = array();

        if (!empty($google_fonts[$prime_ecommerce_shop_heading_font_family])) {
            $fonts[] = $google_fonts[$prime_ecommerce_shop_heading_font_family];
        }

        if (!empty($google_fonts[$prime_ecommerce_shop_body_font_family])) {
            $fonts[] = $google_fonts[$prime_ecommerce_shop_body_font_family];
        }

        // Build Google Fonts URL
        $prime_ecommerce_shop_google_fonts_url = add_query_arg(
            'family',
            implode('|', $fonts),
            'https://fonts.googleapis.com/css2'
        );
    }

    if ($prime_ecommerce_shop_google_fonts_url) {
        wp_enqueue_style('prime-ecommerce-shop-google-fonts', $prime_ecommerce_shop_google_fonts_url, false);
    }
}
add_action('wp_enqueue_scripts', 'prime_ecommerce_shop_enqueue_google_fontss');


function prime_ecommerce_shop_apply_typography() {
    // Get the font family settings from the customizer
    $prime_ecommerce_shop_heading_font_family = get_theme_mod('prime_ecommerce_shop_heading_font_family');
    $prime_ecommerce_shop_body_font_family = get_theme_mod('prime_ecommerce_shop_body_font_family');

    // Only output CSS if one or both fonts are set
    if ($prime_ecommerce_shop_body_font_family || $prime_ecommerce_shop_heading_font_family) {
        ?>
        <style type="text/css">
            <?php if ($prime_ecommerce_shop_body_font_family): ?>
            body, a, a:active, a:hover {
                font-family: <?php echo esc_html($prime_ecommerce_shop_body_font_family); ?> !important;
            }
            <?php endif; ?>

            <?php if ($prime_ecommerce_shop_heading_font_family): ?>
            h1, h2, h3, h4, h5, h6 {
                font-family: <?php echo esc_html($prime_ecommerce_shop_heading_font_family); ?> !important;
            }
            <?php endif; ?>
        </style>
        <?php
    }
}
add_action('wp_head', 'prime_ecommerce_shop_apply_typography');

function prime_ecommerce_shop_body_sidebar_classes( $classes ) {
    $prime_ecommerce_shop_sidebar_position = get_theme_mod( 'prime_ecommerce_shop_sidebar_position', 'right' );

    if ( $prime_ecommerce_shop_sidebar_position === 'left' ) {
        $classes[] = 'sidebar-left';
    } elseif ( $prime_ecommerce_shop_sidebar_position === 'right' ) {
        $classes[] = 'sidebar-right';
    } elseif ( $prime_ecommerce_shop_sidebar_position === 'no-sidebar' ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'prime_ecommerce_shop_body_sidebar_classes' );