<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 3 part 1 -->
<?php
    // Create a class Person
    class Person{
        // Instance variables
        private $fName, $lName, $height, $weight;

        // Default Constructor
        function __construct($fName = "Sam", $lName = "Spade"){
            $this->fName = $fName;
            $this->lName = $lName;
        }

        // Accessors and mutators 
        function getFirstName(){
            return $this->fName;
        }

        function getLastName(){
            return $this->lName;
        }

        function getHeight(){
            return $this->height;
        }

        function getWeight(){
            return $this->weight;
        }

        function setFirstName($fName){
            $this->fName = $fName;     
        }

        function setLastName($lName){
            $this->lName = $lName;     
        }

        function setHeight($height){
            $this->height = $height;     
        }

        function setWeight($weight){
            $this->weight = $weight;     
        }

        // Function to calculate and return BMI
        function calculateBMI(){
            $BMI = (705 * $this->weight / ($this->height * $this->height));
            return $BMI;
        }
    }