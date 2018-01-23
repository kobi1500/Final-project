<?php
/**
 * this page is a service page for the update_tab page.
 * this page is return to update_tab page that card_balance of the customer.
 * the function GetOption($option) is return that card_balance and this page saves her and returns her to update_tab
 * page.
 */
include_once '../database/connection.php';
$db=new connection();
if(isset($_POST['get_option']))
{
 $option = $_POST['get_option'];
$row=$db->GetOption($option);
echo $row;

}
?>
