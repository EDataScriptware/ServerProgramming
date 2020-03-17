<?php 
require_once("class/admin.class.php");
$admin = new Admin();
$admin->establishConnection();


echo "<title>Admininstrator Control Panel</title>";

echo '<head><style>';
include 'css/info.css';
echo '</style></head>';

echo "<div class='stickytop'>";
echo "<h1>Admin Control Panel</h1>";
$admin->goBackButton();
echo "</div>";
$admin->getAllUsers();
$admin->getAllVenues();
$admin->getAllEvents(); 
$admin->getAllSessions();

echo "<form method='POST'> <button type='submit' name='LogOut' class='backButton'>Log Out</button></form>";
if (isset($_POST['LogOut']))
{
    session_destroy();
    header("location: login.php");
}
?>