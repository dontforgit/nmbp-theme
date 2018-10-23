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
$sSQL = "SELECT c.*, g.link, g.price, g.title as 'gift', g.notes, u.*
        FROM wp_claimed c
        LEFT JOIN wp_gift g on c.gift_id = g.id
        LEFT JOIN wp_users u on g.user_id = u.ID
        WHERE c.user_id = {$iUserID} AND c.active = 1;";
$aResults = $wpdb->get_results($sSQL);

// Format gifts
$aGifts = array();
foreach ($aResults as $oGift) {
    $aGifts[$oGift->display_name][$oGift->id] = $oGift;
}

?>
    <div class="row">
        <div class="col-md-4"><p><strong>Gift</strong></p></div>
        <div class="col-md-1"><p><strong>Price</strong></p></div>
        <div class="col-md-1"><p><strong>Desire</strong></p></div>
        <div class="col-md-1"><p><strong>Quantity</strong></p></div>
        <div class="col-md-5"><p><strong>Notes</strong></p></div>
    </div>
<?php

foreach ($aGifts as $sFamilyMember => $aGiftList) : ?>
    <h3><?php echo $sFamilyMember; ?></h3>
    <?php foreach ($aGiftList as $iClaimedID => $oClaimedGift) : ?>
        <div class="row individual-gift">
            <div class="col-md-4">
                <p>
                    <span class="dashicons dashicons-minus"
                          data-toggle="modal"
                          data-target="#exampleModal"
                          data-claimed_id="<?php echo $oClaimedGift->id; ?>"
                          data-gift_id="<?php echo $oClaimedGift->gift_id; ?>"
                          data-title="<?php echo $oClaimedGift->gift; ?>"
                          data-quantity="<?php echo $oClaimedGift->quantity; ?>"
                    ></span>&nbsp;

                    <?php if (isset($oClaimedGift->link) && trim($oClaimedGift->link) !== '' && substr($oClaimedGift->link, 0, 4) === 'http') : ?>
                        <a href="<?php echo $oClaimedGift->link; ?>" target="_blank">
                            <?php echo $oClaimedGift->gift; ?>
                        </a>
                    <?php else : ?>
                        <?php echo $oClaimedGift->gift; ?>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-md-1"><p><?php echo $oClaimedGift->price; ?></p></div>
            <div class="col-md-1"><p><?php echo $oClaimedGift->desire; ?></p></div>
            <div class="col-md-5"><p><?php echo $oClaimedGift->notes; ?></p></div>
            <div class="col-md-1"><p><?php echo $oClaimedGift->quantity; ?></p></div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

<!-- Modal -->
<?php // @todo: Change the id ?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="release-gift-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Title -->
                <h5 class="modal-title" id="release-gift-modal">Release Gift: <span id="release-gift-title"></span></h5>
            </div>

            <div class="modal-body" id="release-gift-modal-body">
                <label for="release-gift_quantity">Quantity</label>
                <select class="form-control" id="release-gift_quantity" name="release-gift_quantity"></select>
                <input type="hidden" name="user_id" value="<?php echo $iUserID; ?>" />
                <input type="hidden" name="gift_id" id="release-gift-gift_id" value="" />
                <input type="hidden" name="claim_id" id="release-gift-claimed_id" value="" />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="claim-submit">Release</button>
            </div>
        </div>
    </div>
</div>

<script tyle="text/javascript">
    jQuery(document).ready(function(){

        var $oMinusIcon = jQuery('.dashicons-minus');
        var $oClaimSubmit = jQuery('#claim-submit');
        var iUserID = <?php echo $iUserID; ?>

            $oMinusIcon.click(function(){
                var iRemaining = jQuery(this).data('quantity');
                var sTitle = jQuery(this).data('title');
                var iGiftID = jQuery(this).data('gift_id');
                var iClaimedID = jQuery(this).data('claimed_id');
                var sOptionHTML = '';
                for (var i = iRemaining; i >= 0; i--) {
                    sOptionHTML += '<option value="' + i + '">' + i + '</option>';
                }

                jQuery('#release-gift_quantity').html(sOptionHTML);
                jQuery('#release-gift-title').html(sTitle);
                jQuery('#release-gift-gift_id').val(iGiftID);
                jQuery('#release-gift-claimed_id').val(iClaimedID);
            });

        $oClaimSubmit.click(function(){

            var data = {
                "user_id" : iUserID,
                "gift_id" : jQuery('#release-gift-gift_id').val(),
                "claimed_id" : jQuery('#release-gift-claimed_id').val(),
                "quantity" : jQuery('#release-gift_quantity').val(),
                "action" : "releaseGift"
            };

            jQuery.post( "<?php echo get_template_directory_uri(); ?>/nmbp/ajax.php", data, function(data){
                var sHTML = '<p>' + data + '.. This page will refresh in 10 seconds.';
                sHTML += '<br/><br/> -OR- <br/><br/>';
                sHTML += '<a href="/christmas-list/">REFRESH NOW!</a></p>';

                jQuery('#release-gift-modal-body').html(sHTML);
                setTimeout(function(){
                    location.reload();
                }, 10000);
            });
        });

    });
</script>

<style>
    .individual-gift span.dashicons-minus {
        color: red;
    }
    .individual-gift span.dashicons-minus:hover {
        cursor: pointer;
    }
</style>
