<?php  
 
  require_once("../../PDO.DB.class.php");
  $db = new DB();


 $id = $_POST['id']; 
 $firstname = $_POST['firstname'];  
 $lastname =  $_POST['lastname'];  
 $dateofbirth = $_POST['dateofbirth'];  
 $jerseynumber = $_POST['jerseynumber'];  
 $team = $_POST['team']; 


$data = $db->updatePlayer($id,$firstname,$lastname,$dateofbirth,$jerseynumber,$team);

var_dump($data);

 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?>