<?php
// Enqueue styles for the child theme or custom scripts
// Add Countdown Timer to Footer
// function add_countdown_timer() {


function ebbe_child_scripts()
{
    wp_enqueue_style('ebbe-parent-style', get_template_directory_uri() . '/style.css');
	
	wp_enqueue_style('ebbe-child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'),
        wp_get_theme()->get('Version') // Versioning for cache busting
    );
}

// Enqueue WooCommerce scripts for AJAX Add to Cart
function enqueue_woocommerce_scripts()
{
    if (function_exists('is_woocommerce')) {
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_woocommerce_scripts');


// Shortcode for Products Grid

function custom_products_grid_by_category_shortcode($atts)
{
   $atts = shortcode_atts(array(
        'category' => '',      // Default category slug (empty means no category filter)
        'posts_per_page' => 4, // Default number of products to show
    ), $atts, 'custom_products_grid_with_loyalty_points');

    $category = sanitize_text_field($atts['category']);
    $posts_per_page = intval($atts['posts_per_page']);

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
    );

    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
                'operator' => 'IN',
            ),
        );
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        echo '<div class="custom-products-list grid">';
        while ($query->have_posts()) : $query->the_post();
            global $product;

            // Fetch loyalty points for the product
            $earn_campaign = Wlr\App\Helpers\EarnCampaign::getInstance();
            $user_email = is_user_logged_in() ? wp_get_current_user()->user_email : '';
            $extra = array(
                'product' => $product,
                'is_calculate_based' => 'product',
                'user_email' => $user_email,
                'is_message' => true,
            );
            $cart_action_list = $earn_campaign->getProductActionList();
            $reward_list = $earn_campaign->getActionEarning($cart_action_list, $extra);

            // Calculate loyalty points
            $points = 0;
            foreach ($reward_list as $rewards) {
                foreach ($rewards as $reward) {
                    if (isset($reward['point'])) {
                        $points += $reward['point'];
                    }
                }
            }
  $sku = $product->get_sku();
            preg_match('/\d+$/', $sku, $matches);
            $quantity = $matches[0] ?? '';
	
//             $attributes = $product->get_attributes();
//             $country = '';
            
//             if (!empty($attributes)) {
//                 foreach ($attributes as $attribute) {
//                     if (strpos(strtolower($attribute->get_name()), 'country') !== false) { // Check if the attribute is named "country"
//                         $country = $attribute->is_taxonomy()
//                             ? implode(', ', wc_get_product_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names']))
//                             : implode(', ', $attribute->get_options()); // Get the country value(s)
//                     }
//                 }
//             }
            
            // Use WooCommerce base country if no country attribute is found
            if (empty($country)) {
                $country = WC()->countries->get_base_country();
            }
            
            // Display country in the console (optional debugging)
