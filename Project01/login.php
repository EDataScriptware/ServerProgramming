<?php 
require_once("class/login.class.php");
$db_login = new DBL();
$db_login->establishConnection();

session_start();

echo "<title>Login</title>";

echo "<h1>Login Page</h1>";
echo "<form method='POST'>";
echo "<p>Username: <input type='text' id='login_name' name='login_name'></p>";
echo "<p>Password: <input type='password' id='login_password' name='login_password'></p>";
echo "<input type='submit' name='submit' value='Submit'> ";
echo "<input type='submit' name='registerName' value='Register'>";
echo "</form>";

if (isset($_POST['registerName']))
{
    header("Location: register.php");
}

if (isset($_POST['submit']))
{
 
    if ( !(isset($_POST['login_name'])) || !(isset($_POST['login_password'])) )
    {
        echo "Missing information! One or more input is blank!";
    }
    else 
    {
        if ($_POST['login_name'] == null || $_POST['login_password'] == null)
        {
            echo "Missing information! One or more input is blank!";
        }
        else 
        {
            $password = hash("sha256", $_POST['login_password']);
            $db_login->logIn($_POST['login_name'], $password);
        }
    }
    
}
?>