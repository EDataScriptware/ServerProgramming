<?php

class Person
{
    private $last, $first;

    function __construct($last="TBD", $firstName="TBD")
    {
        $this->last = $last;
        $this->first = $firstName;
    }

    function getFirstName()
    {
        return $this->first;
    }

    function getLastName()
    {
        return $this->last;
    }

    function sayHello()
    {
        return "Hi there! My first name is {$this->first} and my last name is {$this->getLastName()} <b />";
    }




}



?>