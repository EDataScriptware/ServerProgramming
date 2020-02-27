<?php

class ViewTeam{

    private $picture;
    private $firstname;
    private $lastname;
    private $jerseynumber;
    private $name;

    public function AllString(){


        $bigString = "";
        $bigString .= "  
                <tr>   
                     <td class='picture' data-id1=".$this->picture."  contenteditable><a><img src='images/".$this->picture."' style='width:82px; height:86px' title=".$this->picture." alt=".$this->picture."></a></td>  
                     <td class='Fullname' contenteditable>$this->firstname  $this->lastname</td>  
                     <td class='jerseynumber' data-id1='$this->jerseynumber' contenteditable>$this->jerseynumber</td>
                     <td class='name' data-id1='$this->name' contenteditable>$this->name</td>  
                </tr>  
           ";  

            return $bigString;

    }

    

}