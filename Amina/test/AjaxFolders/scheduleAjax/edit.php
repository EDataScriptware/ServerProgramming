<?php  
 
  require_once("../../PDO.DB.class.php");
  $db = new DB();


 $oldHT = $_POST['oldHT']; 
 $sport = $_POST['sport']; 
 $league = $_POST['league'];  
 $season = $_POST['season']; 
 $hometeam = $_POST['hometeam'];
 $awayteam = $_POST['awayteam'];
 $homescore = $_POST['homescore'];  
 $awayscore = $_POST['awayscore']; 
 $scheduled = $_POST['scheduled']; 
 $completed = $_POST['completed']; 


$data = $db->updateSchedule($sport,$league,$season,$hometeam,$awayteam,$homescore,$awayscore,$scheduled,$completed,$oldHT);

var_dump($data);

 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?>