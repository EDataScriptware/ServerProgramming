<?php 
session_start();

class Attendee
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

    function getAllSessions($userID)
    {
        $sql = "SELECT * FROM session";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<h2>All Available Sessions To Register</h2>";
       
        while ($row < $numberOfRows)
        {
            $eventName = $this->getAssociatedEvent($rows[$row][3]);
            echo "<p>Session Name: " . $rows[$row][1] . "</p><p>Capacity: " . $rows[$row][2] . "</p><p>Associated with Event: " 
                . $eventName . "</p><p>Start Date: " . $rows[$row][4] . "</p><p>End Date: " . $rows[$row][5] . "</p>";
                
                $registerSessionString = 'register' . $rows[$row][0] . 'session';

                $sessionID = $rows[$row][0];
                $sessionName = $rows[$row][1];
                
                echo "<form method='POST'> <button type='submit' name='$registerSessionString' value='$sessionID' >REGISTER FOR <strong> $sessionName </strong>?</button></form><hr>";

               

                if (isset($_POST["register".$rows[$row][0]."session"]))
                {
                    $this->registerForSession($rows[$row][0], $userID);
                    header("location: events.php");
                    // echo $userID;
                }
                
            $row += 1;
        }
    }

    function getAllEvents($userID)
    {
        $sql = "SELECT * FROM event";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<h2>All Available Events To Register</h2>";

        while ($row < $numberOfRows)
        {
            $venueName = $this->getAssociatedVenue($rows[$row][5]);

            $registerEventString = 'register' . $rows[$row][0] . 'event';

                echo "<p>Event Name: " . $rows[$row][1] . "</p><p>Start Date:" . $rows[$row][2] . "</p><p>End Date: " 
                . $rows[$row][3] . "</p><p>Capacity: " . $rows[$row][4] . "</p><p>Venue: " . $venueName . "</p>";
                
                echo "<form method='POST'> <button type='submit' name='$registerEventString' value='" . $rows[$row][0] . "' >REGISTER <strong>" . $rows[$row][1] . "</strong> ?</button></form><hr>";
                
                if (isset($_POST["register".$rows[$row][0]."event"]))
                {
                    $this->registerForEvent($rows[$row][0], $userID);
                    header("location: events.php");
                }

                $row += 1;


        }
    }

    function registerForEvent($eventID, $userID)
    {
        $this->establishConnection();
        $nothing = 0;


        $stmt = $this->conn->prepare("INSERT INTO attendee_event (event, attendee, paid) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $eventID, $userID, $nothing);

        $stmt->execute();
      
        echo "Registered for Event!";

        $stmt->close();
        $this->conn->close();  
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

    


    function registerForSession($sessionID, $userID)
    {
        $this->establishConnection();

        $stmt = $this->conn->prepare("INSERT INTO attendee_session (session, attendee) VALUES (?, ?)");
        $stmt->bind_param("ii", $sessionID, $userID);

        $stmt->execute();
      
        echo "Registered for Session!";

        $stmt->close();
        $this->conn->close();  
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


}