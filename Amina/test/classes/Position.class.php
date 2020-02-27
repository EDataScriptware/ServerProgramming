<?php

class Position{

	private $name;
	private $id;

	
	

	public function AllString(){


		$bigString = "";
		$bigString .= 
	   "<tr>
	    	<td class='pos_name' data-id1='$this->name' contenteditable>$this->name</td> 
			<td class='pos_id' data-id1='$this->id' data-oldPosID='$this->id' contenteditable>$this->id</td> 
			<td><button type='button' name='pos_delete_btn' data-id3='$this->id' class='btn btn-xs btn-danger pos_btn_delete'>x</button></td>    
		</tr>";


		return $bigString;

	}


}