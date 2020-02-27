<?php  

  require_once("../../PDO.DB.class.php");
  $db = new DB();

  $data = $db->insertUser($_POST['username'],hash("sha256", $_POST['password']),$_POST['role'], $_POST['team'], $_POST['league']);

  
 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?> 