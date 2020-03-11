<?php 
require_once("class/admin.class.php");
$admin = new Admin();
$admin->establishConnection();


echo "<title>Admininstrator Control Panel</title>";
echo "<h1>Admin Control Panel</h1>";
$admin->getAllUsers();
$admin->getAllVenues();
$admin->getAllEvents(); 
$admin->getAllSessions();


?>