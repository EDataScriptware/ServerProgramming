<?php
// http://serenity.ist.rit.edu/~emr9018/341/Labs/Lab03/lab3_2.php
    require_once('lab3_1.php');
    
    // Instantiating Object
    $personObject = new Person("Edward", "Riley");

    $personObject->setHeight(71);     // Inches
    $personObject->setWeight(140);    // Pounds

    $lastName = $personObject->getLastName();
    $firstName = $personObject->getFirstName();
    $bmi = $personObject->calculateBMI(); // Unable to cut down on the trailing numbers. Oh well.

    echo "<p>An American, " . $firstName . " " . $lastName . "'s BMI of ". $bmi . "! This is normal for Americans!</p>";
?>