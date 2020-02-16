<?php
require_once("PDO.DB.class.php");

$db = new DB();

if(isset($_GET['id']))
{
    echo $db->getAllPhoneAsTable($_GET['id']); 
    echo "<a href='Lab4_3.php'>Go back to Lab4_3.php</a>";
} 
else 
{
    header("Location: Lab4_3.php");
    exit;
}