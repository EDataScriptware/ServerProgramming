<?php 

require_once("class/events.class.php");
$event = new Events();
$event->establishConnection();

$managerName = $_SESSION['user'];
$managerID = $_SESSION['userID'];

echo "<title>Event Control Panel</title>";


echo '<head><style>';
include 'css/info.css';
echo '</style></head>';
echo "<div class='stickytop'>";
echo "<h1>Event Manager Control Panel</h1>";
$event->goBackButton();
echo "</div>";
$event->getAllCreatedEvents($managerID);

echo "<form method='POST'> <button type='submit' name='LogOut' class='backButton'>Log Out</button></form>";
if (isset($_POST['LogOut']))
{
    session_destroy();
    header("location: login.php");
}
?>