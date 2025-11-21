<?php
if (!defined('ABSPATH')) exit;
$product_data = $args['product_data'] ?? null;
if (!$product_data) return;
?>

<!-- PRODUCT CARD CONTENT -->
<div class="product-card-content">
    <!-- TITLE -->
    <h2 class="product-title">
        <a href="<?php echo esc_url($product_data['url']); ?>">
            <?php echo esc_html($product_data['title']); ?>
        </a>
    </h2>
</div>
