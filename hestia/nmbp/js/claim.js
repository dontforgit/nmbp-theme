jQuery(document).ready(function(){

    var $oPlusIcons = jQuery('.dashicons-plus');
    var $oDropDown = jQuery('.dashicons-arrow-up-alt2');
    var $oClaimSubmit = jQuery('#claim-submit');
    var iUserID = jQuery('#this_user_is').data('user_id');

    $oPlusIcons.click(function(){
        var iRemaining = jQuery(this).data('remaining');
        var sTitle = jQuery(this).data('title');
        var iGiftID = jQuery(this).data('gift_id');
        var sOptionHTML = '';
        for (var i = iRemaining; i >= 0; i--) {
            sOptionHTML += '<option value="' + i + '">' + i + '</option>';
        }

        jQuery('#claim-gift_quantity').html(sOptionHTML);
        jQuery('#claim-gift-title').html(sTitle);
        jQuery('#claim-gift-gift_id').val(iGiftID);
    });

    $oClaimSubmit.click(function(){

        var data = {
            "user_id" : iUserID,
            "gift_id" : jQuery('#claim-gift-gift_id').val(),
            "quantity" : jQuery('#claim-gift_quantity').val(),
            "action" : "claimGift"
        };

        jQuery.post( "<?php echo get_template_directory_uri(); ?>/nmbp/ajax.php", data, function(data){
            var sHTML = '<p>' + data + '.. This page will refresh in 10 seconds.';
            sHTML += '<br/><br/> -OR- <br/><br/>';
            sHTML += '<a href="/christmas-list/">REFRESH NOW!</a></p>';

            jQuery('#claim-gift-modal-body').html(sHTML);
            setTimeout(function(){
                location.reload();
            }, 10000);
        });
    });

    $oDropDown.click(function(){
        jQuery(this).parent().next().slideToggle(400);
        jQuery(this).toggleClass('dashicons-arrow-down-alt2').toggleClass('dashicons-arrow-up-alt2');
    });

});
