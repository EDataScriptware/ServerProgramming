<?php

class Player{

	private $id;
	private $firstname;
	private $lastname;
	private $dateofbirth;
	private $jerseynumber;
	private $team;

	
	

	public function AllString(){


		$bigString = "";
		$bigString .= 
	   "<tr>
	   		  <td class='ply_id' data-id1='$this->id' data-oldPly='$this->id' contenteditable>$this->id</td>  
              <td class='ply_firstname' data-id1='$this->firstname' contenteditable>$this->firstname</td>  
              <td class='ply_lastname' data-id1='$this->lastname' contenteditable>$this->lastname</td>
              <td class='ply_dateofbirth' data-id1='$this->dateofbirth' contenteditable>$this->dateofbirth</td> 
              <td class='ply_jerseynumber' data-id1='$this->jerseynumber' contenteditable>$this->jerseynumber</td>  
              <td><button type='button' name='ply_delete_btn' data-id3='$this->id' class='btn btn-xs btn-danger ply_btn_delete'>x</button></td>  
		</tr>";


		return $bigString;

	}


}