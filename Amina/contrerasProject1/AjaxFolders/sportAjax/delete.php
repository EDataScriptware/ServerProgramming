<?php  

 require_once("../../PDO.DB.class.php");
  $db = new DB();

$id = $_POST['id']; 

$data = $db->deleteSport($id);

return "success";

 ?>