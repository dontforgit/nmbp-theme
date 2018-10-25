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
<h2>My Christmas List</h2>
<div class="my-gift-container">
    <div class="row table-heading">
        <div class="col-md-4 hidden-sm hidden-xs"><p><strong>Gift</strong></p></div>
        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>Price</strong></p></div>
        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>Desire</strong></p></div>
        <div class="col-md-1 hidden-sm hidden-xs"><p><strong># Left</strong></p></div>
        <div class="col-md-5 hidden-sm hidden-xs"><p><strong>Notes</strong></p></div>
    </div>
<?php

foreach ($aResults as $oGift) : ?>

    <div class="row individual-gift">
        <div class="col-md-4">
            <p>
                <span class="visible-sm visible-xs" style="font-weight:bold;">Gift: </span>
                <a href="<?php echo $oGift->link; ?>" target="_blank">
                    <?php echo $oGift->title; ?>
                </a>
            </p>
        </div>
        <div class="col-md-1">
            <p>
                <span class="visible-sm visible-xs" style="font-weight:bold;">Price: </span>
                <?php echo $oGift->price; ?>
            </p>
        </div>
        <div class="col-md-1">
            <p>
                <span class="visible-sm visible-xs" style="font-weight:bold;">Desire: </span>
                <?php echo $oGift->desire; ?>
            </p>
        </div>
        <div class="col-md-1">
            <p>
                <span class="visible-sm visible-xs" style="font-weight:bold;">Quantity: </span>
                <?php echo $oGift->quantity; ?>
            </p>
        </div>
        <div class="col-md-5">
            <p>
                <span class="visible-sm visible-xs" style="font-weight:bold;">Notes: </span>
                <?php echo $oGift->notes; ?>
            </p>
        </div>
    </div>

<?php endforeach; ?>
</div>
