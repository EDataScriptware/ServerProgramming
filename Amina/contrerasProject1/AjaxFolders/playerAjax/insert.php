<?php  

  require_once("../../PDO.DB.class.php");
  $db = new DB();

  $data = $db->insertPlayer($_POST['id'], $_POST['firstname'],$_POST['lastname'], $_POST['dateofbirth'], $_POST['jerseynumber'], $_POST['team']);

  
 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?> 