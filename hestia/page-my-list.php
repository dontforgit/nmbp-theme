<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

// Include custom functions
include dirname(__FILE__) . '/nmbp/functions.php';

get_header();

do_action( 'hestia_before_single_page_wrapper' );

?>
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
                    get_template_part( 'nmbp/add-to-my-list' );
                    get_template_part( 'nmbp/display-my-list' );
                endwhile;
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;
            ?>
        </div>
    </div>
    <?php get_footer(); ?>
