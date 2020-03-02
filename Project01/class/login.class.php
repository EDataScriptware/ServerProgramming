<?php 
class DBL 
{
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
    

function logIn($user, $password)
    {
        $this->establishConnection();

        $sql = "SELECT * FROM attendee WHERE name='$user' AND password='$password'";
        $result = mysqli_query($this->conn, $sql);


        if (mysqli_num_rows($result) == 1)
        {
            // echo "<p> $sql </p>";
            // echo "Account does exist!";
            $sql = "SELECT role, idattendee FROM attendee WHERE name='$user' AND password='$password'";

            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_row($result);

            $_SESSION['user'] = $user;
            $_SESSION['role'] = $row[0];
            $_SESSION['userID'] = $row[1];
            
            // echo $row[0];

            header("Location: events.php");
        }
        else 
        {
            echo "Login Error!";
        }
          

    }

}
?>