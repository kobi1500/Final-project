<?php
/**
 *This class activates the function of deleting the event from the calendar.
 */
  include_once '../database/connection.php';
  $db=new connection();
  
switch ($_GET['func'])
{
case "deleteevent":
    $db->DeleteEvents($_GET['id']);
    $db->Redirect("deleteEvent.php");
    break;
}