//             echo "<script>console.log('Country: " . esc_js($country) . "');</script>";
            

            // Display product rating
            if (function_exists('wc_get_rating_html')) {
                $average_rating = $product->get_average_rating();
                //   / WooCommerce function to display rating
            }

            // Get country flag URL
            $flag_url = '';
            if ($country) {
                // Make sure the country name is properly formatted and escaped
                // $country_slug = urlencode($country);
                $api_url = "https://restcountries.com/v3.1/name/{$country}?fields=flags";
                $response = wp_remote_get($api_url);

                // Check for errors in the API request
                if (! is_wp_error($response)) {
                    $data = wp_remote_retrieve_body($response);
                    $country_data = json_decode($data, true);

                    // Ensure the flag URL is valid
                    if (isset($country_data[0]['flags']['png'])) {
                        $flag_url = $country_data[0]['flags']['png'];
                    }
                }
            }

            // Get the first product category
            $categories = get_the_terms($product->get_id(), 'product_cat');
            $first_category = $categories && ! is_wp_error($categories) ? $categories[0]->name : '';

            // Display Rating conditionally (check if the setting is enabled)
            $show_rating = sanitize_text_field(ebbe()->get_setting('ebbe_shop_product_box_rating'));
            // $show_rating = filter_var($show_rating, FILTER_VALIDATE_BOOLEAN); // Ensure it's a boolean
            // 

    ?>

  

            <div class="products-wrapper prd_item">
                <div class="thumbnail-and-details">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo woocommerce_get_product_thumbnail(); ?>
                    </a>
                </div>

                <div class="woocommerce-title-metas ebbe-alignment-left">
                    <div class="product_country">

                        <?php

                        if ($product->is_in_stock()) {
                            echo '<div class="product-stock-status stockin">';
                            echo 'In Stock';
                            echo '</div>';
                        } else {
                            echo '<div class="product-stock-status stockout">';
                            echo 'Out of Stock';
                            echo '</div>';
                        }
                        ?>

                        <?php if ($country) : ?>
                            <div class="product-country">
                                <!-- <span>Country: <?php echo esc_html($country); ?></span> -->
                                <?php if ($flag_url) : ?>
                                    <div class="product-stock-status">
                                        <img src="<?php echo esc_url($flag_url); ?>" alt="<?php echo esc_attr($country); ?> flag" class="country-flag" />
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($first_category) : ?>
                        <div class="product-collection">
                            <a class="text-uppercase text-xsmall link-meta"><?php echo esc_html($first_category); ?></a>
                        </div>
                    <?php endif; ?>
					 <?php if ($points > 0) : ?>
                    <div class="wlr-product-message">
                        Loyality reward <?php echo esc_html($points); ?> Points!
                    </div>
                <?php endif; ?>
                    <h2 class="woocommerce-loop-product__title">
                        <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                            <?php the_title(); ?>
                        </a>
                    </h2>
<?php if (!empty($quantity)) : ?>
                    <div class="product-quantity">
    <?php
    // Ensure the quantity value is numeric and starts with a valid digit
    $quantity = ltrim($quantity, '0'); // Remove leading zeros
    if (is_numeric($quantity) && $quantity !== '') {
        echo esc_html($quantity) . ' ml';
    }
    ?>
