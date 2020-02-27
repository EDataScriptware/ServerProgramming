<?php  

  require_once("../../PDO.DB.class.php");
  $db = new DB();

  $data = $db->insertLeague($_POST['name']);

  
 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?> 