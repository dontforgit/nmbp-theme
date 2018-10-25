jQuery(document).ready(function(){

    var $oMinusIcon = jQuery('.dashicons-minus');
    var $oClaimSubmit = jQuery('#claim-submit');
    var $oDropDown = jQuery('.dashicons-arrow-up-alt2');
    var $oAddListButton = jQuery('#add-list-button');
    var iUserID = jQuery('#this_user_id').data('user_id');

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

    $oDropDown.click(function(){
        jQuery(this).parent().next().slideToggle(400);
        jQuery(this).toggleClass('dashicons-arrow-down-alt2').toggleClass('dashicons-arrow-up-alt2');
    });

    $oAddListButton.click(function(){
        jQuery('#add-list-form').show();
        jQuery(this).hide();
    });

});
