<?php  
 
  require_once("../../PDO.DB.class.php");
  $db = new DB();


 $getID = $_POST['id']; 
 $year = $_POST['year'];  
 $desc = $_POST['desc']; 

$data = $db->updateSeason($getID,$year,$desc);

var_dump($data);

 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?>