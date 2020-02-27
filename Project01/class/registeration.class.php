<?php 
class DB 
{
    private $conn;

    function establishConnection()
    {
        $this->conn = new mysqli(   
                                    $_SERVER['DB_SERVER'],
                                    $_SERVER['DB_USER'],
                                    $_SERVER['DB_PASSWORD'],
                                    $_SERVER['DB']
                                );
        

        if ($this->conn->connect_error)
        {
            echo "Connection Failed: " . mysqli_connect_error();
            die();
        } 
        
    
    } // constructor
}
?>