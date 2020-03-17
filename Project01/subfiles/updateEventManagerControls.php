<?php
    require_once("../class/events.class.php");

    if (!isset($_SESSION['user']) || !isset($_SESSION['userID']) || !isset($_SESSION['role']) ) 
    {
        header("location: login.php");
    }
    
    $db_event = new Events();
    $db_event->establishConnection();
    $eventID = $_SESSION['eventID'];

    $eventResultObject = $db_event->getEventObject($eventID);
    $rows = mysqli_fetch_all($eventResultObject);


    $eventID = $rows[0][0];
    $eventName = $rows[0][1];
    $eventStart = $rows[0][2];
    $eventEnd = $rows[0][3];
    $eventCapacity = $rows[0][4];
    $eventVenue = $rows[0][5];

    $eventStartArray = preg_split("/[\s,]+/", $eventStart);
    $eventEndArray = preg_split("/[\s,]+/", $eventEnd);

    $eventStartDate = $eventStartArray[0];
    $eventStartTime = $eventStartArray[1];
    
    $eventEndDate = $eventEndArray[0];
    $eventEndTime = $eventEndArray[1];

    echo "<title>Event Controller</title>";

    echo "<h1>Event Page</h1>";
    echo "<form method='POST'>";
    echo "<p> Event Name: <input type='text' id='event_name' name='event_name' value='$eventName'></p>";
    echo "<p> Start Date and Time: <input type='date' id='event_startDate' name='event_startDate' value='$eventStartDate'><input type='time' id='event_startTime' name='event_startTime' value='$eventStartTime'></p>";
    echo "<p> End Date and Time: <input type='date' id='event_endDate' name='event_endDate'value='$eventEndDate'><input type='time' id='event_endTime' name='event_endTime' value='$eventEndTime'></p>";
    echo "<p> Capacity: <input type='text' id='event_capacity' name='event_capacity' value='$eventCapacity'></p>";
    
    $db_event->getAllSelectedMenuVenues();
    
    echo "<input type='submit' name='updateEvent' value='Update'>";
    echo "<input type='submit' name='deleteEvent' value='Delete This Event'>";
    echo "<input type='submit' name='goBack' value='Go Back'>";
       echo "</form>";

    if (isset($_POST['goBack']))
    {
        header("location: ../eventManager.php");
    }

    if (isset($_POST["deleteEvent"]))
    {
        $db_event->deleteEvent($eventID);
        header("location: ../eventManager.php");
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


        $db_event->updateEvent($eventID, $newEventName, $newEventStart, $newEventEnd, $newEventCapacity, $newEventVenue);
        header("location: ../eventManager.php");
    }
    
    
?>