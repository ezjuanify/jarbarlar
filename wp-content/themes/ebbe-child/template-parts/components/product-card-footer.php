<?php
if (!defined('ABSPATH')) exit;
$product_data = $args['product_data'] ?? null;
if (!$product_data) return;
$product = wc_get_product($product_data['id']);
?>

<!-- PRODUCT CARD FOOTER -->
<div class="product-card-footer">
    <!-- VARIATIONS -->
        <?php if (!empty($product_data['variations'])): ?>
        <div class="product-variations">
            <?php foreach ($product_data['variations'] as $variation): ?>
                <label>
                    <input type="radio" name="variant-<?php echo esc_attr($product->get_id()); ?>" value="<?php echo esc_attr($variation['id']); ?>" />
                    <span><?php echo esc_html($variation['label']); ?></span>
                    <span><?php echo wp_kses_post($variation['price']); ?></span>
                </label>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <!-- RATING -->
    <?php if (isset($product_data['rating'])): ?>
        <div class="product-rating">
            <?php if ($product_data['rating'] > 0): ?>
                <?php echo wp_kses_post($product_data['rating_html']); ?>
            <?php else: ?>
                <div class="star-rating">
                    <span class="star empty-star">&#9734;</span>
                    <span class="star empty-star">&#9734;</span>
                    <span class="star empty-star">&#9734;</span>
                    <span class="star empty-star">&#9734;</span>
                    <span class="star empty-star">&#9734;</span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- PRODUCT PRICE -->
    <div class="product-price" id="product-price-<?php echo $product->get_id(); ?>">
        <?php echo wp_kses_post($product->get_price_html()); ?>
    </div>

    <!-- LOYALTY POINTS -->
    <?php if (!empty($product_data['points'])): ?>
        <div class="product-loyalty">
            <span class="label">Loyalty Reward:</span>
            <span class="points"><?php echo esc_html($product_data['points']); ?> Points</span>
        </div>
    <?php endif; ?>

    <!-- PRODUCT ACTIONS -->
    <?php if (!empty($product_data['type'])): ?>
        <div class="product-actions">
            <?php if ($product_data['type'] === 'variable'): ?>
                <a class="button select-options" 
                    href="<?php echo esc_url(get_permalink($product->get_id())); ?>">
                    Select Options
                </a>
            <?php else: ?>
                <?php if (!empty($product_data['stock'])): ?>
                    <a  class="button add_to_cart_button"
                        href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                        data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                        data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                        data-quantity="1"
                        aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>"
                        aria-describedby="<?php echo esc_attr($product->add_to_cart_aria_describedby()); ?>"
                        rel="nofollow">
                        Add to Cart
                    </a>
                <?php else: ?>
                    <a class="button add_to_cart_button disabled" href="#">
                        Out of Stock
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>