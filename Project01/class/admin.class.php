<?php
session_start();

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


    function getAllUsers()
    {
        $sql = "SELECT * FROM attendee";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<h2>All Users</h2>";
        echo "<form method='POST'> <button type='submit' name='createUser' value='createUser'>CREATE NEW USER</button></form><hr>";
        
        if (isset($_POST["createUser"]))
        {
            header("location: subfiles/createUserAdminControls.php");
        }

        while ($row < $numberOfRows)
        {
            $userID = $rows[$row][0];
            $username = $rows[$row][1];
            $role = $rows[$row][3];
           
                echo "<p>ID Attendee: " . $userID . "</p><p>Username: " . $username . "</p><p>Role: " . $role . "</p>";
                // $this->getAllUserSessions($userID);
                
                $deleteUserString = 'delete' . $userID . 'user';
                $updateUserString = 'update' . $userID . 'user';
                
                echo "<form method='POST'> <button type='submit' name='$deleteUserString' value='$userID' >DELETE $username ?</button></form>";
                echo "<form method='POST'> <button type='submit' name='$updateUserString' value='$userID' >UPDATE $username ?</button></form>";

                if (isset($_POST["delete".$userID."user"]))
                {
                    $this->deleteUserAccount($userID);
                    header("location: adminControls.php");
                }

                if (isset($_POST["update".$userID."user"]))
                {
                    $_SESSION['userID_pass'] = $userID;
                    $_SESSION['username_pass'] = $username;
                    $_SESSION['role_pass'] = $role;
                    header("location: subfiles/updateUserAdminControls.php");
                  
                }
                $row += 1;
                echo "<hr>";

        }
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
        echo "<h2>All Venues</h2>";
        echo "<form method='POST'> <button type='submit' name='createVenue' value='createVenue'>CREATE NEW VENUE</button></form><hr>";
        
        if (isset($_POST["createVenue"]))
        {
            header("location: subfiles/createVenueAdminControls.php");
        }

        while ($row < $numberOfRows)
        {
           
                echo "<p>ID Venue: " . $rows[$row][0] . "</p><p>Venue Name: " . $rows[$row][1] . "</p><p>Capacity: " . $rows[$row][2] . "</p>";
                echo "<form method='POST'> <button type='submit' name='delete" . $rows[$row][0] . "venue' value='" . $rows[$row][0] . "' >DELETE " . $rows[$row][1] . " ?</button></form>";
                echo "<form method='POST'> <button type='submit' name='update" . $rows[$row][0] . "venue' value='" . $rows[$row][0] . "' >UPDATE " . $rows[$row][1] . " ?</button></form><hr>";

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
    }

    function getAllSessions()
    {
        $sql = "SELECT * FROM session";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<h2>All Sessions</h2>";
        echo "<form method='POST'> <button type='submit' name='createSession' value='createSession'>CREATE NEW SESSION</button></form><hr>";
        
        if (isset($_POST["createSession"]))
        {
            header("location: subfiles/createSessionAdminControls.php");
        }
        
        while ($row < $numberOfRows)
        {
            $eventName = $this->getAssociatedEvent($rows[$row][3]);
            echo "<p>Session ID: " . $rows[$row][0] . "</p><p>Session Name: " . $rows[$row][1] . "</p><p>Capacity: " . $rows[$row][2] . "</p><p>Associated with Event: " 
                . $eventName . "</p><p>Start Date: " . $rows[$row][4] . "</p><p>End Date: " . $rows[$row][5] . "</p><hr>";
            
            $row += 1;
        }
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
        echo "<h2>All Events</h2>";
        echo "<form method='POST'> <button type='submit' name='createEvent' value='createEvent'>CREATE NEW EVENT</button></form><hr>";
        
        if (isset($_POST["createEvent"]))
        {
            header("location: subfiles/createEventAdminControls.php");
        }

        while ($row < $numberOfRows)
        {
            $venueName = $this->getAssociatedVenue($rows[$row][5]);

            $deleteEventString = 'delete' . $rows[$row][0] . 'event';
            $updateEventString = 'update' . $rows[$row][0] . 'event';

                echo "<p>Event ID: " . $rows[$row][0] . "</p><p>Event Name: " . $rows[$row][1] . "</p><p>Start Date:" . $rows[$row][2] . "</p><p>End Date: " 
                . $rows[$row][3] . "</p><p>Capacity: " . $rows[$row][4] . "</p><p>Venue: " . $venueName . "</p>";
                echo "<form method='POST'> <button type='submit' name='$deleteEventString' value='" . $rows[$row][0] . "' >DELETE " . $rows[$row][1] . " ?</button></form>";
                echo "<form method='POST'> <button type='submit' name='$updateEventString' value='" . $rows[$row][0] . "' >UPDATE " . $rows[$row][1] . " ?</button></form><hr>";
                
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
                
                $row += 1;


        }
    }

    function deleteEvent($venueID)
    {
        $sql = "DELETE FROM event WHERE idevent = '$venueID'";
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