<?php  
  require_once("../../PDO.DB.class.php");
  $db = new DB();

  try{
 $output = '';  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">User</th>  
                     <th width="40%">Password</th>  
                     <th width="40%">Role</th>  
                     <th width="10%">Team</th>  
                     <th width="10%">League</th>  
                </tr>';  


      $data = $db->ViewUsertmNcclass();

      echo "Here";    

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
      $output .= '  
           <tr>  
                <td id="tmcusername" contenteditable></td>  
                <td id="tmcpassword" contenteditable></td>  
                <td id="tmcrole" contenteditable></td>  
                <td id="tmcteam" contenteditable></td>  
                <td id="tmcleague" contenteditable></td>  
                <td><button type="button" name="tmcuser_btn_add" id="tmcuser_btn_add" class="btn btn-xs btn-success">+</button></td>  
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