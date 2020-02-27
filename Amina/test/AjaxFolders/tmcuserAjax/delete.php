<?php  

 require_once("../../PDO.DB.class.php");
  $db = new DB();

$username = $_POST['username']; 

$data = $db->deleteUser($username);

return "success";
 ?>