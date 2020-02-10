<?php
// NAME: Edward Riley
// PROFESSOR: Bryan French
// COURSE: Server Programming
// DATE: 1/27/2020

// User: admin
// Password: password
// URL Example: https://serenity.ist.rit.edu/~emr9018/341/Labs/Lab02/admin.php 


    // name of the session
    session_name("Lab02");
    session_start();

      // if there are no session information or cookie information - redirect to login page for security reasons
    if (($_SESSION['user'] == null) || ($_SESSION['loggedin'] == false))
    {
        header("Location: login.php");
    }


    // intro to admin page
    echo "<html><h1>Welcome to Admin Page</h1><br />";
    $user = $_SESSION['user'];
    $password = $_SESSION['password'];

    // Print required details
    echo "User: " . $user . "<br />Password: " . $password; 
    echo "<br />You last logged on " . $_COOKIE['date'];
    echo "</html>";

      

    // erase all data
    session_unset();
    session_destroy();    
    setcookie("loggedin", "", 0);
    setcookie("date", "", 0);

  
  

?>