<?php 

    session_name("Edward");
    session_start();

    // Check to see if we've been here before using a session variable. 
    if (!empty ($_SESSION['name']))
    {
        // add a session variable and redirect
        $_SESSION['school'] = "RIT";
        $_SESSION['count']++;
        header("Location: session02_02.php");
        exit; 

    }

?>

<html>
    <head>
        <title>Session 01</title>
    </head>
    <body>
    <?php
        if (isset($_SESSION['count']))
        {
            echo "<h1>Hi, you've been here before, {$_SESSION['count']} times.</h1>";
            $_SESSION['count']++;
        }
        else 
        {
            echo "<h1>Hi, you haven't been here before!</h1>";
            $_SESSION['count'] = 0;
        }
        $_SESSION['name'] = "Edward Riley"
    ?>
    </body>
    <h2><a href="session01_02.php">Come back!</a></h2>

</html>