</div>
                <?php endif; ?>
                    <div class="product-reviews">
                        <?php
                        // Display product rating in stars
                        if (function_exists('wc_get_rating_html')) {
                            $average_rating = $product->get_average_rating(); // Get the average rating

                            if ($average_rating > 0) {
                                // Generate and display the star rating HTML
                                echo wc_get_rating_html($average_rating);
                            } else {
                                // Show empty stars for products with no ratings
                                echo '<div class="star-rating">';
                                for ($i = 1; $i <= 5; $i++) {
                                    echo '<span class="star empty-star">&#9734;</span>'; // Unicode empty star
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
      

           <?php
        // Check if the product is variable
        if ($product->is_type('variable')) {
            $available_variations = $product->get_available_variations();
            if (!empty($available_variations)) {
                echo '<div class="product-variations">';
                foreach ($available_variations as $index => $variation) {
                    $variation_id = $variation['variation_id'];
                    $variation_attributes = $variation['attributes'];
                    $variation_price = $variation['display_price'];
                    $radio_label = '';

                    foreach ($variation_attributes as $attribute_value) {
                        // Clean the attribute name and display the clean value
                        $radio_label .= esc_html($attribute_value) . ' ';
                    }

                    echo '<div class="variant-option" variants="'.$variation_id.'">';
                    echo '<input class="addtocartvaraint" onclick="addtocartvaraint(this)" variants="'.$variation_id.'"  type="radio" name="variant-' . $product->get_id() . '" id="variant-' . $product->get_id() . '-' . $index . '" data-price="' . esc_attr($variation_price) . '" />';
                    echo '<label for="variant-' . $product->get_id() . '-' . $index . '">' . trim($radio_label) . '</label>';
                    echo '</div>';
                }
                echo '</div>';
            }
        }
        ?>
<!-- 		varaint Add to cart			 -->
   <script>  
 
	 function addtocartvaraint(variants) {
    // Get the variant ID from the attribute
    let variantId = variants.getAttribute('variants');

    // Find the closest '.products-wrapper' and locate the target anchor element
    let productWrapper = variants.closest('.products-wrapper');
    if (productWrapper) {
        let update = productWrapper.querySelector('.product-actionsss a[data-product_id]');
        if (update) {
            // Set the initial display property to flex
            update.style.setProperty('display', 'flex', 'important');

            // Check if the next sibling is the target element and remove it
            let sibling = update.nextElementSibling;
            if (sibling && sibling.classList.contains('added_to_cart') && sibling.classList.contains('wc-forward')) {
                sibling.remove();
            }

            // Update the text and attributes dynamically
            update.textContent = 'Add to Cart';
            update.classList.add('ajax_add_to_cart', 'product_type_simple');
            update.classList.remove('product_type_variable');
            update.setAttribute('href', `?add-to-cart=${variantId}`);
            update.setAttribute('data-product_id', variantId);

            // Periodically check for siblings using setInterval
            let intervalId = setInterval(() => {
                let nextSibling = update.nextElementSibling;
                if (nextSibling && nextSibling.classList.contains('added_to_cart') && nextSibling.classList.contains('wc-forward')) {
                    // If the sibling exists, hide the update element
                    update.style.setProperty('display', 'none', 'important');

                    // Stop the interval once the condition is met
                    clearInterval(intervalId);
                }
            }, 100); // Check every 1 second
        }
    }
}



</script>
			<!-- 	End	varaint Add to cart			 -->		
           <!-- Price Container -->
        <div class="product-price" id="product-price-<?php echo $product->get_id(); ?>">
            <?php echo $product->get_price_html(); ?>
        </div>
                    <!-- Display product country and flag -->


                    <!-- Display first category -->


                    <!-- Product actions -->
                    <div class="product-actionsss">
                        <?php
                       
                        $button_text = sanitize_text_field(ebbe()->get_setting('ebbe_shop_product_box_button_text'));
                        if ($button_text == 'only-icon') {
                            ebbe_add_to_cart_text_to_icon();
                        } else {
                            echo '</a>';
                            woocommerce_template_loop_add_to_cart();
                        }
                        ?>

                    </div>
                </div>
            </div>
        <?php
        endwhile;
        echo '</div>';
    else :
        echo '<p>No products found.</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('custom_products_grid', 'custom_products_grid_by_category_shortcode');


// Shortcode for Products Slider
function custom_products_slider_by_category_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'category' => '',
        'posts_per_page' => 4,
    ), $atts, 'custom_products_slider');

    $category = sanitize_text_field($atts['category']);
    $posts_per_page = intval($atts['posts_per_page']);

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
    );

    if (! empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
                'operator' => 'IN',
            ),
        );
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        echo '<div class="custom-products-list slider">';
        while ($query->have_posts()) : $query->the_post();
            global $product;
        ?>
            <div class="product-item">
                <a href="<?php the_permalink(); ?>">
                    <?php echo woocommerce_get_product_thumbnail(); ?>
                    <h2><?php the_title(); ?></h2>
                </a>
                <div class="product-price"><?php echo $product->get_price_html(); ?></div>

                <!-- Display product reviews -->
                <div class="product-reviews">
                    <?php woocommerce_template_single_rating(); ?>
                </div>

                <p class="product-stock-status stockin">
                    <?php
                    if ($product->is_in_stock()) {
                        echo 'In Stock';
                    } else {
                        echo 'Out of Stock';
                    }
                    ?>
                </p>
                <div class="product-actions">
                    <?php
                    if ($product->is_type('variable')) {
                        echo '<a href="' . get_permalink($product->get_id()) . '" class="button select-options">Select Options</a>';
                    } else {
                        echo '<a href="' . esc_url('?add-to-cart=' . $product->get_id()) . '" class="button add-to-cart" data-product_id="' . esc_attr($product->get_id()) . '">Add to Cart</a>';
                    }
                    add_shortcode('loyalty_reward', function () {
                        return 'Loyalty Reward: ${wlr_product_points} ${wlr_points_label}!';
                    });
                    ?>

                </div>
            </div>
<?php
        endwhile;
        echo '</div>';
    else :
        echo '<p>No products found.</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}

