<?php
    /**
    * Amina Mahmood
    * ISTE 341
    * Server Programming
    * header.class.php
    */
    include('PDODB.class.php');
    session_start();
    if(!isset($_SESSION['userType'])){
        echo '<script>window.location.replace("login.php");</script>';
    }
?>


