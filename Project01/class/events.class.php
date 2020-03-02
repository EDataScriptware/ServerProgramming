<?php 
class Events
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

    function getAllEventsUnderSpecificUser($userID)
    {
        $sql = "SELECT * FROM attendeeEvent WHERE attendee = '$userID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        while ($row < $numberOfRows)
        {




        }
    }
}

?>