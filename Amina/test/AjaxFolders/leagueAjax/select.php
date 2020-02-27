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
                     <th width="40%">Name</th>   
                </tr>';  


      $data = $db->ViewLeagueclass();  

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
      $output .= '  
           <tr>  
                <td id="id" contenteditable></td>  
                <td id="league_name" contenteditable></td>   
                <td><button type="button" name="league_btn_add" id="league_btn_add" class="btn btn-xs btn-success">+</button></td>  
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