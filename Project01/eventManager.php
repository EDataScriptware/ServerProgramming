<?php 

require_once("class/events.class.php");
$event = new Events();
$event->establishConnection();

$managerName = $_SESSION['user'];
$managerID = $_SESSION['userID'];

echo "<title>Event Control Panel</title>";
echo "<h1>Event Manager Control Panel</h1>";
$event->goBackButton();
$event->getAllCreatedEvents($managerID);

?>