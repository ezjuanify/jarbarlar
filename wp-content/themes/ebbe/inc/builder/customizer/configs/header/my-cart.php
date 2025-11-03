<?php

class Ebbe_Builder_Item_My_Cart {
	public $id = 'my_cart';

	/**
	 * Register Builder item
	 *
	 * @return array
	 */
	function item() {
		return array(
			'name'    => esc_html__( 'My Cart', 'ebbe' ),
			'id'      => $this->id,
			'col'     => 0,
			'width'   => '4',
			'section' => 'header_my_cart',
		);
	}

	/**
	 * Optional, Register customize section and panel.
	 *
	 * @return array
	 */
	function customize() {
		$fn     = array( $this, 'render' );
		$config = array(
			array(
				'name'     => 'header_my_cart',
				'type'     => 'section',
				'panel'    => 'header_settings',
				'priority' => 200,
				'title'    => esc_html__( 'My Cart', 'ebbe' ),
			),
			array(
				'name'        => 'ebbe_header_my_cart_styling',
				'type'        => 'styling',
				'section'     => 'header_my_cart',
				'css_format'  => 'styling',
				'title'       => esc_html__( 'Styling', 'ebbe' ),
				'selector'    => array(
					'normal'            => ".builder-item--my_cart a.menu-grid-item, a.ebbe-cart-contents, .ebbe-cart-contents span.amount, .header_mini_cart_group",
					'hover'             => ".builder-item--my_cart:hover a.menu-grid-item, .builder-item--my_cart:hover .header_mini_cart_group"
				),
				'fields'      => array(
					'normal_fields' => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
						'bg_color'      => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
					'hover_fields'  => array(
						'link_color'    => false,
						'bg_cover'      => false,
						'bg_image'      => false,
						'bg_repeat'     => false,
						'bg_attachment' => false,
						'padding'       => false,
						'margin'        => false,
						'bg_color'      => false,
						'border'		=> false,
						'border_radius' => false,
						'box_shadow' 	=> false,
						'border_style' 	=> false,
					),
				),
			),
			array(
				'name'        => "ebbe_header_my_cart_typography",
				'type'        => 'typography',
				'section'     => "header_my_cart",
				'title'       => esc_html__( 'Typography', 'ebbe' ),
				'css_format'  => 'typography',
				'selector'    => ".builder-item--my_cart .ebbe-header-group-label, a.ebbe-cart-contents, .ebbe-cart-contents span.amount",
			),
			array(
				'name'            => 'ebbe_header_my_cart_icon_max_height',
				'type'            => 'slider',
				'section'         => 'header_my_cart',
				'default'         => array(),
				'max'             => 100,
				'device_settings' => true,
				'title'           => esc_html__( 'Icon Max Height', 'ebbe' ),
				'selector'        => 'format',
				'css_format'      => ".builder-item--my_cart i { font-size: {{value}}; }",
			),
			array(
				'name'  		  => 'ebbe_header_my_cart_icon',
				'type'  		  => 'icon',
				'section'         => 'header_my_cart',
				'icon' 			  => 'fas fa-shopping-basket',
				'label' 		  => esc_html__( 'Icon', 'ebbe' ),
			),
			array(
				'name'           => 'ebbe_header_my_cart__hide_icon',
				'type'           => 'checkbox',
				'section'        => 'header_my_cart',
				'checkbox_label' => esc_html__( 'Hide icon', 'ebbe' ),
				'css_format'     => 'html_class',
			),
			array(
				'name'           => 'ebbe_header_my_cart__hide_text',
				'type'           => 'checkbox',
				'section'        => 'header_my_cart',
				'checkbox_label' => esc_html__( 'Hide "My Cart" text', 'ebbe' ),
				'css_format'     => 'html_class',
			),
			array(
				'name'           => 'ebbe_header_my_cart__cart_contents',
				'type'           => 'checkbox',
				'section'        => 'header_my_cart',
				'checkbox_label' => esc_html__( 'Cart Contents', 'ebbe' ),
				'css_format'     => 'html_class',
			),

		);

		// Item Layout.
		return array_merge( $config, ebbe_header_layout_settings( $this->id, 'header_my_cart' ) );
	}

	/**
	 * Optional. Render item content
	 */
	function render() {
		$cart_url = "#";
		if ( class_exists( 'WooCommerce' ) ) {
		    $cart_url = wc_get_cart_url();
		}
		$hide_icon = sanitize_text_field( Ebbe()->get_setting( 'ebbe_header_my_cart__hide_icon' ) );
		$hide_text = sanitize_text_field( Ebbe()->get_setting( 'ebbe_header_my_cart__hide_text' ) );
		$cart_contents = sanitize_text_field( Ebbe()->get_setting( 'ebbe_header_my_cart__cart_contents' ) );

		$icon = Ebbe()->get_setting( 'ebbe_header_my_cart_icon');
		if (empty(Ebbe()->get_setting( 'ebbe_header_my_cart_icon'))) {
			$icon = 'fas fa-shopping-basket';
		} else {
			$icon = $icon['icon'];
		}
		echo '<div class="header-group-wrapper h-cart text-center">';

  			if(!$hide_icon) {
  				echo '<a  class="menu-grid-item" href="'.esc_url($cart_url).'">';
		  			echo '<i class="'.esc_html($icon).'"></i>';
				echo '</a>';
			}
    		echo '<div class="header_mini_cart_group">';
        		if(!$hide_text) {
	        		echo '<a  class="menu-grid-item ebbe-header-group-label" href="'.esc_url($cart_url).'">'.esc_html__('My Cart', 'ebbe').'</a>';
            	} 
			
				if ($cart_contents){ ?>
	                <a class="ebbe-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'ebbe'); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'ebbe' ), WC()->cart->get_cart_contents_count() ); ?>, <?php echo WC()->cart->get_cart_total(); ?>
	                </a>
	            <?php }

    		echo '</div>';
	
    		echo '<div class="header_mini_cart">';
      			the_widget( 'WC_Widget_Cart' );
    		echo '</div>';
		echo '</div>';
	}
}

Ebbe_Customize_Layout_Builder()->register_item( 'header', new Ebbe_Builder_Item_My_Cart() );
