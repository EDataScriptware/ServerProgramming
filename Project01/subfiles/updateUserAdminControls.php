<?php
session_start();

    echo $_SESSION['role_pass'];

    $username = $_SESSION['username_pass'];

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

?>