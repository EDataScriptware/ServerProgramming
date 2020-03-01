<?php 
session_start();

echo "<title>Event and Sessions</title>";
echo "<h1>Events and Sessions Page</h1>";

$username = $_SESSION['user'];
$role = $_SESSION['role'];

echo "<h2>Hello $username!</h2>";
echo "<h3>Your Events</h3>";
echo "<a href='adminControls.php'>Admin Control Panel</a>";


?>