<?php
session_start();

    echo "test";
    var_dump($_SESSION['userID_pass']);
    echo $_SESSION['userID_pass'];
    echo $_SESSION['username_pass'];
    echo $_SESSION['role_pass'];


?>