<?php

class Schedule{

	private $sport;
	private $league;
	private $season;
	private $hometeam;
	private $awayteam;
	private $homescore;
	private $awayscore;
	private $scheduled;
	private $completed;
	
	

	public function AllString(){

		$bigString = "";
		$bigString .= "  
                <tr>   
                     <td class='schedule_sport' data-id1='$this->sport'contenteditable>$this->sport</td>  
                     <td class='schedule_league' data-id1='$this->league' contenteditable>$this->league</td>  
                     <td class='schedule_season' data-id1='$this->season' contenteditable>$this->season</td>  
                     <td class='schedule_hometeam' data-id1='$this->hometeam' data-oldHT='$this->hometeam' contenteditable>$this->hometeam</td> 
                     <td class='schedule_awayteam' data-id1='$this->awayteam' contenteditable>$this->awayteam</td>  
                     <td class='schedule_homescore' data-id1='$this->homescore' contenteditable>$this->homescore</td>  
                     <td class='schedule_awayscore' data-id1='$this->awayscore' contenteditable>$this->awayscore</td>
                     <td class='schedule_scheduled' data-id1='$this->scheduled' contenteditable>$this->scheduled</td> 
                     <td class='schedule_completed' data-id1='$this->completed' contenteditable>$this->completed</td>    
                     <td><button type='button' name='schedule_delete_btn' data-id3='$this->hometeam' class='btn btn-xs btn-danger schedule_btn_delete'>x</button></td>  
                </tr>  
           ";  

           	return $bigString;

	}


}