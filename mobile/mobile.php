<?php
include_once '../database/connection.php';
$db = new connection();

if (isset($_GET['func'])) {
    switch ($_GET['func']) {
       
        case 'login':
            $db->Login($_GET['user'], $_GET['password']);
            break;
        case 'resetpassword':
            $db->ResetPassword($_GET['email']);
            break;
        case 'getcustomerdetails':
            $db->GetCustomerDetails($_GET['id']);
            break;
        case 'getlesson':
            $db->GetLesson($_GET['day']);
            break;
        case 'updatecustomers':
            $db->UpdateCustomers($_GET['id'], $_GET['email'], $_GET['password'], $_GET['height'], $_GET['weight']);
            break;
        case 'getnotificationbyid':
            $db->GetNotifcationByIdCustomer($_GET['id']);
            break;
    }
}

?>
