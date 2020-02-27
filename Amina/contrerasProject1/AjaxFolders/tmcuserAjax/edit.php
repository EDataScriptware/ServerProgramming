<?php  
 
  require_once("../../PDO.DB.class.php");
  $db = new DB();


 $getOldusername = $_POST['oldusername']; 
 $username = $_POST['username'];  
 $password = hash("sha256", $_POST['password']);  
 $role = $_POST['role'];  
 $team = $_POST['team'];  
 $league = $_POST['league']; 


$data = $db->updateUser($username,$password,$role,$team,$league,$getOldusername);

var_dump($data);

 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?>