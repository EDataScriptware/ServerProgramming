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
                     <th width="40%">Hometeam</th> 
                     <th width="40%">Awayteam</th> 
                     <th width="40%">Homescore</th> 
                     <th width="40%">Awayscore</th> 
                     <th width="40%">Scheduled</th> 
                     <th width="40%">Completed</th> 
                </tr>';  


      $data = $db->ViewScheduleclass();  

 if(count($data) > 0)  
 {  
      foreach($data as $phone)  
      {  
           $output .= "{$phone->AllString()}";
      }  
      $output .= '  
           <tr>  
                <td id="schedule_sport" contenteditable></td>   
                <td id="schedule_league" contenteditable></td>   
                <td id="schedule_season" contenteditable></td>   
                <td id="schedule_hometeam" contenteditable></td>  
                <td id="schedule_awayteam" contenteditable></td>    
                <td id="schedule_homescore" contenteditable></td>  
                <td id="schedule_awayscore" contenteditable></td> 
                <td id="schedule_scheduled" contenteditable></td>  
                <td id="schedule_completed" contenteditable></td>       
                <td><button type="button" name="schedule_btn_add" id="schedule_btn_add" class="btn btn-xs btn-success">+</button></td>  
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