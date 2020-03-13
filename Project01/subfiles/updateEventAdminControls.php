<?php
    require_once("../class/admin.class.php");

    $db_admin = new Admin();
    $db_admin->establishConnection();
    

    $eventID = $_SESSION['eventID_pass'];
    $eventName = $_SESSION['eventname_pass'];
    $eventCapacity = $_SESSION['eventcapacity_pass'];
    $eventStart = $_SESSION['eventstart_pass'];
    $eventEnd = $_SESSION['eventend_pass'];
    $eventVenue = $_SESSION['eventvenue_pass'];

    $eventStartArray = preg_split("/[\s,]+/", $eventStart);
    $eventEndArray = preg_split("/[\s,]+/", $eventEnd);

    $eventStartDate = $eventStartArray[0];
    $eventStartTime = $eventStartArray[1];
    
    $eventEndDate = $eventEndArray[0];
    $eventEndTime = $eventEndArray[1];

    echo "<title>Administrator Event</title>";

    echo "<h1>Administrator Event Page</h1>";
    echo "<form method='POST'>";
    echo "<p> Event Name: <input type='text' id='event_name' name='event_name' value='$eventName'></p>";
    echo "<p> Start Date and Time: <input type='date' id='event_startDate' name='event_startDate' value='$eventStartDate'><input type='time' id='event_startTime' name='event_startTime' value='$eventStartTime'></p>";
    echo "<p> End Date and Time: <input type='date' id='event_endDate' name='event_endDate'value='$eventEndDate'><input type='time' id='event_endTime' name='event_endTime' value='$eventEndTime'></p>";
    echo "<p> Capacity: <input type='text' id='event_capacity' name='event_capacity' value='$eventCapacity'></p>";
    
    $db_admin->getAllSelectedMenuVenues();
    
    echo "<input type='submit' name='updateEvent' value='Update'>";
    echo "<input type='submit' name='deleteEvent' value='Delete This Event'>";
    echo "<input type='submit' name='goBack' value='Go Back'>";
       echo "</form>";

    if (isset($_POST['goBack']))
    {
        header("location: ../adminControls.php");
    }

    if (isset($_POST["deleteEvent"]))
    {
        $db_admin->deleteEvent($eventID);
        header("location: ../adminControls.php");
    }

    if (isset($_POST["updateEvent"]))
    {
        $newEventName = $_POST['event_name'];
        $newEventStartDate = $_POST['event_startDate'];
        $newEventStartTime = $_POST['event_startTime'];
        $newEventEndDate = $_POST['event_endDate'];
        $newEventEndTime = $_POST['event_endTime'];
        $newEventCapacity = $_POST['event_capacity'];
        $newEventVenue = $_POST['event_selectedVenue'];

        $newEventStart = $newEventStartDate . " " . $newEventStartTime;
        $newEventEnd = $newEventEndDate . " " . $newEventEndTime;


        $db_admin->updateEvent($eventID, $newEventName, $newEventStart, $newEventEnd, $newEventCapacity, $newEventVenue);
        header("location: ../adminControls.php");
    }
    
?>