<?php
$iUserID = get_current_user_id();
?>

<button type="button" class="btn btn-primary" id="add-list-button" style="display:block;margin:auto;">Add To My Christmas List</button>
<br/>
<div class="row" id="add-list-form">
    <form action="/my-list-submit/" method="post">
        <div class="form-group col-md-6">
            <label for="gift_title">Gift</label>
            <input type="text" class="form-control" id="gift_title" name="gift_title" placeholder="Enter name of the gift">
        </div>
        <div class="form-group col-md-6">
            <label for="gift_link">Link (optional)</label>
            <input type="text" class="form-control" id="gift_link" name="gift_link" placeholder="Link to the gift (if there is one)">
        </div>
        <div class="form-group col-md-4">
            <label for="gift_price">Price</label>
            <input type="text" class="form-control" id="gift_price" name="gift_price" placeholder="Enter price of the gift">
        </div>
        <div class="form-group col-md-4">
            <label for="gift_quantity">Quantity</label>
            <select class="form-control" id="gift_quantity" name="gift_quantity">
                <?php for ($i = 0; $i <= 10; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="gift_desire">Desire (10 = most)</label>
            <select class="form-control" id="gift_desire" name="gift_desire">
                <?php for ($i = 0; $i <= 10; $i++) : ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="gift_notes">Notes for gift</label>
            <textarea class="form-control" id="gift_notes" name="gift_notes" rows="3" placeholder="Enter any notes you want to show. (Size, color, etc.)"></textarea>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $iUserID; ?>" />
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
