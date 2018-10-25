<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

// Queue up scripts and styles for later
// @todo: Remove the cache buest from the stylesheet
wp_enqueue_script('claim-gift', get_template_directory_uri() . '/nmbp/js/claim.js', array('jquery'), date('YmdHis'));
wp_enqueue_style('common-css', get_template_directory_uri() . '/nmbp/css/common.css', false, date('YmdHis'));

get_header();

do_action( 'hestia_before_single_page_wrapper' );

?>
<div id="this_user_is" data-user_id="<?php echo get_current_user_id(); ?>"
<div class="<?php echo hestia_layout(); ?>">
    <?php
    $class_to_add = '';
    if ( class_exists( 'WooCommerce' ) && ! is_cart() ) {
        $class_to_add = 'blog-post-wrapper';
    }
    ?>
    <div class="blog-post <?php esc_attr( $class_to_add ); ?>">
        <div class="container">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', 'page' );
                    get_template_part( 'nmbp/home' );
                endwhile;
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;
            ?>
        </div>
    </div>
    <?php get_footer(); ?>
