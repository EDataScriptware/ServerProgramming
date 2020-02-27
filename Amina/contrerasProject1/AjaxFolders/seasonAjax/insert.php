<?php  

  require_once("../../PDO.DB.class.php");
  $db = new DB();

  $data = $db->insertSeason($_POST['year'],$_POST['desc']);

  
 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?> 