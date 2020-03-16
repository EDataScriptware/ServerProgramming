<?php 
require_once("class/attendee.class.php");
$attendee = new Attendee();
$attendee->establishConnection();
$userID = $_SESSION['userID'];

$attendee->goBackButton();
$attendee->getAllSessions($userID);
$attendee->getAllEvents($userID);

echo "<form method='POST'> <button type='submit' name='LogOut' >Log Out</button></form>";
if (isset($_POST['LogOut']))
{
    session_destroy();
    header("location: login.php");
}



?>