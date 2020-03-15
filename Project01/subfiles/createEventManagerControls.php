<?php 
require_once("../class/events.class.php");
$managerID = $_SESSION['userID'];

$db_event = new Events();
$db_event->establishConnection();

echo "<title>Manager Event</title>";

echo "<h1>Manager Event Page</h1>";
echo "<form method='POST'>";
echo "<p> Event Name: <input type='text' id='event_name' name='event_name'></p>";
echo "<p> Start Date and Time: <input type='date' id='event_startDate' name='event_startDate'><input type='time' id='event_startTime' name='event_startTime'></p>";
echo "<p> End Date and Time: <input type='date' id='event_endDate' name='event_endDate'><input type='time' id='event_endTime' name='event_endTime'></p>";
echo "<p> Capacity: <input type='text' id='event_capacity' name='event_capacity'></p>";

$db_event->getAllSelectedMenuVenues();

echo "<input type='submit' name='submitEvent' value='Create Event'>";
echo "<input type='submit' name='managerControls' value='Back To Manager Page'>";
echo "</form>";

if (isset($_POST['managerControls']))
{
    header("location: ../eventManager.php");
}

if (isset($_POST['submitEvent']))
{
    if ( !(isset($_POST['event_capacity'])) || !(isset($_POST['event_name'])) || !(isset($_POST['event_startDate'])) || !(isset($_POST['event_startTime'])) || !(isset($_POST['event_endDate'])) || !(isset($_POST['event_endTime'])) || !(isset($_POST['event_selectedVenue'])) )
    {
        echo "Missing information! One or more input is blank!";

    }
    else 
    {

        if ($_POST['event_capacity'] == null || $_POST['event_name'] == null || $_POST['event_startDate'] == null || $_POST['event_startTime'] == null || $_POST['event_endTime'] == null || $_POST['event_endDate'] == null || $_POST['event_selectedVenue'] == null)
        {
            echo "Missing information! One or more input is blank!";
        }
        else 
        {
                
                
                if ($db_event->checkEventNameExists($_POST['event_name']) == true)
                {
                    echo "Event Name already exists Try another name!";
                }
                else 
                {
                    $startDatetime = $_POST['event_startDate'] . " " . $_POST['event_startTime'];
                    $endDatetime = $_POST['event_endDate'] . " " . $_POST['event_endTime'];
                    try 
                    {    
                        $db_event->insertEventRow($_POST['event_name'], $startDatetime, $endDatetime, $_POST['event_capacity'], $_POST['event_selectedVenue']);
                        $eventID = $db_event->getSpecificIDBasedOnName($_POST['event_name']);
                        
                        $db_event->registerEventOwnership($eventID, $managerID);
                        header("Location: ../eventManager.php");
                    }
                    catch (Exception $e)
                    {
                        echo "<p> $e </p>";
                    }
                }
        } // end is null
    
    } // end isset
    
} // end submitName

?>