function custom_products_grid_single_collection_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'collection' => '',    // Collection slug to display
        'posts_per_page' => 4, // Default number of products to show
    ), $atts, 'custom_products_grid_single_collection');

    $collection_slug = sanitize_text_field($atts['collection']);
    $posts_per_page = intval($atts['posts_per_page']);

    // Fetch the collection (category) details
    $collection = get_term_by('slug', $collection_slug, 'product_cat');

    if (!$collection) {
        return '<p>Collection not found.</p>';
    }

    // Get the collection thumbnail ID
    $thumbnail_id = get_term_meta($collection->term_id, 'thumbnail_id', true);
    $collection_image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    $collection_url = get_term_link($collection);
    // Prepare query to fetch products in the collection
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $collection_slug,
            ),
        ),
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts())
        echo '<div class="single-collection-wrapper">';

    // Display the collection title and image
    echo '<div class="collection-header">';
    echo '<a href="' . esc_url($collection_url) . '">';
    if ($collection_image_url) {
        echo '<img src="' . esc_url($collection_image_url) . '" alt="' . esc_attr($collection->name) . '" class="collection-image" />';
    }
    echo '<h2 class="collection-title">' . esc_html($collection->name) . '</h2>';
    echo '</a>';
    echo '</div>';

    // Display products in the collection
    // End custom-products-list

    echo '</div>'; // End single-collection-wrapper


    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('custom_products_grid_single_collection', 'custom_products_grid_single_collection_shortcode');

function display_blog_articles_by_category($atts)
{
    $atts = shortcode_atts(array(
        'category' => '', // Category slug
        'limit' => 5 // Number of articles to display
    ), $atts, 'blog_articles');

    $category_slug = $atts['category'];
    $limit = intval($atts['limit']);

    if (empty($category_slug)) {
        return '<p>Please specify a category slug.</p>';
    }

    // Fetch category by slug
    $category = get_category_by_slug($category_slug);
    if (!$category) {
        return '<p>Category not found.</p>';
    }

    // Fetch posts in the specified category
    $query_args = array(
        'category_name' => $category_slug,
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id', // Ensures only posts with images are shown
                'compare' => 'EXISTS'
            )
        )
    );
    $query = new WP_Query($query_args);

    // Check if there are posts
    if (!$query->have_posts()) {
        return '<p>No articles found in this category.</p>';
    }

    // Generate HTML
    $output = '<div class="blog-articles-container">';
    while ($query->have_posts()) {
        $query->the_post();

        $post_id = get_the_ID();
        $title = get_the_title();
        $excerpt = get_the_excerpt();
        $date = get_the_date();
        $author = get_the_author();
        $image = get_the_post_thumbnail($post_id, 'medium', array('class' => 'blog-article-image'));
        $permalink = get_permalink();

        $output .= '
        <div class="blog-article">
            <a href="' . esc_url($permalink) . '">
                ' . $image . '
                <h3 class="blog-article-title">' . esc_html($title) . '</h3>
            </a>
            <p class="blog-article-excerpt">' . esc_html($excerpt) . '</p>
            <div class="blog-article-meta">
                <span class="blog-article-date">' . esc_html($date) . '</span>
                <span class="blog-article-author">By ' . esc_html($author) . '</span>
            </div>
            <a href="' . esc_url($permalink) . '" class="blog-article-read-more">Read More</a>
        </div>';
    }
    $output .= '</div>';

    // Reset post data
    wp_reset_postdata();

    return $output;
}
add_shortcode('blog_articles', 'display_blog_articles_by_category');






