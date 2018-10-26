jQuery(document).ready(function(){

    var $oMinusIcon = jQuery('.dashicons-minus');
    var $oEditIcon = jQuery('.dashicons-edit');
    var $oEditSubmit = jQuery('#edit-submit');
    var $oReleaseSubmit = jQuery('#release-submit');
    var $oDropDown = jQuery('.dashicons-arrow-up-alt2');
    var $oAddListButton = jQuery('#add-list-button');
    var $oDismiss = jQuery('.dashicons-dismiss');
    var $oDeleteSubmit = jQuery('#delete-submit');
    var iUserID = jQuery('#this_user_id').data('user_id');

    $oEditIcon.click(function(){
        var iGiftID = jQuery(this).data('gift_id');
        var sTitle = jQuery(this).data('gift_title');
        var iPrice = jQuery(this).data('gift_price');
        var sLink = jQuery(this).data('gift_link');
        var sNotes = jQuery(this).data('gift_notes');
        var iQuantity = jQuery(this).data('gift_quantity');
        var iDesire = jQuery(this).data('gift_desire');

        jQuery('#edit-gift-gift_id').val(iGiftID);
        jQuery('#edit-gift-title').html(sTitle);
        jQuery('#edit-gift_title').val(sTitle);
        jQuery('#edit-gift_price').val(iPrice);
        jQuery('#edit-gift_link').val(sLink);
        jQuery('#edit-gift_notes').val(sNotes);
        jQuery('#edit-gift_quantity').val(iQuantity);
        jQuery('#edit-gift_desire').val(iDesire);
    });

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

    $oEditSubmit.click(function(){
        var sBaseURL = jQuery('#edit-gift-base_url').val();
        var data = {
            "gift_id" : jQuery('#edit-gift-gift_id').val(),
            "gift_title" : jQuery('#edit-gift_title').val(),
            "gift_price" : jQuery('#edit-gift_price').val(),
            "gift_link" : jQuery('#edit-gift_link').val(),
            "gift_notes" : jQuery('#edit-gift_notes').val(),
            "gift_quantity" : jQuery('#edit-gift_quantity').val(),
            "gift_desire" : jQuery('#edit-gift_desire').val(),
            "action" : "editGift"
        };

        jQuery.post(sBaseURL + "/nmbp/ajax.php", data, function(data){
            var sHTML = '<p>' + data + '.. This page will refresh in 10 seconds.';
            sHTML += '<br/><br/> -OR- <br/><br/>';
            sHTML += '<a href="/my-list/">REFRESH NOW!</a></p>';

            jQuery('#edit-gift-modal-body').html(sHTML);
            setTimeout(function(){
                location.reload();
            }, 10000);
        });
    });

    $oReleaseSubmit.click(function(){

        var data = {
            "user_id" : iUserID,
            "gift_id" : jQuery('#release-gift-gift_id').val(),
            "claimed_id" : jQuery('#release-gift-claimed_id').val(),
            "quantity" : jQuery('#release-gift_quantity').val(),
            "action" : "releaseGift"
        };
        var sBaseURL = jQuery('#delete-gift-base_url').val();

        jQuery.post( sBaseURL + "/nmbp/ajax.php", data, function(data){
            var sHTML = '<p>' + data + '.. This page will refresh in 10 seconds.';
            sHTML += '<br/><br/> -OR- <br/><br/>';
            sHTML += '<a href="/my-list/">REFRESH NOW!</a></p>';

            jQuery('#release-gift-modal-body').html(sHTML);
            setTimeout(function(){
                location.reload();
            }, 10000);
        });
    });

    $oDeleteSubmit.click(function(){

        var data = {
            "gift_id" : jQuery('#delete-gift-gift_id').val(),
            "comment" : jQuery('#delete-comment').val(),
            "action" : "deleteGift"
        };
        var sBaseURL = jQuery('#delete-gift-base_url').val();

        jQuery.post(sBaseURL + '/nmbp/ajax.php', data, function(data){
            var sHTML = '<p>' + data + '.. This page will refresh in 10 seconds.';
            sHTML += '<br/><br/> -OR- <br/><br/>';
            sHTML += '<a href="/my-list/">REFRESH NOW!</a></p>';

            jQuery('#delete-gift-modal-body').html(sHTML);
            setTimeout(function(){
                location.reload();
            }, 10000);
        });

    });

    $oDropDown.click(function(){
        jQuery(this).parent().next().slideToggle(400);
        jQuery(this).toggleClass('dashicons-arrow-down-alt2').toggleClass('dashicons-arrow-up-alt2');
    });

    $oAddListButton.click(function(){
        jQuery('#add-list-form').show();
        jQuery(this).hide();
    });

    $oDismiss.click(function(){
        var iGiftID = jQuery(this).data('gift_id');
        var sGiftTitle = jQuery(this).data('gift_title');

        jQuery('#delete-gift-title').html(sGiftTitle);
        jQuery('#delete-gift-gift_id').val(iGiftID);
    });

});
