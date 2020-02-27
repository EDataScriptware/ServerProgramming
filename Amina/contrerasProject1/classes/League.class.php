<?php

class League{

	private $id;
	private $name;


	public function AllString(){

		$bigString = "";
		$bigString .= "  
                <tr>   
                     <td class='league_id' data-id1='$this->id' data-old='$this->id' contenteditable>$this->id</td>  
                     <td class='league_name' data-id1='$this->name' contenteditable>$this->name</td>  
                     <td><button type='button' name='league_delete_btn' data-id3='$this->id' class='btn btn-xs btn-danger league_btn_delete'>x</button></td>  
                </tr>  
           ";  

           	return $bigString;

	}


}