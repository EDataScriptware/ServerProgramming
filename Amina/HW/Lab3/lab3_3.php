<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 3 part 3 -->
<?php
    require_once('lab3_1.php');
    // Create a class that inherts from Person
    class BritishPerson extends Person{
        function calculateBMI(){
            $BMI = (705 * ($this->getWeight()*2.205) / (($this->getHeight()/2.54) * ($this->getHeight()/2.54)));
            return $BMI;
        }
    }
?>