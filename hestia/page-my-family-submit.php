<?php

// Include custom functions
include dirname(__FILE__) . '/nmbp/functions.php';
include dirname(__FILE__) . '/nmbp/classes/AddUser.php';

global $wpdb;
$iUserID = get_current_user_id();

// Make sure that they aren't trying to cheat the system.
$sSQL = "SELECT l.* FROM wp_families f 
        LEFT JOIN wp_family_relationships r ON f.id = r.family_id
        LEFT JOIN wp_family_license l ON f.id = l.family_id
        WHERE f.active = 1 AND f.hoh_id = {$iUserID} AND l.available = 1;";
$oResults = $wpdb->get_results($sSQL);
$iLicensesAvailable = count($oResults);
$sResponseClass = '';

// Only proceed if they actually have a license to give
if ($iLicensesAvailable >= 1) {
    $addUser = new AddUser($_POST);
    $sResponse = $addUser->getResponse();
    $bSuccessful = $addUser->getSuccess();
    $sClass = ($bSuccessful) ? 'text-success' : 'text-danger';
} else {
    $sResponse = 'Sorry, you do not have any more available licenses.';
}

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
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="<?php echo $sResponseClass; ?>"><?php echo $sResponse; ?></p>
                        </div>
                    </div>
                    <?php
                endwhile;
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;
            ?>
        </div>
    </div>
    <?php get_footer(); ?>
