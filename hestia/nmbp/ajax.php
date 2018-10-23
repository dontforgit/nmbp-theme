<?php

include dirname(__FILE__) . '/../../../../wp-load.php';
include dirname(__FILE__) . '/functions.php';

switch ($_POST['action']) {

    case 'claimGift' :
        claimGift($_POST);
        break;

    case 'releaseGift' :
        releaseGift($_POST);
        break;

    default :
        // do nothing
        break;

}

function claimGift($aPost)
{
    $bContinue = helperArrayHasAllKeys($aPost, array('gift_id', 'user_id', 'quantity'));

    if ($bContinue === false) {
        returnJson("Error: The required fields were not set correctly.");
    }

    // set easy vars
    $user_id = $aPost['user_id'];
    $gift_id = $aPost['gift_id'];
    $quantity = $aPost['quantity'];

    $iQuantityRemaining = getQuantityRemaining($gift_id);
    if ($iQuantityRemaining >= $quantity) {
        $iUpdatedQuantity = ($iQuantityRemaining - $quantity);
        addClaim($user_id, $gift_id, $quantity);
        updateQuantityRemaining($gift_id, $iUpdatedQuantity);
        returnJson('Success: You have successfully claimed this gift. Please refresh the page.');
    } else {
        returnJson('Error: The quantity you are trying to claim is more than the quantity remaining. Try refreshing the page.');
    }

}

function releaseGift($aPost)
{
    $bContinue = helperArrayHasAllKeys($aPost, array('gift_id', 'claimed_id', 'user_id', 'quantity'));
    if ($bContinue === false) {
        returnJson("Error: The required fields were not set correctly.");
    }

    // set easy vars
    $user_id = $aPost['user_id'];
    $gift_id = $aPost['gift_id'];
    $claimed_id = $aPost['claimed_id'];
    $quantity = $aPost['quantity'];

    $iQuantityRemaining = getQuantityRemaining($gift_id);
    $iUpdatedQuantity = ($iQuantityRemaining + $quantity);
    releaseClaim($claimed_id);

    // If we did not release ALL the gifts we claimed
    $iHadClaimed = getQuantityClaimedByID($claimed_id);
    if ($iHadClaimed !== $quantity) {
        $newQuantity = ($iHadClaimed - $quantity);
        addClaim($user_id, $gift_id, $newQuantity);
    }

    updateQuantityRemaining($gift_id, $iUpdatedQuantity);
    returnJson('Success: You have released this gift.');
}

function addClaim($user_id, $gift_id, $quantity)
{
    global $wpdb;
    $data = array(
        'user_id' => $user_id,
        'gift_id' => $gift_id,
        'quantity' => $quantity,
    );
    $wpdb->insert('wp_claimed', $data);
}

function releaseClaim($claimed_id)
{
    global $wpdb;
    $data = array('active' => 0);
    $where = array('id' => $claimed_id);
    $wpdb->update('wp_claimed', $data, $where);
}

function getQuantityRemaining($gift_id)
{
    global $wpdb;
    $sSQL = "SELECT * FROM wp_gift WHERE id = {$gift_id};";
    $aResult = $wpdb->get_results($sSQL);
    if (isset($aResult[0]->remaining)) {
        return $aResult[0]->remaining;
    }
    return 0;
}

function getQuantityClaimedByID($claimed_id)
{
    global $wpdb;
    $sSQL = "SELECT * FROM wp_claimed WHERE id = {$claimed_id};";
    $aResult = $wpdb->get_results($sSQL);
    if (isset($aResult[0]->quantity)) {
        return $aResult[0]->quantity;
    }
    return 0;
}

function updateQuantityRemaining($gift_id, $iQuantityRemaining)
{
    global $wpdb;
    $data = array('remaining' => $iQuantityRemaining);
    $where = array('id' => $gift_id);
    $wpdb->update('wp_gift', $data, $where);
}

function helperArrayHasAllKeys($array, $aExpectedKeys)
{
    foreach ($aExpectedKeys as $sExpectedKey) {
        if (!isset($array[$sExpectedKey]) || trim($array[$sExpectedKey]) === '') {
            return false;
        }
    }
    return true;
}

function returnJson($sMessage)
{
    echo json_encode($sMessage);
    die;
}
