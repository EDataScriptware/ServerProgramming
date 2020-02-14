<?php 
require_once "DB.class.php";

        if(isset($_GET['id']))
        {
            $db = new DB();

            echo $db->getAllPhoneAsTable($_GET['id']);
        }
        else 
        {
            header("location: Lab4_1.php");
        }

        echo "<a href='Lab4_1.php'>{GO BACK TO Lab4_1.php}</a>";
        
?>