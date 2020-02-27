<?php 
require_once("class/registeration.class.php");
$db = new DB();
$db->establishConnection();


echo "<h1>Registration Page</h1>";
echo "<form method='POST'>";
echo "<p> Username: <input type='text' id='register_name' name='register_name'></p>";
echo "<p> Password: <input type='password' id='register_password' name='register_password'></p>";
echo "<p> Password Verification: <input type='password' id='verification_register_password' name='verification_register_password'></p>";
echo "<p>Role:  <select id='register_role' name='register_role'>
<option value='administrator'>Administrator</option>
<option value='eventmanager'>Event Manager</option>
<option value='attendee'>Attendee</option>
</select></p>";
echo "<input type='submit' name='submitName' value='Register'>";
echo "</form>";

if (isset($_POST['submitName']))
{
    // role to numbers
    if ($_POST['register_role'] == "administrator")
    {
        $role = 1;
    }
    else if ($_POST['register_role'] == "eventmanager")
    {
        $role = 2;
    }
    else if ($_POST['register_role'] == "attendee")
    {
        $role = 3;
    }
    else 
    {
        $role = -1;
    }

    // insert row
    try 
    {    
        $db->insertRow($_POST['register_name'], $_POST['register_password'], $role);
    }
    catch (Exception $e)
    {
        echo "<p> $e </p>";
    }
}

?>