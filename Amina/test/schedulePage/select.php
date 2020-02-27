<?php  
  require_once("../PDO.DB.class.php");
  $db = new DB();

  try{

 $data = $db->selectSchedulepageclass(); 
   
 $output = '';  
  
 $output .= "<select id='getSchool' >";

  if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->getSchoolName()}";
      }   
 }  


  
 $output .= "</select>";



 echo $output;  
}catch(PDOEXception $error){
        die("Error");
    }
 ?>