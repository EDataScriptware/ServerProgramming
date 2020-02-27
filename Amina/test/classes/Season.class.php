<?php

class Season{

	private $id;
	private $year;
	private $description ;

	public function AllString(){

		$bigString = "";
		$bigString .= "  
                <tr>   
                     <td class='id' data-id1='$this->id' data-old='$this->id' contenteditable>$this->id</td>  
                     <td class='year' data-id1='$this->year' contenteditable>$this->year</td>  
                     <td class='description' data-id1='$this->description' contenteditable>$this->description</td>  
                     <td><button type='button' name='season_delete_btn' data-id3='$this->id' class='btn btn-xs btn-danger season_btn_delete'>x</button></td>  
                </tr>  
           ";  

           	return $bigString;

	}

}
