<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 4_2 -->
<?php
    require_once("DB.class.php");
    
    $db = new DB();

    if(isset($_GET['id'])) {
        echo $db->getPhoneNumbersAsTable($_GET['id']);
        echo "<a href='Lab4_1.php'>Go back to Lab4_1.php</a>";
    } 
    else {
         header("Location: Lab4_1.php");
         exit;
     }
?>