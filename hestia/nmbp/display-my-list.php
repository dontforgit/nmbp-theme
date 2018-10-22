<?php
/**
 * Created by PhpStorm.
 * User: joshuabryant
 * Date: 10/19/18
 * Time: 9:34 PM
 */

// Setup
global $wpdb;
$iUserID = get_current_user_id();

// Get my gifts, thx
$sSQL = "SELECT * FROM wp_gift g
        WHERE g.user_id = {$iUserID} AND g.active = 1;";
$aResults = $wpdb->get_results($sSQL);

?>
    <div class="row">
        <div class="col-md-4"><p><strong>Gift</strong></p></div>
        <div class="col-md-1"><p><strong>Price</strong></p></div>
        <div class="col-md-1"><p><strong>Desire</strong></p></div>
        <div class="col-md-1"><p><strong>#</strong></p></div>
        <div class="col-md-5"><p><strong>Notes</strong></p></div>
    </div>
<?php

foreach ($aResults as $oGift) : ?>

    <div class="row">
        <div class="col-md-4">
            <p>
                <a href="<?php echo $oGift->link; ?>" target="_blank">
                    <?php echo $oGift->title; ?>
                </a>
            </p>
        </div>
        <div class="col-md-1"><p><?php echo $oGift->price; ?></p></div>
        <div class="col-md-1"><p><?php echo $oGift->desire; ?></p></div>
        <div class="col-md-1"><p><?php echo $oGift->quantity; ?></p></div>
        <div class="col-md-5"><p><?php echo $oGift->notes; ?></p></div>
    </div>

<?php
endforeach;
