<?php
    require_once("../class/admin.class.php");

    $admin = new Admin();
    $admin->establishConnection();
    
    if (!isset($_SESSION['user']) || !isset($_SESSION['userID']) || !isset($_SESSION['role']) ) 
    {
        header("location: login.php");
    }


    $userRole = $_SESSION['role_pass'];
    $userID = $_SESSION['userID_pass'];
    $username = $_SESSION['username_pass'];

    echo "<form method='POST'>";
    echo "<p> Username: <input type='text' id='register_name' name='register_name' value='$username'></p>";    

    if ($userRole == 1) // if admin role
    {
        echo "<p>Role:  <select id='register_role' name='register_role'>
        <option value='administrator' selected>Administrator</option>
        <option value='eventmanager'>Event Manager</option>
        <option value='attendee'>Attendee</option>
        </select></p>";
    }
    else if ($userRole == 2) // if event manager role
    {
        echo "<p>Role:  <select id='register_role' name='register_role'>
        <option value='administrator'>Administrator</option>
        <option value='eventmanager' selected>Event Manager</option>
        <option value='attendee'>Attendee</option>
        </select></p>";
    }
    else if ($userRole == 3) // if attendee role
    {
        echo "<p>Role:  <select id='register_role' name='register_role'>
        <option value='administrator'>Administrator</option>
        <option value='eventmanager'>Event Manager</option>
        <option value='attendee' selected>Attendee</option>
        </select></p>";
    }
    else // if error or unusual unknown role occurs - assume default role
    {
        echo "<p>Role:  <select id='register_role' name='register_role'>
        <option value='administrator'>Administrator</option>
        <option value='eventmanager'>Event Manager</option>
        <option value='attendee'>Attendee</option>
        </select></p>";
    }

    echo "<input type='submit' name='updateName' value='Update'>";
    echo "<input type='submit' name='deleteName' value='Delete This Account'>";
    echo "<input type='submit' name='goBack' value='Go Back'>";
    echo "</form>";


    if (isset($_POST['goBack']))
    {
        header("location: ../adminControls.php");
    }

    if (isset($_POST["deleteName"]))
    {
        $admin->deleteUserAccount($userID);
        header("location: ../adminControls.php");
    }

    if (isset($_POST["updateName"]))
    {
        $newUsername = $_POST["register_name"];
        $newRole = $_POST["register_role"];

        switch ($newRole)
        {
            case "administrator":
                $newRole = 1;
            break; 
            case "eventmanager":
                $newRole = 2;
            break;
            case "attendee":
                $newRole = 3;
            break;
            default:
                $newRole = 3;
            break;
        }

        $admin->updateUserAccount($userID, $newUsername, $newRole);
        header("location: ../adminControls.php");
    }
?>