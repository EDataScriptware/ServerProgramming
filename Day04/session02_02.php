<?php 

    session_name("Edward");
    session_start();

    /*
    // Check to see if we've been here before using a session variable. 
    if (!empty ($_SESSION['name']))
    {
        // add a session variable and redirect
        $_SESSION['school'] = "RIT";
        $_SESSION['count']++;
        header("Location: session02_02.php");

        exit;
    }
    */

    
?>
<html>
    <head>
        <title>Session 02</title>
    </head>
    <body>
        <?php 
            if (isset($_SESSION['name']))
            {
                echo "Hi, {$_SESSION['name']} from {$_SESSION['school']}. I remembered your name.<br />";

                // unset just the session variable 'name'
                // unset($_SESSION['name']);
                session_unset();
                if (isset($_COOKIE[session_name()]))
                {
                    setcookie(session_name(), "", 1,"/");
                }
                
                // destroys all the data relating to the session
                session_destroy();
                
                echo "<a href='session01_02.php'>Page 01</a>";

            }
            else
            {
        ?>
                    <p>Sorry, I do not know who you are!</p>
                    <p><a href="session01_02.php>">Login</a></p>
        <?php
               
            }
        ?>
    </body>

</html>
