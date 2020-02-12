<?php

    require_once "PDO.DB.class.php";
    
    $db = new DB();

    $data = $db->getPerson(1);
    foreach($data as $row)
    {
        print_r($row);
    }
    echo "<hr/>";

    $data = $db->getAltPerson(1);
    foreach($data as $row)
    {
        print_r($row);
    }
    echo "<hr/>";
    
    $data = $db->getAltPersonTwo(1);
    foreach($data as $row)
    {
        print_r($row);
    }
    echo "<hr/>";

    $lastId = $db->insert("Mouse", "Mickey", "Big Cheese");
    echo "<h2>PersonID: $lastId</h2>";

    $data = $db->getAllObjects();
    foreach($data as $person){
        echo "<h2>{$person->whoAmI()}</h2>";
    }
?>