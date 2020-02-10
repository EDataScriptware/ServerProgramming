<?php 
// http://serenity.ist.rit.edu/~emr9018/341/Labs/Lab03/lab3_3.php

require_once('lab3_1.php');

    // Take what already exists in Person but redesign the calculateBMI
    class BritishPerson extends Person
    {
        function calculateBMI()
        {
            $britishWeight = ($this-> getWeight()) / 2.54; // Inches to Centimeters
            $britishHeight = $this-> getHeight()  * 2.205; // Pounds to Kilograms

            // BMI = 705 * wt / (ht * ht) || (ht in inches, wt in lbs) 
            $bmi = ( (705 * $britishWeight) / ($britishHeight * $britishHeight) );
            
            return $bmi;
        }
    }
?>