<?php 
require_once("class/attendee.class.php");
$attendee = new Attendee();
$attendee->establishConnection();
$userID = $_SESSION['userID'];

$attendee->goBackButton();
$attendee->getAllSessions($userID);
$attendee->getAllEvents($userID);



?>