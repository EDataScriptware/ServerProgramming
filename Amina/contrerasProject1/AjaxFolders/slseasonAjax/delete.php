<?php  

 require_once("../../PDO.DB.class.php");
  $db = new DB();

$sport = $_POST['sport']; 

echo "Sport is ".$sport;

$data = $db->deleteSlseason($sport);

return "success";
 ?>