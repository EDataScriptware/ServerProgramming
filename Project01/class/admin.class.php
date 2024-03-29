<?php
session_start();
ob_start();

class Admin {
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

    function goBackButton()
    {
        echo "<form method='POST'> <button type='submit' name='toEventPage' class='button'>Back to Events Page?</button></form>";
                
        if (isset($_POST['toEventPage']))
        {
            header("location: events.php");
        }

    }
    
    function getAllUsers()
    {
        $sql = "SELECT * FROM attendee";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<div class ='pushdown'><div class='bigbox'><h2>All Users</h2>";
        echo "<form method='POST'> <button type='submit' name='createUser' value='createUser' class='button' >CREATE NEW USER</button></form>";
        
        if (isset($_POST["createUser"]))
        {
            header("location: subfiles/createUserAdminControls.php");
        }

        while ($row < $numberOfRows)
        {
            $userID = $rows[$row][0];
            $username = $rows[$row][1];
            $role = $rows[$row][3];
           
                switch ($role)
                {
                    case 3:
                        $role = "Attendee";
                    break;
                    case 2: 
                        $role = "Event Manager";
                    break;
                    case 1:
                        $role = "Administrator";
                    break;
                }

                echo "<div class='box'>";
                echo "<p><b>ID Attendee:</b> " . $userID . "</p><p><b>Username:</b> " . $username . "</p><p><b>Role:</b> " . $role . "</p>";
                // $this->getAllUserSessions($userID);
                
                $deleteUserString = 'delete' . $userID . 'user';
                $updateUserString = 'update' . $userID . 'user';
                
                echo "<form method='POST' class='inline'> <button type='submit' name='$deleteUserString' value='$userID' class='button' >DELETE <strong> $username </strong>?</button></form>";
                echo "<form method='POST' class='inline'> <button type='submit' name='$updateUserString' value='$userID' class='button' >UPDATE <strong> $username </strong>?</button></form>";

                if (isset($_POST["delete".$userID."user"]))
                {
                    if ($userID == 1)
                    {
                       echo "<p class='errorMessage'> You cannot delete Master Admin!</p>";
                    }
                    else 
                    {
                        $this->deleteUserAccount($userID);
                        header("location: adminControls.php");
                    }
                }

                if (isset($_POST["update".$userID."user"]))
                {
                    $_SESSION['userID_pass'] = $userID;
                    $_SESSION['username_pass'] = $username;
                    $_SESSION['role_pass'] = $role;
                    header("location: subfiles/updateUserAdminControls.php");
                  
                }
                echo "</div>";

                $row += 1;

        }
        echo "</div></div>";
    }

