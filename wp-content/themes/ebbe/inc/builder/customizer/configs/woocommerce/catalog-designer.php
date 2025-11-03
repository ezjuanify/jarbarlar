<?php

class ebbe_WC_Catalog_Designer {

	function product__title() {
	

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * @see    woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

	}
	function display_product_quantity_and_modified_sku() {
		global $product;
	
		if ( ! $product ) {
			return;
		}
	
		// Check if the "Show Quantity" option is enabled
		$show_quantity = get_option( 'ebbe_shop_product_box_Quantity', 'no' ); // Default to 'no'
		if ( $show_quantity === 'no' ) {
			return;  // Don't display anything if the setting is off
		}
	   
		// Get SKU and modify it
		$sku = $product->get_sku();
		if ( $sku ) {
			// Extract the last numeric value from the SKU using a regular expression
			preg_match('/\d+$/', $sku, $matches);
	
			if ( ! empty( $matches ) ) {
				$numeric_value = $matches[0]; // Extracted numeric value (e.g., '490')
				// Remove the numeric value from the SKU and append 'ml'
				$modified_sku = str_replace($numeric_value, '', $sku) . 'ml';
			} else {
				// If no numeric value is found, use the SKU as-is and append 'ml'
				$modified_sku = $sku . 'ml';
			}
		} else {
			$modified_sku = ''; // If no SKU exists
		}
	
		// Get stock quantity
		$stock_quantity = $product->get_stock_quantity();
	
		// Display the modified SKU and quantity if the setting is enabled
		echo '<div class="product-sku-quantity">';
		if ( $modified_sku ) {
			echo '<p>' . esc_html__( 'SKU: ', 'ebbe' ) . $modified_sku . '</p>';
		}
		if ( $stock_quantity > 0 ) {
			echo '<p>' . esc_html__( 'Quantity: ', 'ebbe' ) . $stock_quantity . ' ' . esc_html__( 'items available', 'ebbe' ) . '</p>';
		}
		echo '</div>';
	}
	function product__stock() {
        global $product;
        
        if ( ! $product ) {
            return;
        }

        // Get stock status and quantity
        $stock_status = $product->get_stock_status(); // in-stock, out-of-stock, on-backorder
        $stock_quantity = $product->get_stock_quantity();
		$attributes = $product->get_attributes();
		$country = '';
		
		// if (!empty($attributes)) {
		// 	foreach ($attributes as $attribute) {
		// 		if (strpos(strtolower($attribute->get_name()), 'country') !== false) { // Check if the attribute is named "country"
		// 			$country = $attribute->is_taxonomy()
		// 				? implode(', ', wc_get_product_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names']))
		// 				: implode(', ', $attribute->get_options()); // Get the country value(s)
		// 		}
		// 	}
		// }
		
        // Get user's country code using WooCommerce geolocation
        $user_country = WC()->countries->get_base_country(); // This fetches the store base country

        // Fetch country flag from Restcountries API
        $flag_url = $this->get_country_flag_url( $user_country );

        // Display stock with country flag
        if ( $stock_status === 'instock' ) {
            echo '<div class="product-stock-status stockin">';
            echo '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($user_country) . ' Flag" class="stock-country-flag" />';
            echo esc_html( 'In Stock' );
            echo '</div>';
        } elseif ( $stock_status === 'outofstock' ) {
            echo '<div class="product-stock-status stockout">';
            echo '<img src="' . esc_url($flag_url) . '" alt="' . esc_attr($user_country) . ' Flag" class="stock-country-flag" />';
            echo esc_html( 'Out of Stock' );
            echo '</div>';
        }
    }
	function get_country_flag_url( $country_code ) {
        $api_url = "https://restcountries.com/v3.1/alpha/{$country_code}";

        // Get the country data
        $response = wp_remote_get( $api_url );
        if ( is_wp_error( $response ) ) {
            return ''; // Return empty if API call fails
        }

        // Decode the response and get the flag URL
        $data = wp_remote_retrieve_body( $response );
        $country_data = json_decode( $data, true );

        // Check if the flag is available
        if ( isset( $country_data[0]['flags']['png'] ) ) {
            return $country_data[0]['flags']['png'];
        }

        return ''; // Return empty if flag is not found
    }
	function product__category() {
		global $post;

		$tax = 'product_cat';
		$num = 1;

		$terms = get_the_terms( $post, $tax );

		if ( is_wp_error( $terms ) ) {
			return $terms;
		}

		if ( empty( $terms ) ) {
			return false;
		}

		$links = array();

		foreach ( $terms as $term ) {
			$link = get_term_link( $term, $tax );
			if ( is_wp_error( $link ) ) {
				return $link;
			}
			$links[] = '<a class="text-uppercase text-xsmall link-meta" href="' . esc_url( $link ) . '" rel="tag">' . esc_html( $term->name ) . '</a>';
		}

		$categories_list = array_slice( $links, 0, $num );

		echo join( ' ', $categories_list );
	}

