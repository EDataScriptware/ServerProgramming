<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 4_3 -->
<?php
require_once("PDO.DB.class.php");

$db = new DB();

$count = count($db->getAllObjects());

echo "<h2>Records Found: {$count}</h2>";
echo $db->getAllPeopleAsTable();

?>