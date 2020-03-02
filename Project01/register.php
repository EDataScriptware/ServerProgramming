<?php 
require_once("class/registeration.class.php");
require_once("class/login.class.php");
$db_register = new DBR();
$db_login = new DBL();
$db_register->establishConnection();

echo "<title>Register</title>";

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
echo "<input type='submit' name='loginName' value='Back To Login Page'>";
echo "</form>";

if (isset($_POST['loginName']))
{
    header("location: login.php");
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

   
    if ( !(isset($_POST['verification_register_password'])) || !(isset($_POST['register_password'])) || !(isset($_POST['register_name']))  )
    {
        echo "Missing information! One or more input is blank!";
    }
    else 
    {

        if ($_POST['register_name'] == null || $_POST['verification_register_password'] == null || $_POST['register_password'] == null)
        {
            echo "Missing information! One or more input is blank!";
        }
        else 
        {
            // insert row
            if ($_POST['register_password'] != $_POST['verification_register_password'])
            {
                echo "Passwords don't match!";
            }
            else 
            {
                if ($db_register->checkAccountExists($_POST['register_name']) == true)
                {
                    echo "Account already exists!";
                }
                else 
                {
                    try 
                    {    
                        $password = hash("sha256", $_POST['register_password']);
                        $db_register->insertRow($_POST['register_name'], $password, $role);
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