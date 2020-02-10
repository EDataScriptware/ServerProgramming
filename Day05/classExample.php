<?php 
function __autoload($class_name)
{
    // file has to match the class name
    require_once "./classes/$class_name.class.php";
}

    echo "<h2>Static Usage</h2>";
    $number1 = "one";
    $number2 = 23456;
    $number3 = "2";

                                    // true or else false
    $yesNo = (Validator::numeric($number1)) ? "Yes": "No";
    echo "<p>$number1 is a number? $yesNo</p>";

    $yesNo = (Validator::numeric($number2)) ? "Yes": "No";
    echo "<p>$number1 is a number? $yesNo</p>";

    $yesNo = (Validator::numeric($number3)) ? "Yes": "No";
    echo "<p>$number1 is a number? $yesNo</p>";
    
    echo "<h2>Regular Class Usage</h2>";
    $person1 = new Person("Smith", "Bob");
    $person2 = new Person();
    $person3 = new Person("Jones");

    echo "<p>Person 1: {$person1->SayHello()}</p>";
    echo "<p>Person 2: {$person2->SayHello()}</p>";
    echo "<p>Person 3: My last name is {$person3->getLastName()}</p>";

?>