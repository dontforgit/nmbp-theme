<?php

require_once dirname(__FILE__) . '/functions.php';
require_once dirname(__FILE__) . '/classes/GiftList.php';

$oGifts = new GiftList();
$aGifts = $oGifts->getGifts();
// @todo: Block out the quantity remaining for you.
?>

<?php foreach ($aGifts as $sFamilyName => $aFamilyMembers) : ?>

    <div class="row">
        <!-- Family Group -->
        <h3><?php echo $sFamilyName ?></h3>

        <!-- Person -->
        <?php foreach ($aFamilyMembers as $sFamilyMemberName => $aGiftList) : ?>
            <h4><?php echo $sFamilyMemberName; ?></h4>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4"><p><strong>Gift</strong></p></div>
                    <div class="col-md-1"><p><strong>Price</strong></p></div>
                    <div class="col-md-1"><p><strong>Desire</strong></p></div>
                    <div class="col-md-1"><p><strong># Left</strong></p></div>
                    <div class="col-md-5"><p><strong>Notes</strong></p></div>
                </div>

                <!-- Single Gift -->
                <?php foreach ($aGiftList as $oGift) : ?>
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
                        <div class="col-md-1"><p><?php echo $oGift->remaining; ?></p></div>
                        <div class="col-md-5"><p><?php echo $oGift->notes; ?></p></div>
                    </div>
                <?php endforeach; ?>

            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach;
