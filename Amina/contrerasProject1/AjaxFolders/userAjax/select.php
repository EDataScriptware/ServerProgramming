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


      $data = $db->ViewUserclass();

      echo "Here";    

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
      $output .= '  
           <tr>  
                <td id="username" contenteditable></td>  
                <td id="password" contenteditable></td>  
                <td id="role" contenteditable></td>  
                <td id="team" contenteditable></td>  
                <td id="league" contenteditable></td>  
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
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