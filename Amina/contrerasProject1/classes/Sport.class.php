<?php

class Sport{

	private $id;
	private $name;

	public function AllString(){

		$bigString = "";
		$bigString .= "  
                <tr>   
                     <td class='id' data-id1='$this->id' data-old='$this->id' contenteditable>$this->id</td>  
                     <td class='name' data-id1='$this->name' contenteditable>$this->name</td>  
                     <td><button type='button' name='sport_delete_btn' data-id3='$this->id' class='btn btn-xs btn-danger sport_btn_delete'>x</button></td>  
                </tr>  
           ";  

           	return $bigString;

	}
}