	function product__rating() {
		woocommerce_template_loop_rating();
	}

	function product__price() {
		woocommerce_template_loop_price();
	}

	function product__description() {
		echo '<div class="woocommerce-loop-product__desc">';

			$text = '';
			global $post;
			if ( $post ) {
				if ( $post->post_excerpt ) {
					$text = $post->post_excerpt;
				} else {
					$text = $post->post_content;
				}
			}
			if ( $excerpt ) {
				// WPCS: XSS OK.
				echo apply_filters( 'the_excerpt', $excerpt );
			} else {
				the_excerpt();
			}

		echo '</div>';

	}

	function product__add_to_cart() {
		$button_text = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_button_text' ) );
		if($button_text == 'only-icon') {
			ebbe_add_to_cart_text_to_icon();
		} else {
			echo '</a>';
			woocommerce_template_loop_add_to_cart();
		}
		
		
	}
	function show_variants() {
		global $product;
	
		if ($product->is_type('variable')) {
			$available_variations = $product->get_available_variations();
	
			if (!empty($available_variations)) {
				echo '<div class="product-variations">';
	
	
				foreach ($available_variations as $index => $variation) {
					$variation_id = $variation['variation_id'];
					$variation_price = wc_price($variation['display_price']);
					$variation_attributes = $variation['attributes'];
	
					$radio_label = '';
					foreach ($variation_attributes as $attribute_value) {
						$radio_label .= esc_html($attribute_value) . ' ';
					}
	
					echo '<div class="variant-option">';
					echo '<input type="radio" name="variant-' . $product->get_id() . '" id="variant-' . $product->get_id() . '-' . $index . '" value="' . esc_attr($variation_id) . '" data-price="' . esc_attr($variation_price) . '" />';
					echo '<label for="variant-' . $product->get_id() . '-' . $index . '">' . trim($radio_label) . '</label>';
					echo '</div>';
				}
	
				echo '</div>';
				echo '<div class="product-price" id="product-price-' . $product->get_id() . '">' . $product->get_price_html() . '</div>';
			}
		}
	}
	
	private $configs = array();

