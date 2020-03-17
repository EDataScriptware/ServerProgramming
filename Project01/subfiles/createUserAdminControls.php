<?php 
require_once("../class/registeration.class.php");
require_once("../class/login.class.php");

$db_register = new DBR();
$db_login = new DBL();
$db_register->establishConnection();

echo "<title>Administrator Register</title>";

echo '<head><style>';
include '../css/forms.css';
echo '</style></head>';


echo "<h1>Administrator Registration Page</h1>";
echo "<form method='POST'>";
echo "<p> User ID: <input type='text' id='register_idname' name='register_idname'></p>";
echo "<p> Username: <input type='text' id='register_name' name='register_name'></p>";
echo "<p> Password: <input type='password' id='register_password' name='register_password'></p>";
echo "<p> Password Verification: <input type='password' id='verification_register_password' name='verification_register_password'></p>";
echo "<p>Role:  <select id='register_role' name='register_role'>
<option value='administrator'>Administrator</option>
<option value='eventmanager'>Event Manager</option>
<option value='attendee'>Attendee</option>
</select></p>";
echo "<input type='submit' name='submitName' class='button' value='Register'>";
echo "<input type='submit' name='adminControls' class='button' value='Back To Admin Page'>";
echo "</form>";

if (isset($_POST['adminControls']))
{
    header("location: ../adminControls.php");
}

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

   
    if ( !(isset($_POST['verification_register_password'])) || !(isset($_POST['register_password'])) || !(isset($_POST['register_name'])) ||  !(isset($_POST['register_idname'])))
    {
        echo "<p class='errorMessage'>Missing information! One or more input is blank!</p>";
    }
    else 
    {

        if ($_POST['register_idname'] == null || $_POST['register_name'] == null || $_POST['verification_register_password'] == null || $_POST['register_password'] == null)
        {
            echo "<p class='errorMessage'>Missing information! One or more input is blank!</p>";
        }
        else 
        {
            // insert row
            if ($_POST['register_password'] != $_POST['verification_register_password'])
            {
                echo "<p class='errorMessage'>Passwords don't match!</p>";
            }
            else 
            {
                if ($db_register->checkAccountExists($_POST['register_name']) == true)
                {
                    echo "<p class='errorMessage'>sername already exists!</p>";
                }
                else if  ($db_register->checkUserIDExists($_POST['register_idname']) == true)
                {
                    echo "<p class='errorMessage'>UserID already exists!</p>";
                }
                else 
                {
                    try 
                    {    
                        $password = hash("sha256", $_POST['register_password']);
                        $db_register->insertAdminRow($_POST['register_name'], $password, $role, $_POST['register_idname']);
                        header("Location: ../adminControls.php");

                    }
                    catch (Exception $e)
                    {
                        echo "<p> $e </p>";
                    }
                }
            } // end insertRow
        } // end is null
    
    } // end isset
} // end submitName

?>
