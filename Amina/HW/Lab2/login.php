<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 2 -->
<?php
// Initiate the session
session_name("Amina");
session_start();
?>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
            if(isset($_COOKIE['loggedIn'])){
                header("Location: admin.php");
            }
            else if(isset($_SESSION['failed'])){    
                echo "<h2>You need to login in</h2>";
                unset($_SESSION['failed']);
            }
            else{
                if(isset($_GET['user']) || isset($_GET['password'])){
                    if($_GET['user'] == 'admin' && $_GET['password'] == 'password'){
                        date_default_timezone_set('EST');
                        $loggedIn = $_COOKIE['loggedIn'];
                        $loggedIn = date("F j, Y, g:i a");
                        setcookie("loggedIn", $loggedIn, time() + 600, "/~axm6392/", "serenity.ist.rit.edu", false, true);
                        header("Location: admin.php");
                        exit;
                    }
                    else {
                        echo "<h1>Invalid Login</h1>";
                    }
                }
                else{
                    echo "<h2>Invalid Login</h2>";
                }
            }
        ?>
    </body>
</html>