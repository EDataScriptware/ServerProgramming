<?php  
  require_once("../PDO.DB.class.php");
  $db = new DB();

  try{
 $output = '';  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">Picture</th>  
                     <th width="40%">Full Name</th>  
                     <th width="40%">Jersey Number</th>  
                     <th width="10%">Position</th>  
                </tr>';  


      $data = $db->ViewTeampageclass();  

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