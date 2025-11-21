<?php
/**
 * Template: Collection Header
 */

if (!defined('ABSPATH')) exit;

$meta_data = $args['meta_data'] ?? null;
if (!$meta_data) return;

$term = $meta_data['term'] ?? null;
$img  = $meta_data['collection_image_url'] ?? '';
$url  = $meta_data['collection_url'] ?? '';
?>

<div class="collection-header">
    <?php if ($img): ?>
        <img class="collection-image"
             src="<?php echo esc_url($img); ?>"
             alt="<?php echo esc_attr($term ? $term->name : ''); ?>">
    <?php endif; ?>

    <?php if ($term): ?>
        <h2 class="collection-title">
            <?php echo esc_html($term->name); ?>
        </h2>
    <?php endif; ?>

    <?php if ($url): ?>
        <a class="collection-link"
           href="<?php echo esc_url($url); ?>">
           View All
        </a>
    <?php endif; ?>
</div>
