<?php  
 
  require_once("../../PDO.DB.class.php");
  $db = new DB();


 $getOldSport = $_POST['oldSport']; 
 $sport = $_POST['sport'];   
 $league = $_POST['league']; 
 $season = $_POST['season'];  


$data = $db->updateSlseason($sport,$league,$season,$getOldSport);

var_dump($data);

 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?>