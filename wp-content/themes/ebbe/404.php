<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package ebbe
 */

get_header(); 

do_action( 'ebbe_before_main_content' );
?>

<!-- Page content -->
<div id="primary" class="content-area">
    <div class="container high-padding site-main">
        <div class="col-md-12 main-content">
            <section class="error-404 not-found">
                <div class="page-content">
                    <?php #Image ?>
                    <?php
                    $image = ebbe()->get_setting( 'ebbe_not_found_404_img' );
                    if (is_array($image) && $image['url']) { ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr__('Not Found','ebbe'); ?>">
                    <?php } else { ?> 
                        <h1 class="text-center"><?php esc_html_e( '404', 'ebbe' ); ?></h1>
                    <?php } ?>

                    <?php #Heading ?>
                    <?php if(ebbe()->get_setting( 'ebbe_page_404_heading' )){ ?>
                        <h2 class="text-center"><?php echo esc_html( ebbe()->get_setting( 'ebbe_page_404_heading' )); ?></h2>
                    <?php }else{ ?>
                        <h2 class="text-center"><?php esc_html_e( 'Sorry, this page does not exist!', 'ebbe' ); ?></h2>
                    <?php } ?>

                    <?php #Sub-heading (Paragraph) ?>
                    <?php if(ebbe()->get_setting( 'ebbe_page_404_paragraph' )){ ?>
                        <p class="text-center"><?php echo esc_html( ebbe()->get_setting( 'ebbe_page_404_paragraph' )); ?></p>
                    <?php }else{ ?>
                        <p class="text-center"><?php esc_html_e( 'The link you clicked might be corrupted, or the page may have been removed.', 'ebbe' ); ?></p>
                    <?php } ?>

                    <?php #Button ?>
                    <a class="vc_button_404" href="<?php echo esc_url(get_site_url()); ?>"><?php esc_html_e( 'Back to Home', 'ebbe' ); ?></a>
                </div>
            </section>
        </div>
    </div>
</div>

<?php 
do_action( 'ebbe_after_main_content' );

get_footer();