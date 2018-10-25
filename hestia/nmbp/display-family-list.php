<?php

require_once dirname(__FILE__) . '/functions.php';
require_once dirname(__FILE__) . '/classes/GiftList.php';

$oGifts = new GiftList();
$aGifts = $oGifts->getGifts();
$iUserID = get_current_user_id();
?>

<?php foreach ($aGifts as $sFamilyName => $aFamilyMembers) : ?>

    <div class="row">
        <!-- Family Group -->
        <h3 class="family-name"><?php echo $sFamilyName ?></h3>

        <!-- Person -->
        <?php foreach ($aFamilyMembers as $sFamilyMemberName => $aGiftList) : ?>
            <?php
            $iFirstArrayKey = key($aGiftList);
            if ($aGiftList[$iFirstArrayKey]->user_id != $iUserID) : ?>

                <h4 class="family-member-name">
                    <?php // @todo Dashicons-yes on having purchased something ?>
                    <span class="dashicons dashicons-arrow-up-alt2"></span>
                    <?php echo $sFamilyMemberName; ?>'s Christmas List
                </h4>
                <div class="col-md-12 family-member-gift-container">
                    <div class="row table-heading">
                        <div class="col-md-4 hidden-sm hidden-xs"><p><strong>Gift</strong></p></div>
                        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>Price</strong></p></div>
                        <div class="col-md-1 hidden-sm hidden-xs"><p><strong>Desire</strong></p></div>
                        <div class="col-md-1 hidden-sm hidden-xs"><p><strong># Left</strong></p></div>
                        <div class="col-md-5 hidden-sm hidden-xs"><p><strong>Notes</strong></p></div>
                    </div>

                    <!-- Single Gift -->
                    <?php foreach ($aGiftList as $oGift) : ?>
                        <div class="row individual-gift">
                            <div class="col-md-4">
                                <p>
                                    <span class="visible-sm visible-xs" style="font-weight:bold;">Gift: </span>
                                    <?php if ($oGift->remaining > 0) : ?>
                                        <span class="dashicons dashicons-plus"
                                              data-toggle="modal"
                                              data-target="#exampleModal"
                                              data-gift_id="<?php echo $oGift->id; ?>"
                                              data-title="<?php echo $oGift->title; ?>"
                                              data-remaining="<?php echo $oGift->remaining; ?>"
                                        ></span>&nbsp;
                                    <?php else : ?>
                                        <span class="dashicons dashicons-lock"></span>&nbsp;
                                    <?php endif; ?>


                                    <?php if (isset($oGift->link) && trim($oGift->link) !== '' && substr($oGift->link, 0, 4) === 'http') : ?>
                                        <a href="<?php echo $oGift->link; ?>" target="_blank">
                                            <?php echo $oGift->title; ?>
                                        </a>
                                    <?php else : ?>
                                        <?php echo $oGift->title; ?>
                                    <?php endif; ?>
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
                                    <span class="visible-sm visible-xs" style="font-weight:bold;">Remaining: </span>
                                    <?php echo $oGift->remaining; ?>
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
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="claim-gift-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Title -->
                <h5 class="modal-title" id="claim-gift-modal">Claim Gift: <span id="claim-gift-title"></span></h5>
            </div>

            <div class="modal-body" id="claim-gift-modal-body">
                <label for="claim-gift_quantity">Quantity</label>
                <select class="form-control" id="claim-gift_quantity" name="claim-gift_quantity"></select>
                <input type="hidden" name="user_id" value="<?php echo $iUserID; ?>" />
                <input type="hidden" name="gift_id" id="claim-gift-gift_id" value="" />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="claim-submit">Save changes</button>
            </div>
        </div>
    </div>
</div>
