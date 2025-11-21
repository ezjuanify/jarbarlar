<?php
if (!defined('ABSPATH')) exit;
$product_data = $args['product_data'] ?? null;
if (!$product_data) return;
?>

<!-- PRODUCT CARD META -->
<div class="product-card-meta">
    <!-- OPTIONAL: COUNTRY -->
    <?php if (!empty($product_data['flag_url'])): ?>
        <div class="product-country">
            <img class="country-flag"
                    src="<?php echo esc_url($product_data['flag_url']); ?>"
                    alt="<?php echo esc_attr($product_data['country']); ?>"
                    loading="lazy">
        </div>
    <?php endif ?>

    <!-- PRODUCT STOCK -->
    <div class="product-stock <?php echo !empty($product_data['stock']) ? 'in-stock' : 'out-of-stock'; ?>">
        <?php echo !empty($product_data['stock']) ? 'In Stock' : 'Out of Stock'; ?>
    </div>
</div>