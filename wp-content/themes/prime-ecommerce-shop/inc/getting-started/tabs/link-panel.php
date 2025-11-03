<?php
/**
 * Right Buttons Panel.
 *
 * @package Prime_Ecommerce_Shop
 */
?>
<div class="panel-right">
	<div class="prime-ecommerce-shop-button-container">
		<a target="_blank" href="<?php echo esc_url( PRIME_ECOMMERCE_SHOP_DEMO_URL ); ?>" class="button button-primary solo1">
			<?php esc_html_e("THEME DEMO", "prime-ecommerce-shop"); ?>
		</a>
		<a target="_blank" href="<?php echo esc_url( PRIME_ECOMMERCE_SHOP_URL ); ?>" class="button button-primary solo2">
			<?php esc_html_e("GO PRO", "prime-ecommerce-shop"); ?>
		</a>
		<a target="_blank" href="<?php echo esc_url( PRIME_ECOMMERCE_SHOP_BUNDLE_URL ); ?>" class="button button-primary solo2">
			<?php esc_html_e("BUY ALL THEMES", "prime-ecommerce-shop"); ?>
		</a>
		<a target="_blank" href="<?php echo esc_url( PRIME_ECOMMERCE_SHOP_PRO_DOC_URL ); ?>" class="button button-primary solo1">
			<?php esc_html_e("PRO DOCUMENTATION ", "prime-ecommerce-shop"); ?>
		</a>
	</div>
	<div class="panel-aside">
		<h4><?php esc_html_e( 'UPGRADE TO PRO :-', 'prime-ecommerce-shop' ); ?></h4>
		<p><?php esc_html_e( 'The Pro version of our theme offers a seamless website customization experience with its intuitive interface. With just a few clicks, you can effortlessly transform the look and feel of your website. Enjoy the freedom to personalize various elements such as colors, background images, patterns, and fonts, elevating your website s aesthetics and brand identity.In addition, the Pro theme goes beyond the basic features of the free version by providing an expanded selection of homepage sections. This enables you to effectively showcase your organizations services and offerings, empowering the growth of your business or cause. Moreover, the Pro version includes a wide range of professionally designed page templates, giving you a head start in creating impactful web pages with ease. To ensure a top-notch experience, the Pro version receives regular updates, ensuring compatibility with the latest web technologies and maintaining optimal performance. Additionally, our dedicated support team is readily available to address any questions or concerns you may have, providing timely assistance when you need it most.', 'prime-ecommerce-shop' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( PRIME_ECOMMERCE_SHOP_URL ); ?>" title="<?php esc_attr_e( 'View Premium Version', 'prime-ecommerce-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'READ MORE ABOUT THE FEATURES HERE', 'prime-ecommerce-shop' ); ?>
        </a>
	</div>
</div>