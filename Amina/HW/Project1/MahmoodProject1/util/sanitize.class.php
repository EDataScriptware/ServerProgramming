<?php

class Validator {
    
    function sanitizeInput($input) {
        $input = trim($input);
		$input = stripslashes($input);
		$input = htmlentities($input);
		$input = strip_tags($input);
		return $input;
    }
    
    function alphabetic($value) {
        $reg = "/^[A-Za-z]+$/";
        return preg_match($reg,$value);
    }
    
    function alphabeticSpace($value) {
        $reg = "/^[A-Za-z ]+$/";
        return preg_match($reg,$value);
    }

    static function numeric($value) {
        $reg = "/^[0-9]+$/";
        return preg_match($reg,$value);
    }

    static function numericSpace($value) {
        $reg = "/^[0-9 ]+$/";
        return preg_match($reg,$value);
    }
}