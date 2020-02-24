<?php 
require_once("verification.class.php");
$db = new DB();
$db->establishConnection();


echo "<h1>Registration Page</h1>";
echo "<form>";
echo "<p> Username: <input type='text' id='register_name' name='register_name'></p>";
echo "<p> Password: <input type='password' id='register_password' name='register_password'></p>";
echo "<p> Password Verification: <input type='password' id='verification_register_password' name='verification_register_password'></p>";
echo "<input type='submit' value='Register'>";
echo "</form>";



?>