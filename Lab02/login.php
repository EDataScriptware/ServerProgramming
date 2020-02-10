<?php
// NAME: Edward Riley
// PROFESSOR: Bryan French
// COURSE: Server Programming
// DATE: 1/27/2020

// User: admin
// Password: password
// URL Example: https://serenity.ist.rit.edu/~emr9018/341/Labs/Lab02/login.php?user=admin&password=password

    // name of session
    session_name("Lab02");
    session_start();

    // initialized variable
    $loggedin = true;
    $date = date("F d, Y h:i A");
    $expire = 600; // 10 minutes

    $_SESSION['loggedin'] = false;
    // Setting cookie
    setcookie("loggedin", $loggedin, time() + $expire);
    setcookie("date", $date, time() + $expire);

    // Verifying whether first time login or not
    if (!isset($_COOKIE['loggedin']) )
    {
        echo "<html>FIRST TIME LOG IN!";
    }
    else 
    {
        // Print essential information
        echo "<html>LOGIN: " . $_COOKIE['loggedin'] . "<br />";
        echo "DATE: " . $_COOKIE['date'] . "<br />";
        echo "<h1>";

        // Check for missing/incorrect username and password.
        if (!isset($_GET['user']) || !isset($_GET['password'] )) 
        {
            echo "INVALID LOGIN! Username or password is missing!";
        }
        else if ($_GET['user'] != "admin")
        {
            echo "INVALID LOGIN! Incorrect Username" . $_GET['user']; 
        }
        else if ($_GET['password'] != "password")
        {
            echo "INVALID LOGIN! Incorrect Password: " . $_GET['password']; 
        }
        else 
        {
            $user = $_GET['user'];
            $password = $_GET['password'];
            echo "Login Authenticated<hr> User: " . $user . "<br /> Password: " . $password;
            echo "</h1>";
            $_SESSION['loggedin'] = true;
            $_SESSION['user'] = $user;
            $_SESSION['password'] = $password;
            sleep(3);
            
            header("Location: admin.php");

        }
        echo "</h1>";
    }   
?>

