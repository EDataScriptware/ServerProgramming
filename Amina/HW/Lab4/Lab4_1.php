<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 4_1 -->
<?php
    require_once("DB.class.php");
    
    $db = new DB();

    $count = count($db->getAllPeople());

    echo "<h1>Records Found: {$count}</h1>";
    echo $db->getAllPeopleAsTable();
?>