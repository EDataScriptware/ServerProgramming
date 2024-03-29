<?php 

require_once("class/events.class.php");
$event = new Events();
$event->establishConnection();

if (!isset($_SESSION['user']) || !isset($_SESSION['userID']) || !isset($_SESSION['role']) ) 
{
    header("location: login.php");
}


$managerName = $_SESSION['user'];
$managerID = $_SESSION['userID'];

echo "<title>Event Control Panel</title>";
echo '<link rel="icon" href="media/favicon.png" type="media/png" sizes="16x16">';

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