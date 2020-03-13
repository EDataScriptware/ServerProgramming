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

    function eventManagerGetEventNames($eventIDs)
    {
        $sql = "SELECT * FROM event WHERE idevent = '$eventIDs'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        while ($row < $numberOfRows)
        {

            $deleteEventString = 'delete' . $rows[$row][0] . 'event';
            $updateEventString = 'update' . $rows[$row][0] . 'event';
            
            echo "<p>Event #" . ($row + 1). ": " . $rows[$row][1] . "</p>";

            echo "<form method='POST'> <button type='submit' name='$deleteEventString' value='" . $rows[$row][0] . "' >DELETE " . $rows[$row][1] . " ?</button></form>";
            echo "<form method='POST'> <button type='submit' name='$updateEventString' value='" . $rows[$row][0] . "' >UPDATE " . $rows[$row][1] . " ?</button></form><hr>";
      
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

    function getAllCreatedEvents($managerID)
    {
  
        $sql = "SELECT * FROM manager_event WHERE manager = '$managerID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        while ($row < $numberOfRows)
        {
            $this->eventManagerGetEventNames($rows[$row][0]);
            
            $row += 1;
        }

    }

    function getEventManagerCreatedSessions()
    {

    }



}

?>