<?php 
require_once("class/events.class.php");
$events = new Events();
$events->establishConnection();

echo '<head><style>';
include 'css/events.css';
echo '</style></head>';
echo '<link rel="icon" href="media/favicon.png" type="media/png" sizes="16x16">';

echo "<title>Home Page</title>";
echo "<h1>Home Page</h1>";

if (!isset($_SESSION['user']) || !isset($_SESSION['userID']) || !isset($_SESSION['role']) ) 
{
    header("location: login.php");
}

$username = $_SESSION['user'];
$userID = $_SESSION['userID'];
$role = $_SESSION['role'];

$_SESSION['user'] = $_SESSION['user'];
$_SESSION['userID'] = $_SESSION['userID'];
$_SESSION['role'] = $_SESSION['role'];

echo "<h2>Hello $username!</h2>";
switch ($role)
{
    case 1:
        echo "<p class='inline'><a href='adminControls.php'>Admin Control Panel</a></p>";
        echo "<p class='inline'><a href='eventManager.php'>Manager Control Panel</a></p>";
        echo "<p class='inline'><a href='attendeeManager.php'>Attendee Control Panel</a></p>";
    break;

    case 2:
        echo "<p class='inline'><a href='eventManager.php'>Manager Control Panel</a></p>";
        echo "<p class='inline'><a href='attendeeManager.php'>Attendee Control Panel</a></p>";
    break;

    case 3: 
        echo "<p class='inline'><a href='attendeeManager.php'>Attendee Control Panel</a></p>";
    break;

    default: 
        // immediate redirect - something is broken
        header("location: login.php");
    break;
}
echo "<h3>My Events!</h3>";
$events->getAllEventsUnderSpecificUser($userID);

echo "<h3>My Sessions!</h3>";
$events->getAllSessionsUnderSpecificUser($userID);

echo "<form method='POST'> <button type='submit' name='LogOut' class='button'>Log Out</button></form>";
if (isset($_POST['LogOut']))
{
    session_destroy();
    header("location: login.php");
}



?>