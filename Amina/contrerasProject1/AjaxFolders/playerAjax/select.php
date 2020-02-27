<?php  
  require_once("../../PDO.DB.class.php");
  $db = new DB();

  try{
 $output = '';  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">ID</th>  
                     <th width="40%">First Name</th>  
                     <th width="40%">Last Name</th>  
                     <th width="10%">Date of Birth</th>  
                     <th width="10%">Jersey Number</th> 
                     <th width="10%">Team</th> 
                </tr>';  


      $data = $db->ViewPlayerclass();  

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
      $output .= '  
           <tr>  
                <td id="ply_id" contenteditable></td>  
                <td id="ply_firstname" contenteditable></td>  
                <td id="ply_lastname" contenteditable></td>  
                <td id="ply_dateofbirth" contenteditable></td>  
                <td id="ply_jerseynumber" contenteditable></td>  
                <td id="ply_team" contenteditable></td>  
                <td><button type="button" name="ply_btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
           </tr>  
      ';  
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