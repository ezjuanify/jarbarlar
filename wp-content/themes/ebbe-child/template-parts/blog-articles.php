<?php
/**
 * Template: Blog Articles
 */

if (!defined('ABSPATH')) exit;

$post_id   = get_the_ID();
$title     = get_the_title();
$excerpt   = get_the_excerpt();
$date      = get_the_date();
$author    = get_the_author();
$image     = get_the_post_thumbnail($post_id, 'medium', ['class' => 'blog-article-image']);
$permalink = get_permalink();
?>

<div class="blog-article">
    <a href="<?php echo esc_url($permalink); ?>">
        <?php echo $image; ?>
        <h3 class="blog-article-title">
            <?php echo esc_html($title); ?>
        </h3>
    </a>
    <p class="blog-article-excerpt">
        <?php echo esc_html($excerpt); ?>
    </p>
    <div class="blog-article-meta">
        <span class="blog-article-data">
            <?php echo esc_html($date); ?>
        </span>
        <span class="blog-article-author">
            By <?php echo esc_html($author); ?>
        </span>
    </div>
    <a class="blog-article-read-more" href="<?php echo esc_url($permalink); ?>">
        Read More
    </a>
</div>