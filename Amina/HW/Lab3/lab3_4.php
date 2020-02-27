<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 3 part 4 -->
<?php
    require_once('lab3_3.php');
    // Instantiate a BritishPerson object
    $person = new BritishPerson("Amy","Park");
    $person->setHeight(166);
    $person->setWeight(60);

    // Print out a message that states the person's name and BMI
    echo "<h2>".$person->getFirstName()." ".$person->getLastName()." has a BMI of ".$person->calculateBMI()."</h2>";
?>