    function deleteUserAccount($userID)
    {
        $sql = "DELETE FROM attendee WHERE idattendee = '$userID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }

    function deleteVenue($venueID)
    {
        $sql = "DELETE FROM venue WHERE idvenue = '$venueID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }

    function updateUserAccount($userID, $username, $role)
    {
       
        $sql = "UPDATE attendee SET name=\"$username\", role=$role WHERE idattendee=$userID";
        echo $sql;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }
    function updateVenue($newVenueID, $newVenueName, $newVenueCapacity)
    {
        $sql = "UPDATE venue SET name=\"$newVenueName\", capacity=$newVenueCapacity WHERE idvenue=$newVenueID";
        echo $sql;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }

    function getAllUserSessions($userID)
    {
        $sql = "SELECT * FROM attendee_session WHERE attendee='$userID'";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "Number of Rows: " . $numberOfRows;

        if ($numberOfRows =! 0)
        {
            echo "<h3>Attending Sessions</h3>";
            
            while ($row < $numberOfRows)
            {
                echo "Current Row: " . $row;
                echo "<p>Session Number: " . $rows[$row][0] . "</p>";
                $row = $row + 1;
            }
        }
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
    function checkSessionIdExists($sessionID)
    {
        $this->establishConnection();

        $sql = "SELECT * FROM session WHERE idsession='$sessionID'";
        $result = mysqli_query($this->conn, $sql);


        if (mysqli_num_rows($result) >= 1)
        {
            // session id exists
            return true;
        }
        else 
        {
            // session id does not exists
            return false;
        }
    }

    function insertSessionRow($sessionID, $sessionName, $startDatetime, $endDatetime, $capacity, $eventID)
    {
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO session (idsession, name, numberallowed, event, startdate, enddate) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $sessionID, $sessionName, $capacity, $eventID, $startDatetime, $endDatetime);

        $stmt->execute();
      
        echo "Session created!";

        $stmt->close();
        $this->conn->close();  
        
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



    function getAllVenues()
    {
        $sql = "SELECT * FROM venue";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<div class='bigbox'><h2>All Venues</h2>";
        echo "<form method='POST'> <button type='submit' name='createVenue' value='createVenue' class='button' >CREATE NEW VENUE</button></form>";
        
        if (isset($_POST["createVenue"]))
        {
            header("location: subfiles/createVenueAdminControls.php");
        }

        while ($row < $numberOfRows)
        {
           
                echo "<div class='box'>";
                echo "<p><b>ID Venue:</b> " . $rows[$row][0] . "</p><p><b>Venue Name:</b> " . $rows[$row][1] . "</p><p><b>Capacity:</b> " . $rows[$row][2] . "</p>";
                echo "<form method='POST' class='inline'> <button type='submit' name='delete" . $rows[$row][0] . "venue' value='" . $rows[$row][0] . "' class='button'>DELETE <strong>" . $rows[$row][1] . "</strong>?</button></form>";
                echo "<form method='POST' class='inline'> <button type='submit' name='update" . $rows[$row][0] . "venue' value='" . $rows[$row][0] . "' class='button'>UPDATE <strong>" . $rows[$row][1] . "</strong>?</button></form>";
                echo "</div>";

                if (isset($_POST["delete". $rows[$row][0]."venue"]))
                {
                    $this->deleteVenue($rows[$row][0]);
                    header("location: adminControls.php");
                }

                if (isset($_POST["update".$rows[$row][0]."venue"]))
                {
                    $_SESSION['venueID_pass'] = $rows[$row][0];
                    $_SESSION['venuename_pass'] = $rows[$row][1];
                    $_SESSION['venuecapacity_pass'] = $rows[$row][2];
                    header("location: subfiles/updateVenueAdminControls.php");
                  
                }
            $row += 1;


        }
        echo "</div>";
    }

    function getAllSessions()
    {
        $sql = "SELECT * FROM session";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<div class='bigbox'><h2>All Sessions</h2>";
        echo "<form method='POST'> <button type='submit' name='createSession' value='createSession' class='button'>CREATE NEW SESSION</button></form>";
        
        if (isset($_POST["createSession"]))
        {
            header("location: subfiles/createSessionAdminControls.php");
        }
        
        while ($row < $numberOfRows)
        {
            $eventName = $this->getAssociatedEvent($rows[$row][3]);
            echo "<div class='box'>";
            echo "<p>Session ID: " . $rows[$row][0] . "</p><p>Session Name: " . $rows[$row][1] . "</p><p>Capacity: " . $rows[$row][2] . "</p><p>Associated with Event: " 
                . $eventName . "</p><p>Start Date: " . $rows[$row][4] . "</p><p>End Date: " . $rows[$row][5] . "</p>";
                
                $deleteSessionString = 'delete' . $rows[$row][0] . 'session';
                $updateSessionString = 'update' . $rows[$row][0] . 'session';

                $sessionID = $rows[$row][0];
                $sessionName = $rows[$row][1];
                
                
                echo "<form method='POST' class='inline'> <button type='submit' name='$deleteSessionString' value='$sessionID' class='button' >DELETE <strong> $sessionName </strong>?</button></form>";
                echo "<form method='POST' class='inline'> <button type='submit' name='$updateSessionString' value='$sessionID' class='button' >UPDATE <strong> $sessionName </strong>?</button></form>";

                echo "</div>";
                if (isset($_POST["delete". $rows[$row][0]."session"]))
                {
                    $this->deleteSession($rows[$row][0]);
                    header("location: adminControls.php");
                }

                if (isset($_POST["update".$rows[$row][0]."session"]))
                {
                    $_SESSION['sessionID_pass'] = $rows[$row][0];
                    $_SESSION['sessionname_pass'] = $rows[$row][1];
                    $_SESSION['sessioncapacity_pass'] = $rows[$row][2];
                    $_SESSION['sessionevent_pass'] = $rows[$row][3];
                    $_SESSION['sessionstart_pass'] = $rows[$row][4];
                    $_SESSION['sessionend_pass'] = $rows[$row][5];
                    
                    header("location: subfiles/updateSessionAdminControls.php");
                  
                }
                
            $row += 1;
        }
        echo "</div>";
    }

    function updateSession($newSessionID, $newSessionName, $newSessionStartDate, $newSessionEndDate, $newSessionCapacity, $newSessionEvent)
    {
        $sql = "UPDATE session SET name=\"$newSessionName\", startdate=\"$newSessionStartDate\", enddate=\"$newSessionEndDate\", numberallowed=$newSessionCapacity, event=$newSessionEvent WHERE idsession=$newSessionID";
        echo $sql;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }

    function deleteSession($sessionID)
    {
        $sql = "DELETE FROM session WHERE idsession = '$sessionID'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();    
    }
    function getAssociatedEvent($eventID)
    {
        $this->establishConnection();

        $sql = "SELECT name FROM event WHERE idevent='$eventID'";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) == 1)
        {
            $sql = "SELECT name FROM event WHERE idevent='$eventID'";

            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_row($result);
            
            $eventName = $row[0];

            return $eventName;
        }
        else 
        {
            echo "Fetch EventID Error!";
        }
    }

    function getAllEvents()
    {
        $sql = "SELECT * FROM event";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<div class='bigbox'><h2>All Events</h2>";
        echo "<form method='POST'> <button type='submit' name='createEvent' value='createEvent' class='button' >CREATE NEW EVENT</button></form>";
        
        if (isset($_POST["createEvent"]))
        {
            header("location: subfiles/createEventAdminControls.php");
        }

        while ($row < $numberOfRows)
        {
            $venueName = $this->getAssociatedVenue($rows[$row][5]);

            $deleteEventString = 'delete' . $rows[$row][0] . 'event';
            $updateEventString = 'update' . $rows[$row][0] . 'event';
            echo "<div class='box'>";
                echo "<p>Event ID: " . $rows[$row][0] . "</p><p>Event Name: " . $rows[$row][1] . "</p><p>Start Date:" . $rows[$row][2] . "</p><p>End Date: " 
                . $rows[$row][3] . "</p><p>Capacity: " . $rows[$row][4] . "</p><p>Venue: " . $venueName . "</p>";
                echo "<form method='POST' class='inline'> <button type='submit' name='$deleteEventString' value='" . $rows[$row][0] . "' class='button'>DELETE <strong>" . $rows[$row][1] . "</strong> ?</button></form>";
                echo "<form method='POST' class='inline'> <button type='submit' name='$updateEventString' value='" . $rows[$row][0] . "' class='button'>UPDATE <strong>" . $rows[$row][1] . "</strong> ?</button></form>";
                
                if (isset($_POST["delete". $rows[$row][0]."event"]))
                {
                    $this->deleteEvent($rows[$row][0]);
                    header("location: adminControls.php");
                }

                if (isset($_POST["update".$rows[$row][0]."event"]))
                {
                    $_SESSION['eventID_pass'] = $rows[$row][0];
                    $_SESSION['eventname_pass'] = $rows[$row][1];
                    $_SESSION['eventstart_pass'] = $rows[$row][2];
                    $_SESSION['eventend_pass'] = $rows[$row][3];
                    $_SESSION['eventcapacity_pass'] = $rows[$row][4];
                    $_SESSION['eventvenue_pass'] = $rows[$row][5];
                    
                    header("location: subfiles/updateEventAdminControls.php");
                  
                }
                echo "</div>";
                $row += 1;


        }
        echo "</div>";
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

    function getAssociatedVenue($venueID)
    {
        $this->establishConnection();

        $sql = "SELECT name FROM venue WHERE idvenue='$venueID'";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) == 1)
        {
            $sql = "SELECT name FROM venue WHERE idvenue='$venueID'";

            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_row($result);
            
            $venueName = $row[0];

            return $venueName;
        }
        else 
        {
            // echo "Fetch VenueID Error! - HERE";
            return "ERROR: Venue Not Found!";
        }
    }


    function checkVenueNameExists($venueName)
    {
        
            $this->establishConnection();

            $sql = "SELECT * FROM venue WHERE name='$venueName'";
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

    function checkVenueIdExists($venueName)
    {
        
        $this->establishConnection();

        $sql = "SELECT * FROM venue WHERE name='$venueName'";
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

    function insertVenueRow($venueID, $venueName, $capacity)
    {
        
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO venue (idvenue, name, capacity) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $venueID, $venueName, $capacity);

        $stmt->execute();
      
        echo "Venue created!";

        $stmt->close();
        $this->conn->close();  
        
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

    function checkEventIdExists($eventID)
    {
        
        $this->establishConnection();

        $sql = "SELECT * FROM event WHERE idevent='$eventID'";
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

    

    function insertEventRow($eventID, $eventName, $startDatetime, $endDatetime, $capacity, $venueID)
    {
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO event (idevent, name, datestart, dateend, numberallowed, venue) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $eventID, $eventName, $startDatetime, $endDatetime, $capacity, $venueID);

        $stmt->execute();
      
        echo "Event created!";

        $stmt->close();
        $this->conn->close();  
        
    }
}
?>