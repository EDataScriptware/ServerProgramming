<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 3 -->
<?php

// Create a class Validator
class Validator
{
    static function length($value){
        if(strlen($value) == 0){
            return false;
        }
        return true;
    }
    
    static function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
