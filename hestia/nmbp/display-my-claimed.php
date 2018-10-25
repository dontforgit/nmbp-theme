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
?>
<h2>Gifts I've Claimed</h2>
<?php
// Format gifts
$aGifts = array();
foreach ($aResults as $oGift) {
    $aGifts[$oGift->display_name][$oGift->id] = $oGift;
}

foreach ($aGifts as $sFamilyMember => $aGiftList) : ?>
    <h4 class="family-member-name">
        <span class="dashicons dashicons-arrow-up-alt2"></span>
        <?php echo $sFamilyMember; ?>
    </h4>

    <div class="family-member-gift-container">

    <div class="row table-heading">
        <div class="col-md-4 hidden-sm hidden-xs"><p><strong>Gift</strong></p></div>
        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>Price</strong></p></div>
        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>Desire</strong></p></div>
        <div class="col-md-5 hidden-sm hidden-xs"><p><strong>Notes</strong></p></div>
        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>#</strong></p></div>
    </div>

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
    </div>
<?php endforeach; ?>

<!-- Modal -->
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
