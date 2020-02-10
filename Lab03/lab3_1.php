<?php
// http://serenity.ist.rit.edu/~emr9018/341/Labs/Lab03/lab3_1.php

class Person
{

    private $firstName;
    private $lastName;
    private $height; // in inches
    private $weight; // in pounds
    
        function __construct($firstName = "Sam", $lastName = "Spade")
        {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
        }

        function getFirstName()
        {
            return $this->firstName;
        }
        
        function setFirstName($firstName)
        {
            $this->firstName = $firstName;     
        }

        function getLastName()
        {
            return $this->lastName;
        }
        
        function setLastName($lastName)
        {
            $this->lastName = $lastName;     
        }

        function getHeight()
        {
            return $this->height;
        }

        function setHeight($height)
        {
            $this->height = $height;     
        }
        
        function getWeight()
        {
            return $this->weight;
        }
         
        function setWeight($weight)
        {
            $this->weight = $weight;     
        }
        
        // BMI = 705 * wt / (ht * ht) || (ht in inches, wt in lbs) 
        function calculateBMI()
        {
            $bmi = (705 * $this->weight / ($this->height * $this->height) );
            return $bmi;
        }
    }
?>