<?php  
  require_once("../PDO.DB.class.php");
  $db = new DB();

 
  try{

   $id = $_POST['id']; 

 $output = '';  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">School</th>  
                     <th width="40%">Homescore</th>   
                     <th width="10%">Awayscore</th>  
                     <th width="40%">Scheduled</th>   
                     <th width="40%">Completed</th>   
                </tr>';  


   $data = $db->ViewSchedulepageclass($id);  

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
 }  
 else  
 {  
      $output .= '<tr>  
                          <td colspan="4">Data not Found</td>  
                     </tr>';  
 }  
 $output .= '</table>  
      </div>';  
 echo $output; 
}catch(PDOEXception $error){
        die("Error");
    }
 ?>