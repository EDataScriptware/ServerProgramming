<?php  
 
  require_once("../../PDO.DB.class.php");
  $db = new DB();


 $getID = $_POST['id']; 
 $name = $_POST['name'];  


$data = $db->updateLeague($getID,$name);

var_dump($data);

 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?>