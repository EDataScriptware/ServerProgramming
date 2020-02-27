<?php

class Slseason{

	private $sport;
	private $league;
  private $season;


	public function AllString(){

		$bigString = "";
		$bigString .= "  
                <tr>   
                     <td class='slseason_sport' data-id1='$this->sport' data-oldSport='$this->sport' contenteditable>$this->sport</td>  
                     <td class='slseason_league' data-id1='$this->league' contenteditable>$this->league</td>  
                     <td class='slseason_season' data-id1='$this->season' contenteditable>$this->season</td>  
                     <td><button type='button' name='slseason_delete_btn' data-id3='$this->sport' class='btn btn-xs btn-danger slseason_btn_delete'>x</button></td>  
                </tr>  
           ";  

           	return $bigString;

	}


}