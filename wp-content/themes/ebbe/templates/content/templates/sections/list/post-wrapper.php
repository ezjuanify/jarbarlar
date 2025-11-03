<?php
/**
 * @package ebbe
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('ebbe-article-wrapper single-post grid-view col-md-12 list-view '); ?>>
     <?php 
    // Include Post Image    
    get_template_part('templates/content/templates/sections/list/post-image' ); ?>

    <div class="ebbe-article-inner post-details">
        <?php 
        // Include Post Title
        get_template_part('templates/content/templates/sections/list/post-title' );
        // Include Post Informations
        get_template_part('templates/content/templates/sections/list/post-info' );
        // Include Post Excerpt
        get_template_part('templates/content/templates/sections/list/post-excerpt' );
        // Include Post button
        get_template_part('templates/content/templates/sections/list/post-button' );
        // Include Post Page links
        get_template_part('templates/content/templates/sections/list/post-link-pages' ); 
        ?>
    </div>
</article>