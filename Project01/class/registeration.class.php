<?php
ob_start();

class DBR
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
        

    } // establish connection

    function insertRow($user, $password, $role)
    {
        
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO attendee (name, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $user, $password, $role);

        $stmt->execute();
      
        echo "Account created!";

        $stmt->close();
        $this->conn->close();  
        
    }

    function insertAdminRow($user, $password, $role, $userID)
    {
        
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO attendee (idattendee, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $userID, $user, $password, $role);

        $stmt->execute();
      
        echo "Account created!";

        $stmt->close();
        $this->conn->close();  
        
    }

    

    function checkAccountExists($user)
    {
        
            $this->establishConnection();

            $sql = "SELECT * FROM attendee WHERE name='$user'";
            $result = mysqli_query($this->conn, $sql);


            if (mysqli_num_rows($result) >= 1)
            {
                // account exists
                return true;
            }
            else 
            {
                // account does not exists
                return false;
            }
    }

    function checkUserIDExists($user)
    {
        
            $this->establishConnection();

            $sql = "SELECT * FROM attendee WHERE idattendee='$user'";
            $result = mysqli_query($this->conn, $sql);


            if (mysqli_num_rows($result) >= 1)
            {
                // userID exists
                return true;
            }
            else 
            {
                // userID does not exists
                return false;
            }
    }

}
?>