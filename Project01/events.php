<?php 
require_once("class/events.class.php");
$events = new Events();
$events->establishConnection();

session_start();

echo "<title>Event and Sessions</title>";
echo "<h1>Events and Sessions Page</h1>";

$username = $_SESSION['user'];
$userID = $_SESSION['userID'];
$role = $_SESSION['role'];

echo "<h2>Hello $username!</h2>";
switch ($role)
{
    case 1:
        echo "<p><a href='adminControls.php'>Admin Control Panel</a></p>";
        echo "<p><a href='eventManager.php'>Manager Control Panel</a></p>";
        echo "<p><a href='attendeeManager.php'>Attendee Control Panel</a></p>";
    break;

    case 2:
        echo "<p><a href='eventManager.php'>Manager Control Panel</a></p>";
        echo "<p><a href='attendeeManager.php'>Attendee Control Panel</a></p>";
    break;

    case 3: 
        echo "<p><a href='attendeeManager.php'>Attendee Control Panel</a></p>";
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





?>