function add_whatsapp_chat_button()
{
    echo '
    <div class="wh-api">
        <div class="wh-fixed whatsapp-pulse">
            <a target="_blank" href="https://api.whatsapp.com/send?phone=0000000000000&text=Welcome to Jarbarlar Chat">
                <button class="wh-ap-btn"></button>
            </a>
        </div>
    </div>

    <style>
    button.wh-ap-btn {
        outline: none;
        width: 60px;
        height: 60px;
        border: 0;
        background-color: #2ecc71;
        padding: 0;
        border-radius: 100%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        cursor: pointer;
        transition: opacity 0.3s, background 0.3s, box-shadow 0.3s;
    }

    button.wh-ap-btn::after {
        content: "";
        background-image: url("//i.imgur.com/cAS6qqn.png");
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 60%;
        width: 100%;
        height: 100%;
        display: block;
        opacity: 1;
    }

    button.wh-ap-btn:hover {
        opacity: 1;
        background-color: #20bf6b;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
    }

    .wh-api {
        position: fixed;
        bottom: 0;
        right: 0;
		z-index:11;
    }

    .wh-fixed {
        margin-right: 15px;
        margin-bottom: 15px;
    }

    .wh-fixed > a {
        display: block;
        text-decoration: none;
    }

   

    .wh-fixed > a:hover button.wh-ap-btn::before {
        opacity: 1;
        width: auto;
        padding-top: 7px;
        padding-left: 10px;
        padding-right: 10px;
        width: 100px;
    }

    /* Animation pulse */

    .whatsapp-pulse {
        width: 60px;
        height: 60px;
        right: 10px;
        bottom: 10px;
        background: #10b418;
        position: fixed;
        text-align: center;
        color: #ffffff;
        cursor: pointer;
        border-radius: 50%;
        z-index: 99;
        display: inline-block;
        line-height: 65px;
    }

    .whatsapp-pulse:before {
        position: absolute;
        content: " ";
        z-index: -1;
        bottom: -15px;
        right: -15px;
        background-color: #10b418;
        width: 90px;
        height: 90px;
        border-radius: 100%;
        animation-fill-mode: both;
        -webkit-animation-fill-mode: both;
        opacity: 0.6;
        -webkit-animation: pulse 1s ease-out;
        animation: pulse 1.8s ease-out;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
    }

    @-webkit-keyframes pulse {
        0% {
            -webkit-transform: scale(0);
            opacity: 0;
        }
        25% {
            -webkit-transform: scale(0.3);
            opacity: 1;
        }
        50% {
            -webkit-transform: scale(0.6);
            opacity: 0.6;
        }
        75% {
            -webkit-transform: scale(0.9);
            opacity: 0.3;
        }
        100% {
            -webkit-transform: scale(1);
            opacity: 0;
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        25% {
            transform: scale(0.3);
            opacity: 1;
        }
        50% {
            transform: scale(0.6);
            opacity: 0.6;
        }
        75% {
            transform: scale(0.9);
            opacity: 0.3;
        }
        100% {
            transform: scale(1);
            opacity: 0;
        }
    }
    </style>
    ';
}
add_action('wp_footer', 'add_whatsapp_chat_button');

// Enqueue scripts for child theme
add_action('wp_enqueue_scripts', 'ebbe_child_scripts');

add_action( 'woocommerce_variable_add_to_cart', function() {
    add_action( 'wp_print_footer_scripts', function() {
        $color = "#1c1c1c";
        
        ?>
        <script type="text/javascript">

        // DOM Loaded
        document.addEventListener( 'DOMContentLoaded', function() {

            // Get Variation Pricing Data
            var variations_form = document.querySelector( 'form.variations_form' );
            var data = variations_form.getAttribute( 'data-product_variations' );
            data = JSON.parse( data );

            // Loop Drop Downs
            document.querySelectorAll( 'table.variations select' )
                .forEach( function( select ) {

                // Loop Drop Down Options
                select.querySelectorAll( 'option' )
                    .forEach( function( option ) {

                    // Skip Empty
                    if( ! option.value ) {
                        return;
                    }

                    // Get Pricing For This Option
                    var pricing = '';
                    data.forEach( function( row ) {
                        if( row.attributes[select.name] == option.value ) {
                            pricing = row.price_html;
                        }
                    } );

                     var span = document.createElement( 'span' );

                    // Create Radio
                    var radio = document.createElement( 'input' );
                        radio.type = 'radio';
                        radio.name = select.name;
                        radio.value = option.value;
                        radio.checked = option.selected;
                    radio.setAttribute('id',option.value);
                    var label = document.createElement( 'label' );
                              label.htmlFor = option.value;
                        label.appendChild( document.createTextNode( ' ' + option.text + ' ' ) );

                     span.appendChild( radio );
                     span.appendChild( label );


                    // Insert Radio
                    select.closest( 'td' ).appendChild( span );

                    // Handle Clicking
                    radio.addEventListener( 'click', function( event ) {
                        select.value = radio.value;
                        jQuery( select ).trigger( 'change' );
                    } );

                } ); // End Drop Down Options Loop

                // Hide Drop Down
                select.style.display = 'none';

            } ); // End Drop Downs Loop

        } ); // End Document Loaded
        </script>

<style>
html {
--radio-color: <?= $color ?>;    
}    
td.value {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 10px;
}


td.value input[type="radio"] {
    appearance: none;
    display: none;
}

td.value label {
    font-size: 1em;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: inherit;
    text-align: center;
    border-radius: 5px;
    overflow: hidden;
    transition: linear 0.3s;
    color: var(--radio-color);
    padding: 0.3em 0.6em;
    border: 2px solid var(--radio-color);
    cursor: pointer;
}
td.value input[type="radio"]:checked + label {
    background-color: var(--radio-color);
    color: #f1f3f5;
    transition: 0.3s;
}

</style>
        <?php
    } );
} );

function custom_inline_ajax_cart_count_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Function to update the cart count
            function updateCartCount() {
                $.post('<?php echo admin_url('admin-ajax.php'); ?>', {
                    action: 'get_cart_count'
                }, function(response) { console.log(response);
                    if (response.success) {
                        $('.cart-count').text(response.data.count);
                    } else {
                        console.log("Error retrieving updated cart count");
                    }
                }).fail(function() {
                    console.log("Failed to fetch updated cart count");
                });
            }

            // Add the cart count span dynamically
            function addCartCountSpan() {
                var shoppingBagIcon = $('.fas.fa-shopping-bag');

                // Check if the icon exists to prevent errors
                if (shoppingBagIcon.length > 0 && $('.cart-count').length === 0) {
                    shoppingBagIcon.after('<span class="cart-count">0</span>');
                    updateCartCount(); // Update count after adding the span
                }
            }

            // Initial load
            addCartCountSpan();

            // Update cart count after adding to cart
            $('body').on('click', '.add_to_cart_button', function() {
                setTimeout(updateCartCount, 1000); // Update count after a short delay
            });

            // Listen for WooCommerce AJAX events to update the count
            $(document.body).on('updated_cart_totals updated_wc_div', function() {
                updateCartCount();
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_inline_ajax_cart_count_script');

function get_cart_count() {
    if ( ! defined( 'WC_VERSION' ) ) {
        wp_send_json_error( array( 'message' => 'WooCommerce is not active.' ) );
    }

    $cart_count = WC()->cart->get_cart_contents_count();
    wp_send_json_success( array( 'count' => $cart_count ) );
}
add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

// Add validation for checkout, billing address, and account details
add_action('woocommerce_after_checkout_validation', 'bks_validate_checkout_fields', 10, 2);
add_action('woocommerce_save_account_details_errors', 'bks_validate_account_details', 10, 1);

function bks_validate_checkout_fields($fields, $errors) {
    // Validate fields for the checkout page
    validate_fields($fields, $errors);
}

function bks_validate_account_details($errors) {
    // Validate fields for the account details page
    if (isset($_POST['account_first_name']) && !preg_match('/^[a-zA-Z ]+$/', $_POST['account_first_name'])) {
        $errors->add('validation_account_first_name', 'First name should only have characters.');
    }
    if (isset($_POST['account_last_name']) && !preg_match('/^[a-zA-Z ]+$/', $_POST['account_last_name'])) {
        $errors->add('validation_account_last_name', 'Last name should only have characters.');
    }
    if (isset($_POST['billing_phone']) && !preg_match('/^\+?[0-9 \-]+$/', $_POST['billing_phone'])) {
        $errors->add('validation_billing_phone', 'Phone number should only contain numbers, spaces, or +, - symbols.');
    }
}

// Common validation function
function validate_fields($fields, $errors) {
    if (isset($fields['billing_first_name']) && !preg_match('/^[a-zA-Z ]+$/', $fields['billing_first_name'])) {
        $errors->add('validation_billing_first_name', 'First name should only have characters.');
    }
    if (isset($fields['billing_last_name']) && !preg_match('/^[a-zA-Z ]+$/', $fields['billing_last_name'])) {
        $errors->add('validation_billing_last_name', 'Last name should only have characters.');
    }
    if (isset($fields['billing_phone']) && !preg_match('/^\+?[0-9 \-]+$/', $fields['billing_phone'])) {
        $errors->add('validation_billing_phone', 'Phone number should only contain numbers, spaces, or +, - symbols.');
    }
}

// Add data-id attributes for error messages
add_filter('woocommerce_add_error', 'bks_add_data_id_to_error_list', 10, 2);

function bks_add_data_id_to_error_list($error) {
    if (strpos($error, 'First name should only have characters.') !== false) {
        $error = '<li data-id="billing_first_name">' . $error . '</li>';
    } elseif (strpos($error, 'Last name should only have characters.') !== false) {
        $error = '<li data-id="billing_last_name">' . $error . '</li>';
    } elseif (strpos($error, 'Phone number should only contain numbers, spaces, or +, - symbols.') !== false) {
        $error = '<li data-id="billing_phone">' . $error . '</li>';
    }
    return $error;
}
 
add_action('wp_enqueue_scripts', 'bbloomer_phone_mask_us');

function bbloomer_phone_mask_us() {
    if (is_checkout() || is_account_page()) { // Load script only on relevant pages
        wc_enqueue_js("
            jQuery(document).ready(function($) {
                function applyPhoneMask(selector) {
                    $(selector).keydown(function(e) {
                        var key = e.which || e.charCode || e.keyCode || 0;
                        var phone = $(this);

                        // Allow backspace, tab, delete, and number keys
                        if (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
                            if (phone.val().length >= 12 && key !== 8 && key !== 46) {
                                // Prevent further input if length is 12 (except backspace or delete)
                                return false;
                            }

                            if (key !== 8 && key !== 46) {
                                // Add dash after 3rd and 7th characters
                                if (phone.val().length === 3) {
                                    phone.val(phone.val() + '-');
                                }
                                if (phone.val().length === 7) {
                                    phone.val(phone.val() + '-');
                                }
                            }
                            return true;
                        } else {
                            return false; // Block all other keys
                        }
                    });
                }

                // Apply mask to all relevant fields
                applyPhoneMask('#billing_phone');
                applyPhoneMask('#shipping_phone');
                applyPhoneMask('#account_phone');
            });
        ");
    }
}

add_filter( 'woocommerce_checkout_fields', 'bbloomer_checkout_phone_us_format' );
   
function bbloomer_checkout_phone_us_format( $fields ) {
    $fields['billing']['billing_phone']['placeholder'] = '123-456-7890';
    $fields['billing']['billing_phone']['maxlength'] = 12; // 123-456-7890 is 12 chars long
    $fields['billing']['billing_postcode']['maxlength'] = 10;
    return $fields;
}

// Hook into address save process for billing address
// add_action('woocommerce_customer_save_address', 'bks_validate_address_fields', 10, 2);

// function bks_validate_address_fields($user_id, $load_address) {
// echo "<h1>woocommerce_customer_save_address</h1>";
//     if ($load_address === 'billing') {
//         $errors = new WP_Error(); // Use WP_Error for error messages

//         // Get the billing address fields
//         $first_name = isset($_POST['billing_first_name']) ? sanitize_text_field($_POST['billing_first_name']) : '';
//         $last_name = isset($_POST['billing_last_name']) ? sanitize_text_field($_POST['billing_last_name']) : '';
//         $phone = isset($_POST['billing_phone']) ? sanitize_text_field($_POST['billing_phone']) : '';

//         // Validate first name (only letters and spaces allowed)
//         if (!preg_match('/^[a-zA-Z ]+$/', $first_name)) {
//             $errors->add('billing_first_name_error', 'Billing first name should only contain letters and spaces.');
//         }

//         // Validate last name (only letters and spaces allowed)
//         if (!preg_match('/^[a-zA-Z ]+$/', $last_name)) {
//             $errors->add('billing_last_name_error', 'Billing last name should only contain letters and spaces.');
//         }

//         // Validate phone number (in format 123-456-7890)
//         if (!preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone)) {
//             $errors->add('billing_phone_error', 'Billing phone should be in the format 123-456-7890.');
//         }

//         // If there are validation errors, display them and prevent saving
//         if (!empty($errors->get_error_messages())) {
//             foreach ($errors->get_error_messages() as $message) {
//                 wc_add_notice($message, 'error');
//             }
//             return false; // Prevent saving address
//         }
//     }
// }
