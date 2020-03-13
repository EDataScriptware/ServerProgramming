<?php 
session_start();

class Events
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

    function getAllEventsUnderSpecificUser($userID)
    {
        $sql = "SELECT * FROM attendee_event WHERE attendee = '$userID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        while ($row < $numberOfRows)
        {
            $eventName = $this->getEventNames($rows[$row][0]);
            echo "<p>Event #" . ($row + 1). ": " . $eventName . "</p>";
            $row += 1;


        }
    }

    function getEventNames($eventIDs)
    {
        $sql = "SELECT * FROM event WHERE idevent = '$eventIDs'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        while ($row < $numberOfRows)
        {
            return $rows[$row][1];
            $row += 1;
        }

    }


    function getAllSessionsUnderSpecificUser($userID)
    {
        $sql = "SELECT * FROM attendee_session WHERE attendee = '$userID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        while ($row < $numberOfRows)
        {
            

            $sessionName = $this->getSessionNames($rows[$row][0]);
            
            echo "<p>Session #" . ($row + 1). ": " . $sessionName . "</p>";

            $row += 1;

        }
    }

    function getSessionNames($sessionID)
    {
        $sql = "SELECT * FROM session WHERE idsession = '$sessionID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        while ($row < $numberOfRows)
        {
            echo $rows[$row][4];
            return $rows[$row][1];
            
            $row += 1;

        }

    }





}

?>