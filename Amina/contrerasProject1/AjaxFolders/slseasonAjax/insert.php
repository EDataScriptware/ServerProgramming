<?php  

  require_once("../../PDO.DB.class.php");
  $db = new DB();

  $data = $db->insertSlseason($_POST['sport'],$_POST['league'], $_POST['season']);

  
 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?> 