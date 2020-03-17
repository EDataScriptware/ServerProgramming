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


    function goBackButton()
    {
        echo "<form method='POST'> <button type='submit' name='toEventPage' class='button' >Back to Events Page?</button></form>";
                
        if (isset($_POST['toEventPage']))
        {
            header("location: events.php");
        }

    }

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
            echo '<form method="POST"> <button type="submit" class="button" name="unregister' . $rows[$row][0] . 'event" >Unregister <strong>' .$eventName . '</strong> event?</button></form>';
            echo "</p>";
            if (isset($_POST['unregister' . $rows[$row][0] . 'event']))
            {
                $this->unregisterEvent($rows[$row][0], $userID);
                header("location: events.php");
            }

            $row += 1;
        }
    }

    function unregisterEvent($eventID, $attendeeID)
    {
        $sql = "DELETE FROM attendee_event WHERE event = '$eventID' AND attendee = '$attendeeID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
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
            
            return "<form method='POST' > <button type='submit' class='button' name='$deleteEventString' value='" . $rows[$row][0] . "' >DELETE <strong>" . $rows[$row][1] . "</strong> ?</button></form>"
            . "<form method='POST'> <button type='submit' class='button' name='$updateEventString' value='" . $rows[$row][0] . "' >UPDATE <strong>" . $rows[$row][1] . "</strong> ?</button></form>";

            
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
        }
    }

    function eventManagerGetEventNamesSelection($eventIDs)
    {
        $sql = "SELECT * FROM event WHERE idevent = '$eventIDs'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        for ($row = 0; $row < $numberOfRows; $row++)
        {
            return $rows[$row][1];
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
            
            echo "<p class='row'>Session #" . ($row + 1). ": " . $sessionName . "</p>";
            echo '<form method="POST"> <button type="submit" name="unregister' . $rows[$row][0] . 'session" class="button">Unregister <strong>' . $sessionName . '</strong> session?</button></form>';
            
            if (isset($_POST['unregister' . $rows[$row][0] . 'session']))
            {
                $this->unregisterSession($rows[$row][0], $userID);
                header("location: events.php");
            }

            $row += 1;

        }
    }

    function unregisterSession($sessionID, $attendeeID)
    {
        $sql = "DELETE FROM attendee_session WHERE session = '$sessionID' AND attendee = '$attendeeID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
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

        echo "<form method='POST' class='pushdown'> <button type='submit' name='createEvent' value='createEvent' class='button'>CREATE NEW EVENT</button></form>";
        echo "<form method='POST'> <button type='submit' name='createSession' value='createSession' class='button'>CREATE NEW SESSION</button></form>";

        if (isset($_POST['createEvent']))
        {
            header("location: subfiles/createEventManagerControls.php");
        }

        if (isset($_POST['createSession']))
        {
            header("location: subfiles/createSessionManagerControls.php");
        }
        if ($row != 0)
        {
            echo "<div class='bigbox'>";
        }

        while ($row < $numberOfRows)
        {
            echo "<div class='box'>";
            $fullNames = $this->eventManagerGetEventNames($rows[$row][0]);
            $fullButtons = $this->eventManagerGetEventButtons($rows[$row][0]);

            echo "<h2>Event #" . ($row + 1) . ": " . $fullNames . "</h2>";
            
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
            $this->getEventManagerCreatedSessions($rows[$row][0]);
            echo "</div>";
            $row += 1;
        }
        if ($row != 0)
        {
            echo "</div>";
        }
    }

    function getEventManagerCreatedSessions($eventID)
    {
        $sql = "SELECT * FROM session WHERE event = '$eventID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        while ($row < $numberOfRows)
        {
            echo "<div class='littlebox'>";      
            echo "<p>Session #" . ($row + 1). ": " . $rows[$row][1] . "</p>";
                $deleteSessionString = 'delete' . $rows[$row][0] . 'session';
                $updateSessionString = 'update' . $rows[$row][0] . 'session';

                $sessionID = $rows[$row][0];
                $sessionName = $rows[$row][1];
                
                
                echo "<form method='POST'> <button type='submit' name='$deleteSessionString' value='$sessionID' class='button' >DELETE <strong> $sessionName </strong>?</button></form>";
                echo "<form method='POST'> <button type='submit' name='$updateSessionString' value='$sessionID' class='button'>UPDATE <strong> $sessionName </strong>?</button></form>";

                if (isset($_POST["delete". $rows[$row][0]."session"]))
                {
                    $this->deleteSession($rows[$row][0]);
                    header("location: eventManager.php");
                }

                if (isset($_POST["update".$rows[$row][0]."session"]))
                {
                    $_SESSION['sessionID_pass'] = $rows[$row][0];
                    $_SESSION['sessionname_pass'] = $rows[$row][1];
                    $_SESSION['sessioncapacity_pass'] = $rows[$row][2];
                    $_SESSION['sessionevent_pass'] = $rows[$row][3];
                    $_SESSION['sessionstart_pass'] = $rows[$row][4];
                    $_SESSION['sessionend_pass'] = $rows[$row][5];
                    
                    header("location: subfiles/updateSessionManagerControls.php");
                  
                }
                echo "</div>";      
            $row += 1;

        }
    }

    function updateSession($newSessionID, $newSessionName, $newSessionStartDate, $newSessionEndDate, $newSessionCapacity, $newSessionEvent)
    {
        $sql = "UPDATE session SET name=\"$newSessionName\", startdate=\"$newSessionStartDate\", enddate=\"$newSessionEndDate\", numberallowed=$newSessionCapacity, event=$newSessionEvent WHERE idsession=$newSessionID";
        echo $sql;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }
    function checkSessionNameExists($sessionName)
    {
        
            $this->establishConnection();

            $sql = "SELECT * FROM session WHERE name='$sessionName'";
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

    function insertSessionRow($sessionName, $startDatetime, $endDatetime, $capacity, $eventID)
    {
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO session (name, numberallowed, event, startdate, enddate) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiss", $sessionName, $capacity, $eventID, $startDatetime, $endDatetime);

        $stmt->execute();
      
        echo "Session created!";

        $stmt->close();
        $this->conn->close();  
        
    }

    function getAllSelectedMenuEvent()
    {
        $sql = "SELECT * FROM event";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
    
        echo '<p>Venue: <select id="session_selectedEvent" name="session_selectedEvent">';
        while ($row < $numberOfRows)
        {
            echo '<option value="'. $rows[$row][0] .'">' . $rows[$row][1] .'</option>';

            $row = $row + 1;
        }
        echo '</select></p>';
    }

    function getAllSelectedMenuEventManager($managerID)
    {
        $sql = "SELECT * FROM manager_event WHERE manager = '$managerID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);

        echo '<p>Event: <select id="session_selectedEvent" name="session_selectedEvent">';
        while ($row < $numberOfRows)
        {
            $fullNames = $this->eventManagerGetEventNamesSelection($rows[$row][0]);

            echo '<option value="'. $rows[$row][0] .'">' . $fullNames .'</option>';
            
            $row += 1;
        }
        echo '</select></p>';

    }

    function deleteSession($sessionID)
    {
        $sql = "DELETE FROM session WHERE idsession = '$sessionID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
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