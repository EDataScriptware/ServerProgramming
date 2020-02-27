<?php

class ViewSchedule{

    private $name;
    private $homescore;
    private $awayscore;
    private $scheduled;
    private $completed;

    public function AllString(){


        $bigString = "";
        $bigString .= "  
                <tr>   
                     <td class='sch_name' data-id1=".$this->name."  contenteditable>$this->name</td>  
                     <td class='sch_homescore' contenteditable>$this->homescore</td>  
                     <td class='sch_awayscore' data-id1='$this->awayscore' contenteditable>$this->awayscore</td>
                     <td class='sch_scheduled' data-id1='$this->scheduled' contenteditable>$this->scheduled</td>  
                     <td class='sch_completed' data-id1='$this->completed' contenteditable>$this->completed</td>  
                </tr>  
           ";  

            return $bigString;

    }

    public function getSchoolName(){
        $string = "";
        $string .= "<option value=".$this->name.">$this->name</option>";

        return    $string;
    }





}