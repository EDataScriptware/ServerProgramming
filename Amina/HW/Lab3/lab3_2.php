<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 3 part 2 -->
<?php
    require_once('lab3_1.php');
    // Instantiate a Person object
    $person = new Person("Lily","Blossom");
    $person->setHeight(70);
    $person->setWeight(120);

    // Print out a message that states the person's name and BMI
    echo "<h2>".$person->getFirstName()." ".$person->getLastName()." has a BMI of ".$person->calculateBMI()."</h2>";
?>