	public function __construct() {
		add_filter( 'ebbe/customizer/config', array( $this, 'config' ), 100 );
	
		add_action( 'ebbe_wc_product_loop', array( $this, 'render' ) );
	
		// Other hooks and actions...
	
		// Add stock display
		$show_stock = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_stock' ) );
		if ( $show_stock ) {
			add_action( 'woocommerce_after_title_item', array( $this, 'product__stock' ), 40 );
		}
	
		// Add to cart button
		$show_button = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_button' ) );
		if($show_button == 'in-grid') {
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'product__add_to_cart' ) );
		} else if ($show_button == 'on-hover') {
			add_action('ebbe/wc-product/after-media' , array( $this, 'product__add_to_cart' ), 10);
		}
	
		// Product Price
		add_action('woocommerce_after_title_item' , array( $this, 'product__price' ), 20);

		add_action('woocommerce_after_title_item' , array($this , 'show_variants') , 20 );
	
		// Product Rating
		$show_rating = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_rating' ) );
		if($show_rating) {
			add_action('woocommerce_after_title_item' , array( $this, 'product__rating' ), 10);
		}
	
		// Product Category
		$show_category = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_category' ) );
		if($show_category) {
			add_action('woocommerce_before_shop_loop_item' , array( $this, 'product__category' ));
		}
	
		// Product Description
		$show_description = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_description' ) );
		if($show_description) {
			add_action('woocommerce_after_title_item' , array( $this, 'product__description' ), 30);
		}
	
		// Show Quantity / Modified SKU (if enabled)
		$show_quantity = sanitize_text_field( ebbe()->get_setting( 'ebbe_shop_product_box_Quantity' ) );
		if ( $show_quantity ) {
			add_action( 'woocommerce_after_title_item', array( $this, 'display_product_quantity_and_modified_sku' ), 50 );
		}
	}
	

	/**
	 * Get callback function for item part
	 *
	 * @param string $item_id ID of builder item.
	 *
	 * @return string|object|boolean
	 */
	function callback( $item_id ) {
		$cb = apply_filters( 'ebbe/product-designer/part', false, $item_id, $this );
		if ( ! is_callable( $cb ) ) {
			$cb = array( $this, 'product__' . $item_id );
		}
		if ( is_callable( $cb ) ) {
			return $cb;
		}

		return false;
	}

	function render() {
		
		do_action('ebbe/before_render_woocommerce_product');

		$this->configs = apply_filters( 'ebbe_wc_catalog_designer/configs', $this->configs );

		$cb = $this->callback( 'media' );
		if ( $cb ) {
			call_user_func( $cb, array( null, $this ) );
		}
		
		
		echo '<div class="woocommerce-title-metas '.apply_filters( 'ebbe_woocommerce_title_metas', 'ebbe-alignment-left').'">';
			do_action( 'woocommerce_before_shop_loop_item' );

			$this->product__title();

			do_action( 'woocommerce_after_title_item' );

			do_action( 'woocommerce_after_shop_loop_item' );
			do_action( 'ebbe/wc-product/after-media' );

		echo '</div>';


		do_action('ebbe/after_render_woocommerce_product');


	}

	function config( $configs ) {

		$section = 'ebbe_catalog_designer';
		$configs[] = array(
			'name'     => $section,
			'type'     => 'section',
			'panel'    => 'woocommerce',
			'priority' => 10,
			'label'    => esc_html__( 'Product Box', 'ebbe' ),
		);
		$configs[] = array(
			'name'    => 'ebbe_box_settings',
			'type'    => 'heading',
			'section' => $section,
			'title'   => esc_html__( 'Box Styling', 'ebbe' ),
		);
		$configs[] = array(
			'name'            => 'ebbe_shop_product_box_layout',
			'type'            => 'text_align_no_justify',
			'section'         => $section,
			'selector'        => '.woocommerce-title-metas',
			'css_format'      => 'text-align: {{value}};',
			'title'           => esc_html__( 'Box Layout', 'ebbe' ),
			'default'           => 'left',
		);

		$configs[] = array(
			'name'        => 'ebbe_shop_product_box_styling',
			'type'        => 'styling',
			'section'     => $section,
			'css_format'  => 'styling',
			'title'       => esc_html__( 'Box Styling', 'ebbe' ),
			'selector'    => array(
				'normal'            => ".products-wrapper",
				'hover'         	=> ".products-wrapper:hover",
				'normal_bg_color' => ".products-wrapper",
				'normal_border_style' => ".products-wrapper",
				'normal_border_width' => ".products-wrapper",
				'normal_border_color' => ".products-wrapper",
				'normal_border_radius' => ".products-wrapper",
				'normal_box_shadow' => ".products-wrapper",
			),
			'fields'      => array(
				'normal_fields' => array(
					'link_color'    => false,
					'bg_cover'      => false,
					'bg_image'      => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
					'margin'        => false,
					'text_color'    => false
				)
			)
		);

		$configs[] = array(
			'name'        => 'ebbe_shop_product_box_categ_styling',
			'type'        => 'typography',
			'section'     => $section,
			'css_format'  => 'typography',
			'title'       => esc_html__( 'Category Typography', 'ebbe' ),
			'selector'    => ".woocommerce-title-metas .text-xsmall"
		);
		$configs[] = array(
			'name'        => 'ebbe_shop_product_box_categ_color',
			'type'        => 'color',
			'section' 	  => $section,
			'selector'    => ".woocommerce-title-metas .text-xsmall",
			'css_format'  => 'color: {{value}};',
			'title'       => esc_html__( 'Category Color', 'ebbe' )
		);
		$configs[] = array(
			'name'        => 'ebbe_shop_product_box_title_styling',
			'type'        => 'typography',
			'section'     => $section,
			'css_format'  => 'typography',
			'title'       => esc_html__( 'Title Typography', 'ebbe' ),
			'selector'    => ".woocommerce .woocommerce-loop-product__title a"
		);
		$configs[] = array(
			'name'        => 'ebbe_shop_product_box_price_styling',
			'type'        => 'typography',
			'section'     => $section,
			'css_format'  => 'typography',
			'title'       => esc_html__( 'Price Typography', 'ebbe' ),
			'selector'    => ".woocommerce-Price-amount bdi"
		);
		$configs[] = array(
			'name'        => 'ebbe_shop_product_box_price_color',
			'type'        => 'color',
			'section' 	  => $section,
			'selector'    => ".woocommerce-Price-amount bdi",
			'css_format'  => 'color: {{value}};',
			'title'       => esc_html__( 'Price Color', 'ebbe' )
		);
		$configs[] = array(
			'name'    => 'ebbe_box_options',
			'type'    => 'heading',
			'section' => $section,
			'title'   => esc_html__( 'Custom Options', 'ebbe' ),
		);
		$configs[] = array(
			'name'           => 'ebbe_shop_product_box_category',
			'type'           => 'checkbox',
			'section'        => $section,
			'checkbox_label' => esc_html__( 'Show Category', 'ebbe' ),
			'css_format'     => 'html_class',
		);

		$configs[] = array(
			'name'           => 'ebbe_shop_product_box_description',
			'type'           => 'checkbox',
			'section'        => $section,
			'checkbox_label' => esc_html__( 'Show Description', 'ebbe' ),
			'css_format'     => 'html_class',
		);

		$configs[] = array(
			'name'           => 'ebbe_shop_product_box_rating',
			'type'           => 'checkbox',
			'section'        => $section,
			'default'         => 1,
			'checkbox_label' => esc_html__( 'Show Rating', 'ebbe' ),
			'css_format'     => 'html_class',
		);

		$configs[] = array(
			'name'    => 'ebbe_box_button_settings',
			'type'    => 'heading',
			'section' => $section,
			'title'   => esc_html__( 'Add to Cart Button Settings', 'ebbe' ),
		);
		
		$configs[] = array(
				'name'            => 'ebbe_shop_product_box_button',
				'type'            => 'radio_group',
				'section'         => $section,
				'default'         => 'in-grid',
				'title'           => esc_html__( 'Add to Cart button', 'ebbe' ),
				'choices'         => array(
					'no-button'  	=> esc_html__( 'No Button', 'ebbe' ),
					'on-hover'  	=> esc_html__( 'On Hover', 'ebbe' ),
					'in-grid'  		=> esc_html__( 'In Grid', 'ebbe' ),
				),
		);
		$configs[] = array(
				'name'            => 'ebbe_shop_product_box_button_text',
				'type'            => 'radio_group',
				'section'         => $section,
				'default'         => 'only-icon',
				'title'           => esc_html__( 'Add to Cart button type', 'ebbe' ),
				'choices'         => array(
					'only-text'  	=> esc_html__( 'Only text', 'ebbe' ),
					'only-icon' 	=> esc_html__( 'Only Icon', 'ebbe' )
				),
		);
		$configs[] = array(
            'name'           => 'ebbe_shop_product_box_stock',
            'type'           => 'checkbox',
            'section'        => $section,
            'checkbox_label' => esc_html__( 'Show Stock Status with Country Flag', 'ebbe' ),
            'css_format'     => 'html_class',
        );
		$configs[] = array(
            'name'           => 'ebbe_shop_product_box_Quantity',
            'type'           => 'checkbox',
            'section'        => $section,
            'checkbox_label' => esc_html__( 'Show Quantity', 'ebbe' ),
            'css_format'     => 'html_class',
        );

		$configs[] = array(
			'name'     => 'ebbe_single_product',
			'type'     => 'section',
			'panel'    => 'woocommerce',
			'priority' => 10,
			'label'    => esc_html__( 'Product Single', 'ebbe' ),
		);
		$configs[] = array(
			'name'        	=> 'ebbe_single_product_gallery_styling',
			'type'        	=> 'styling',
			'section'     	=> 'ebbe_single_product',
			'css_format'  	=> 'styling',
			'title'       	=> esc_html__( 'Main Image & Gallery Styling', 'ebbe' ),
			'selector'    	=> array(
				'normal'        => ".woocommerce .product .images .woocommerce-product-gallery__image",
				'hover'         => ".woocommerce .product .images .woocommerce-product-gallery__image:hover",
			),
			'fields'      	=> array(
				'normal_fields' => array(
					'margin'    => false,
					'padding'    => false,
					'bg_heading'    => false,
					'text_color'    => false,
					'link_color'    => false,
					'bg_color'      => false,
					'bg_cover'      => false,
					'bg_image'      => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
					'margin'        => false,
				),
				'hover_fields'  => array(
					'margin'    => false,
					'padding'    => false,
					'bg_heading'    => false,
					'text_color'    => false,
					'link_color'    => false,
					'bg_color'      => false,
					'bg_cover'      => false,
					'bg_image'      => false,
					'bg_repeat'     => false,
					'bg_attachment' => false,
					'margin'        => false,
				)
			)
		);
		$configs[] = array(
			'name'           => 'ebbe_single_product_related',
			'type'           => 'checkbox',
			'section'        => 'ebbe_single_product',
			'default'         => 1,
			'checkbox_label' => esc_html__( 'Related Products', 'ebbe' ),
			'css_format'     => 'html_class',
		);
		$configs[] = array(
				'name'            => 'ebbe_single_product_related_nr',
				'type'            => 'select',
				'section'         => 'ebbe_single_product',
				'default'         => 'circle',
				'title'           => esc_html__( 'Number of related products', 'ebbe' ),
				'choices'         => array(
					'4' => esc_html__( '4', 'ebbe' ),
					'5'  => esc_html__( '5', 'ebbe' ),
					'6'  => esc_html__( '6', 'ebbe' )
				),
		);

		$configs[] = array(
			'name'     =>  'ebbe_shop_archives',
			'type'     => 'section',
			'panel'    => 'woocommerce',
			'priority' => 10,
			'label'    => esc_html__( 'Shop Archives', 'ebbe' ),
		);
		$configs[] = array(
            'name'        => 'ebbe_shop_grid_list_switcher',
            'type'      => 'radio_group',
            'section'   => 'ebbe_shop_archives', 
            'title'     => esc_html__('Grid / List default', 'ebbe'),
            'description'  => esc_html__('Choose which format products should display in by default.', 'ebbe'),
            'choices'   => array(
                'grid'      => esc_html__( 'Grid', 'ebbe' ),
                'list'      => esc_html__( 'List', 'ebbe' ),
            ),
            'default'   => 'grid',
        );
        $configs[] = array(
            'name'      	=> 'ebbe_shop_layout',
            'type'      	=> 'radio_group',
            'section'   	=> 'ebbe_shop_archives', 
            'title'     	=> esc_html__('Sidebar', 'ebbe'),
            'description'  	=> esc_html__('Choose the position of the sidebar.', 'ebbe'),
            'choices'   	=> array(
                'left-sidebar'	=> esc_html__( 'Left Sidebar', 'ebbe' ),
                'no-sidebar'    => esc_html__( 'No Sidebar', 'ebbe' ),
                'right-sidebar' => esc_html__( 'Right Sidebar', 'ebbe' ),
            ),
            'default'   	=> 'left-sidebar',
        );
        $configs[] = array(
            'name'        	=> 'ebbe_shop_columns',
            'type'      	=> 'select',
            'section'   	=> 'ebbe_shop_archives', 
            'title'     	=> esc_html__('Number of shop columns', 'ebbe'),
            'description'  => esc_html__('Number of products per column to show on shop list template.', 'ebbe'),
            'choices'   => array(
                '2'         => esc_html__('2 columns','ebbe'),
                '3'         => esc_html__('3 columns','ebbe'),
                '4'         => esc_html__('4 columns','ebbe')
            ),
            'default'   => '3',
        );
        $configs[] = array(
            'name'       	=> 'ebbe_shop_no_products',
            'type'     		=> 'text',
			'section'   	=> 'ebbe_shop_archives',
            'title'    		=> esc_html__('No. of products per page', 'ebbe'),
           	'description' 	=> esc_html__('Number of products to show on shop list template.', 'ebbe'),
            'default'  		=> '9'
        );
		return $configs;
	}

	function product__media() {
		echo '<div class="thumbnail-and-details">';
		/**
		 * Hook: ebbe/wc-product/before-media
		 * hooked: woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'ebbe/wc-product/before-media' );
		woocommerce_show_product_loop_sale_flash();
		woocommerce_template_loop_product_thumbnail();
		do_action( 'ebbe_after_loop_product_media' );
		/**
		 * Hook: ebbe/wc-product/after-media
		 * hooked: woocommerce_template_loop_product_link_close - 10
		 */
		// do_action( 'ebbe/wc-product/after-media' );
		echo '</div>';
	}

}

new ebbe_WC_Catalog_Designer();
