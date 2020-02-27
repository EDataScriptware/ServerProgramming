<?php

class User{

	private $username;
	private $role;
	private $password;
	private $team;
	private $league;

    function getUsername(){
        return $this->username;
    }

    function getPassword(){
        return  $this->password;
    }

    function getRole(){
        return $this->role;
    }

    function getTeam(){
        return $this->team;
    }

    function getLeague(){
        return $this->league;
    }

	public function AllString(){


		$bigString = "";
		$bigString .= "  
                <tr>   
                     <td class='username' data-id1='$this->username' data-old='$this->username' contenteditable>$this->username</td>  
                     <td class='password' data-id1='$this->password' contenteditable>$this->password</td>  
                     <td class='role' data-id1='$this->role' contenteditable>$this->role</td>
                     <td class='team' data-id1='$this->team' contenteditable>$this->team</td> 
                     <td class='league' data-id1='$this->league' contenteditable>$this->league</td>  
                     <td><button type='button' name='delete_btn' data-id3='$this->username' class='btn btn-xs btn-danger btn_delete'>x</button></td>  
                </tr>  
           ";  

           	return $bigString;

	}

}