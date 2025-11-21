<?php
/**
 * Template: Product Item
 */

if (!defined('ABSPATH')) exit;

$product_data = $args['product_data'] ?? null;
if (!$product_data) return;
?>

<div class="product-card">

    <!-- PRODUCT CARD IMAGE -->
    <div class="product-card-image">
        <a href="<?php echo esc_url($product_data['url']); ?>">
            <?php echo $product_data['thumbnail']; ?>
        </a>
    </div>
    
    <!-- PRODUCT CARD INFO -->
    <div class="product-card-info">
        <?php
        get_template_part('template-parts/components/product-card-meta', null, ['product_data' => $product_data]);
        get_template_part('template-parts/components/product-card-content', null, ['product_data' => $product_data]);
        get_template_part('template-parts/components/product-card-footer', null, ['product_data' => $product_data]);
        ?>
    </div>
</div>
