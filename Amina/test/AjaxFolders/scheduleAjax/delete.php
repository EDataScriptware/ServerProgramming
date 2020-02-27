<?php  

 require_once("../../PDO.DB.class.php");
  $db = new DB();

$hometeam = $_POST['hometeam']; 

$data = $db->deleteSchedule($hometeam);

return "success";

 ?>