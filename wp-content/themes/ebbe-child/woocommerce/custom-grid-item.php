<?php
/**
 * Template: Custom Grid Item
 *
 * Variables: $product_data (array)
 */
?>

<div class="products-wrapper prd_item">
    <div class="thumbnail-and-details">
        <a href="<?php echo esc_url($product_data['url']); ?>">
            <?php echo $product_data['thumbnail']; ?>
        </a>
    </div>
    
    <div class="woocommerce-title-metas ebbe-alignment-left">

        <!-- PRODUCT STOCK & META -->
        <div class="product-meta">
            <div class="product-stock-status <?php echo $product_data['stock'] ? 'stockin' : 'stockout'; ?>">
                <?php echo $product_data['stock'] ? 'In Stock' : 'Out of Stock'; ?>
            </div>
        </div>

        <?php if ($product_data['category']): ?>
            <div class="product-category">
                <span class="label">Category:</span>
                <a class="text-uppercase text-xsmall link-meta">
                    <?php echo esc_html($product_data['category']); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($product_data['quantity']): ?>
            <div class="product-quantity">
                <span class="label">Volume:</span>
                <?php echo esc_html($product_data['quantity']); ?>
            </div>
        <?php endif; ?>

        <?php if ($product_data['flag_url']): ?>
            <div class="product-origin">
                <span class="label">Origin:</span>
                <img class="country-flag" src="<?php echo esc_url($product_data['flag_url']); ?>" alt="Country Flag" />
            </div>
        <?php endif ?>

        <!-- TITLE & RATING -->
        <h2 class="woocommerce-loop-product__title">
            <a href="<?php echo esc_url($product_data['url']); ?>">
                <?php echo esc_html($product_data['title']); ?>
            </a>
        </h2>

        <?php if ($product_data['rating']): ?>
            <div class="product-rating">
                <?php echo $product_data['rating']; ?>
            </div>
        <?php endif; ?>

        <!-- LOYALTY POINTS -->
        <?php if ($product_data['points'] > 0): ?>
            <div class="product-loyalty">
                <span class="label">Loyalty Reward:</span>
                <span class="points"><?php echo esc_html($product_data['points']); ?> Points</span>
            </div>
        <?php endif; ?>

        <!-- ADD TO CART - VARIABLE -->
        <?php if ($product_data['type'] === 'variable' && !empty($product_data['variations'])): ?>
            <div class="product-variations">
                <?php foreach ($product_data['variations'] as $variation): ?>
                    <label>
                        <input type="radio" name="variant-<?php echo esc_attr($product_data['id']); ?>" value="<?php echo esc_attr($variation['id']); ?>" />
                        <span><?php echo $variation['label']; ?></span>
                        <span><?php echo $variation['price']; ?></span>
                    </label>
                <?php endforeach ?>
            </div>
        <?php endif; ?>
    </div>
</div>