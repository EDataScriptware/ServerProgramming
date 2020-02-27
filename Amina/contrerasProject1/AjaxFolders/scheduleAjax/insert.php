<?php  

  require_once("../../PDO.DB.class.php");
  $db = new DB();

  $data = $db->insertSchedule($_POST['sport'],$_POST['league'], $_POST['season'], $_POST['hometeam'],$_POST['awayteam'], $_POST['homescore'],$_POST['awayscore'],$_POST['scheduled'], $_POST['completed']);

  
 if(count($data) > 0 )  
 {  
      foreach($data as $phone){

              $bigString2 .= "{$phone->AllString()}";

        } 
 }  
 ?> 