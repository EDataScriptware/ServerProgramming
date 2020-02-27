<?php  
  require_once("../../PDO.DB.class.php");
  $db = new DB();

  try{
 $output = '';  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">Sport</th>  
                     <th width="40%">League</th>  
                     <th width="40%">Season</th>  
                </tr>';  


      $data = $db->ViewSlseasonclass();

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
      $output .= '  
           <tr>  
                <td id="slseason_sport" contenteditable></td>  
                <td id="slseason_league" contenteditable></td>  
                <td id="slseason_season" contenteditable></td>  
                <td><button type="button" name="slseason_btn_add" id="slseason_btn_add" class="btn btn-xs btn-success">+</button></td>  
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