<?php 
require_once("class/attendee.class.php");

if (!isset($_SESSION['user']) || !isset($_SESSION['userID']) || !isset($_SESSION['role']) ) 
{
    header("location: login.php");
}

$attendee = new Attendee();
$attendee->establishConnection();
$userID = $_SESSION['userID'];


echo '<head><style>';
include 'css/info.css';
echo '</style></head>';
echo "<div class='stickytop'>";
echo "<h1>Attendee Control Panel</h1>";
$attendee->goBackButton();
echo "</div>";
$attendee->getAllSessions($userID);
$attendee->getAllEvents($userID);

echo "<form method='POST' > <button type='submit' name='LogOut' class='backButton'>Log Out</button></form>";
if (isset($_POST['LogOut']))
{
    session_destroy();
    header("location: login.php");
}



?>