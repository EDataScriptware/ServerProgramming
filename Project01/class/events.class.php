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

    function getEventObject($eventIDs)
    {
        $sql = "SELECT * FROM event WHERE idevent = '$eventIDs'";
        $result = mysqli_query($this->conn, $sql);
        // $rows = mysqli_fetch_all($result);
        // $row = 0;
        // $numberOfRows = mysqli_num_rows($result);

        // while ($row < $numberOfRows)
        // {
        //     return $rows[$row][1];
        //     $row += 1;
        // }

        return $result;

    }

    function eventManagerGetEventButtons($eventIDs)
    {
        $sql = "SELECT * FROM event WHERE idevent = '$eventIDs'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        for ($row = 0; $row < $numberOfRows; $row++)
        {
            $deleteEventString = 'delete' . $rows[$row][0] . 'event';
            $updateEventString = 'update' . $rows[$row][0] . 'event';
            
            // echo "<p>Event #" . ($row + 1) . ": " . $rows[$row][1] . "</p>";
            
            return "<form method='POST'> <button type='submit' name='$deleteEventString' value='" . $rows[$row][0] . "' >DELETE " . $rows[$row][1] . " ?</button></form>"
            . "<form method='POST'> <button type='submit' name='$updateEventString' value='" . $rows[$row][0] . "' >UPDATE " . $rows[$row][1] . " ?</button></form><hr>";

            
        }
    }

    function eventManagerGetEventNames($eventIDs)
    {
        $sql = "SELECT * FROM event WHERE idevent = '$eventIDs'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        for ($row = 0; $row < $numberOfRows; $row++)
        {
           
            return $rows[$row][1];

            // return "<form method='POST'> <button type='submit' name='$deleteEventString' value='" . $rows[$row][0] . "' >DELETE " . $rows[$row][1] . " ?</button></form>"
            //. "<form method='POST'> <button type='submit' name='$updateEventString' value='" . $rows[$row][0] . "' >UPDATE " . $rows[$row][1] . " ?</button></form><hr>";
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

        echo "<form method='POST'> <button type='submit' name='createEvent' value='createEvent'>CREATE NEW EVENT</button></form><hr>";

        if (isset($_POST['createEvent']))
        {
            header("location: subfiles/createEventManagerControls.php");
        }

        while ($row < $numberOfRows)
        {
            $fullNames = $this->eventManagerGetEventNames($rows[$row][0]);
            $fullButtons = $this->eventManagerGetEventButtons($rows[$row][0]);

            echo "<p>Event #" . ($row + 1) . ": " . $fullNames . "</p>";
            
            echo $fullButtons;

            if (isset($_POST["update".$rows[$row][0]."event"]))
            {
                $_SESSION['eventID'] = $rows[$row][0];
                header("location: subfiles/updateEventManagerControls.php");
            }

            if (isset($_POST["delete".$rows[$row][0]."event"]))
            {
                $this->deleteEvent($rows[$row][0]);
                header("location: eventManager.php");
            }

            $row += 1;
        }

    }

    function getEventManagerCreatedSessions()
    {

    }

    function getAllSelectedMenuVenues()
    {
        $sql = "SELECT * FROM venue";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
    
        echo '<p>Venue: <select id="event_selectedVenue" name="event_selectedVenue">';
        while ($row < $numberOfRows)
        {
            echo '<option value="'. $rows[$row][0] .'">' . $rows[$row][1] .'</option>';

            $row = $row + 1;
        }
        echo '</select></p>';
    }

    function deleteEvent($eventID)
    {
        $sql = "DELETE FROM event WHERE idevent = '$eventID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();  

        $this->deleteEventOwnership($eventID);  
    }

    function deleteEventOwnership($eventID)
    {
        $sql = "DELETE FROM manager_event WHERE event = '$eventID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }

    function updateEvent($newEventID, $newEventName, $newEventStartDate, $newEventEndDate, $newEventCapacity, $newEventVenue)
    {
        $sql = "UPDATE event SET name=\"$newEventName\", datestart=\"$newEventStartDate\", dateend=\"$newEventEndDate\", numberallowed=$newEventCapacity, venue=$newEventVenue WHERE idevent=$newEventID";
        echo $sql;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }

    function insertEventRow($eventName, $startDatetime, $endDatetime, $capacity, $venueID)
    {
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO event (name, datestart, dateend, numberallowed, venue) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $eventName, $startDatetime, $endDatetime, $capacity, $venueID);

        $stmt->execute();
      
        echo "Event created!";

        $stmt->close();
        $this->conn->close();  
        
    }

    function registerEventOwnership($eventID, $managerID)
    {
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO manager_event (event, manager) VALUES (?, ?)");
        $stmt->bind_param("ii", $eventID, $managerID);

        $stmt->execute();
      
        echo "Event Registered!";

        $stmt->close();
        $this->conn->close();  
    }

    function getSpecificIDBasedOnName($eventName)
    {
        $this->establishConnection();

        $sql = "SELECT * FROM event WHERE name='$eventName'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);

        return $rows[0][0];
        

    }

    function checkEventNameExists($eventName)
    {
        
            $this->establishConnection();

            $sql = "SELECT * FROM event WHERE name='$eventName'";
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
}

?>