<?php 
require_once "DB_02.class.php";

    $db = new DB();

    // $id = $db->insert("Sneed", "Sam", "Sammy");
    // if ($id > 0)
    // {
    //     echo "<p>You inserted 1 row whose id is $id. </php>";
    // }
    // else 
    // {
    //     echo "<p>You failed to insert row.</p>";
    // }

    //    $num = $db->update(array("id"=>5,"nick","Nicked"));

        $num = $db->delete(7);

        echo "<p>You deleted $num rows.</p>";
        
        echo $db->getAllPeopleAsTable();
?>