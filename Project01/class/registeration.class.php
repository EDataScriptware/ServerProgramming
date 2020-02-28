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
        
        header("Location: login.php");
    }

    function logIn($user, $password)
    {
        $this->establishConnection();

        $sql = "SELECT * FROM attendee WHERE name='$user' AND password='$password'";
        $result = mysqli_query($this->conn, $sql);


        if (mysqli_num_rows($result) > 0) 
        {
            echo "<p> $sql </p>";
            echo "Account does exist!";
            echo "<p> $result </p>";
        }
        else 
        {
            echo "Account does not exist.";
        }
          

    }

}
?>