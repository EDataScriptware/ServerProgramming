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
        echo "<h2>All Users</h2><hr>";

        while ($row < $numberOfRows)
        {
            $userID = $rows[$row][0];
            $username = $rows[$row][1];
            $role = $rows[$row][3];
           
                echo "<p>ID Attendee: " . $userID . "</p><p>Username: " . $username . "</p><p>Role: " . $role . "</p>";
                // $this->getAllUserSessions($userID);
                
                echo "<form method='POST'> <button type='submit' name='delete$userID' value='$userID' >DELETE $username ?</button></form>";
                echo "<form method='POST'> <button type='submit' name='update$userID' value='$userID' >UPDATE $username ?</button></form>";

                if (isset($_POST["delete".$userID]))
                {
                    $this->deleteUserAccount($userID);
                    header("location: adminControls.php");
                }

                if (isset($_POST["update".$userID]))
                {
                    $_SESSION['userID_pass'] = $userID;
                    $_SESSION['username_pass'] = $username;
                    $_SESSION['role_pass'] = $role;
                    header("location:  subfiles/updateUserAdminControls.php");
                  
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

    function updateUserAccount($userID, $username, $role)
    {
       
        $sql = "UPDATE attendee SET name=\"$username\", role=$role WHERE idattendee=$userID";
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




    function getAllVenues()
    {
        $sql = "SELECT * FROM venue";
        $result = mysqli_query($this->conn, $sql);
        $rows = mysqli_fetch_all($result);
        $row = 0;
        $numberOfRows = mysqli_num_rows($result);
        echo "<h2>All Venues</h2><hr>";

        while ($row < $numberOfRows)
        {
           
                echo "<p>ID Venue: " . $rows[$row][0] . "</p><p>Venue Name: " . $rows[$row][1] . "</p><p>Capacity: " . $rows[$row][2] . "</p><hr>";
            
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
        echo "<h2>All Sessions</h2><hr>";
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
        echo "<h2>All Events</h2><hr>";

        while ($row < $numberOfRows)
        {
            $venueName = $this->getAssociatedVenue($rows[$row][5]);


            echo "<p>Event ID: " . $rows[$row][0] . "</p><p>Event Name: " . $rows[$row][1] . "</p><p>Start Date:" . $rows[$row][2] . "</p><p>End Date: " 
                . $rows[$row][3] . "</p><p>Capacity: " . $rows[$row][4] . "</p><p>Venue: " . $venueName . "</p><hr>";
            
            $row += 1;


        }
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
            echo "Fetch VenueID Error!";
        }
    }
}
?>