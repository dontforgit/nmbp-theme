<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

// Include custom functions
include dirname(__FILE__) . '/nmbp/functions.php';

// Queue up scripts and styles for later
wp_enqueue_script('claim-gift', get_template_directory_uri() . '/nmbp/js/release.js', array('jquery'));
wp_enqueue_style('common-css', get_template_directory_uri() . '/nmbp/css/common.css');

get_header();

do_action( 'hestia_before_single_page_wrapper' );

?>
<div id="this_user_is" data-user_id="<?php echo get_current_user_id();?>"></div>
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
            if (!is_user_logged_in()) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Please log in to view this page: </h3>
                        <?php wp_login_form(); ?>
                    </div>
                </div>
                <?php
            } else {
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', 'page');
                        get_template_part('nmbp/add-to-my-list');
                        get_template_part('nmbp/display-my-list');
                        get_template_part('nmbp/display-my-claimed');
                    endwhile;
                else :
                    get_template_part('template-parts/content', 'none');
                endif;
            }
            ?>
        </div>
    </div>
    <?php get_footer(); ?>
