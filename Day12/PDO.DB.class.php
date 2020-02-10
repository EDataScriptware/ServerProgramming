<?php 
    class DB{
        private $dbh;
        


        function __construct(){
            try
            {
                $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}", 
                $_SERVER['emr9018'], $_SERVER['billbring']);
            }
            catch (PDOException $pe)
            {
                echo $pe->getMessage();
                die("Bad Database");
            }
        } // end construct
    } // end DB

?>