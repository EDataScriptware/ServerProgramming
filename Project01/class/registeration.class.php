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

    function insertRow($name, $password, $role)
    {
        
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO attendee (name, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $password, $role);

        $stmt->execute();
      
        echo "New records created successfully";

        $stmt->close();
        $this->conn->close();    
    }

    function checkLogin()
    {
        
    }

}
?>