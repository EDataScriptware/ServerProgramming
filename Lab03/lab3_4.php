<?php
// http://serenity.ist.rit.edu/~emr9018/341/Labs/Lab03/lab3_4.php


require_once('lab3_3.php');
    
// Instantiating Object
$personObject = new BritishPerson("Edgard", "Riley");

$personObject->setHeight(180.34);     // Centimeters
$personObject->setWeight(63.5029);    // Pounds

$lastName = $personObject->getLastName();
$firstName = $personObject->getFirstName();
$bmi = $personObject->calculateBMI(); // Unable to cut down on the trailing numbers. Oh well.

echo "<p> An Englishman, " . $firstName . " " . $lastName . "'s BMI of ". $bmi . "! This is normal for Englishmen!</p>";

?>