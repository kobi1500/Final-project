<?php

/**
 * this page is a service page for the subscription_update page.
 * this page is return to subscription_update page that name of the customer.
 * the function GetOptionSubscribers($option) is return that name and this page saves her and returns her to subscription_update
 * page.
 */
include_once '../database/connection.php';
$db = new connection();
if (isset($_POST['get_option'])) {
    $option = $_POST['get_option'];
    $row = $db->GetOptionSubscribers($option);
    echo $row;
}
?>

