<?php

$data = array(
    'user_id' => $_POST['user_id'],
    'quantity' => $_POST['gift_quantity'],
    'desire' => $_POST['gift_desire'],
    'link' => $_POST['gift_link'],
    'price' => $_POST['gift_price'],
    'title' => $_POST['gift_title'],
    'notes' => $_POST['gift_notes'],
    'remaining' => $_POST['gift_quantity'],
    'active' => 1,
);

global $wpdb;
$wpdb->insert('wp_gift', $data);

header('Location: /my-list/');
