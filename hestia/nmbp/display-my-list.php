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
                <span class="dashicons dashicons-edit"
                      data-toggle="modal"
                      data-target="#editGiftModal"
                      data-gift_title="<?php echo $oGift->title; ?>"
                      data-gift_price="<?php echo $oGift->price; ?>"
                      data-gift_quantity="<?php echo $oGift->quantity; ?>"
                      data-gift_desire="<?php echo $oGift->desire; ?>"
                      data-gift_link="<?php echo $oGift->link; ?>"
                      data-gift_notes="<?php echo $oGift->notes; ?>"
                      data-gift_id="<?php echo $oGift->id; ?>"
                ></span>&nbsp;
                <span class="dashicons dashicons-dismiss"
                      data-toggle="modal"
                      data-target="#deleteGiftModal"
                      data-gift_id="<?php echo $oGift->id; ?>"
                      data-gift_title="<?php echo $oGift->title; ?>"
                ></span>&nbsp;
                <?php if (trim($oGift->link) !== '') : ?>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteGiftModal" tabindex="-1" role="dialog" aria-labelledby="delete-gift-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Title -->
                <h5 class="modal-title" id="release-gift-modal">Delete Gift: <span id="delete-gift-title"></span></h5>
            </div>

            <div class="modal-body" id="delete-gift-modal-body">
                <p style="color:red;"><strong>You are about to completely remove this gift from your Christmas list.</strong></p>
                <label for="delete-comment">Reason for removing this gift:</label>
                <textarea class="form-control" rows="2" id="delete-comment"></textarea>
                <input type="hidden" name="gift_id" id="delete-gift-gift_id" value="" />
                <input type="hidden" name="base_url" id="delete-gift-base_url" value="<?php echo get_template_directory_uri(); ?>" />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="delete-submit">Release</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editGiftModal" tabindex="-1" role="dialog" aria-labelledby="edit-gift-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Title -->
                <h5 class="modal-title" id="release-gift-modal">Edit Gift: <span id="edit-gift-title"></span></h5>
            </div>

            <div class="modal-body" id="edit-gift-modal-body">
                <div class="form-group col-md-6">
                    <label for="edit-gift_title">Gift</label>
                    <input type="text" class="form-control" id="edit-gift_title" name="edit-gift_title">
                </div>
                <div class="form-group col-md-6">
                    <label for="edit-gift_price">Price</label>
                    <input type="text" class="form-control" id="edit-gift_price" name="edit-gift_price">
                </div>
                <div class="form-group col-md-6">
                    <label for="edit-gift_quantity">Quantity</label>
                    <select class="form-control" id="edit-gift_quantity" name="edit-gift_quantity">
                        <?php for ($i = 0; $i <= 10; $i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="edit-gift_desire">Desire (10 = most)</label>
                    <select class="form-control" id="edit-gift_desire" name="edit-gift_desire">
                        <?php for ($i = 0; $i <= 10; $i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label for="edit-gift_link">Link (optional)</label>
                    <input type="text" class="form-control" id="edit-gift_link" name="edit-gift_link">
                </div>
                <div class="form-group col-md-12">
                    <label for="edit-gift_notes">Notes for gift</label>
                    <textarea class="form-control" id="edit-gift_notes" name="edit-gift_notes" rows="3"></textarea>
                </div>
                <input type="hidden" name="gift_id" id="edit-gift-gift_id" value="" />
                <input type="hidden" name="base_url" id="edit-gift-base_url" value="<?php echo get_template_directory_uri(); ?>" />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit-submit">Edit</button>
            </div>
        </div>
    </div>
</div>
