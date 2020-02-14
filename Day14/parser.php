<?php

    // The goal of parser.php is for php to accept json files as an input.
    

    var_dump($_POST);

    //decode the JSON string into an object

    $decoded = json_decode($_POST['json']);

    // checks variable description of $decoded
    var_dump($decoded);


    //do something with data
    $hobbies = "";

    // runs a loop through each hobbies
    foreach($decoded->hobby as $v)
    {
        if($v->isHobby)
        {
            $hobbies.= $v->hobbyName . ",";
        
        
        }
    }

    $hobbies = trim($hobbies, ",");

    //create response

    $json = array(); // or array[]

    $json['send'] = array(
        "name"=>$decoded->firstname,
        "email"=>$decoded->email,
        "hobbies"=>$hobbies);

        $json['errorsNum'] = 2;
        $json['error']= array();
        $json['error'][] = "Wrong email!";
        $json['error'][] = "Wrong hobbies!";

        //encode the array
        $encoded = json_encode($json);
        
        die($encoded); //or echo etc.
        
?>