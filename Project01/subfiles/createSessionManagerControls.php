<?php 
require_once("../class/events.class.php");
$db_events = new Events();
$db_events->establishConnection();

$managerID = $_SESSION['userID'];

echo "<title>Event Manager Session</title>";

echo '<head><style>';
include '../css/forms.css';
echo '</style></head>';

echo "<h1>Event Manager Session Page</h1>";
echo "<form method='POST'>";
echo "<p> Session Name: <input type='text' id='session_name' name='session_name'></p>";
echo "<p> Start Date and Time: <input type='date' id='session_startDate' name='session_startDate'><input type='time' id='session_startTime' name='session_startTime'></p>";
echo "<p> End Date and Time: <input type='date' id='session_endDate' name='session_endDate'><input type='time' id='session_endTime' name='session_endTime'></p>";
echo "<p> Capacity: <input type='text' id='session_capacity' name='session_capacity'></p>";

$db_events->getAllSelectedMenuEventManager($managerID);

echo "<input type='submit' name='submitSession' class='button' value='Create Session'>";
echo "<input type='submit' name='managerControls' class='button' value='Back To Manager Page'>";
echo "</form>";

if (isset($_POST['managerControls']))
{
    header("location: ../eventManager.php");
}

if (isset($_POST['submitSession']))
{
    if ( !(isset($_POST['session_capacity'])) || !(isset($_POST['session_name']) || !(isset($_POST['session_startDate'])) || !(isset($_POST['session_startTime'])) || !(isset($_POST['session_endDate'])) || !(isset($_POST['session_endTime'])) || !(isset($_POST['session_selectedEvent'])) ))
    {
        echo "<p class='errorMessage'>Missing information! One or more input is blank!</p>";


    }
    else 
    {

        if ($_POST['session_capacity'] == null || $_POST['session_name'] == null || $_POST['session_startDate'] == null || $_POST['session_startTime'] == null || $_POST['session_endTime'] == null || $_POST['session_endDate'] == null || $_POST['session_selectedEvent'] == null)
        {
            echo "<p class='errorMessage'>Missing information! One or more input is blank!</p>";
        }
        else 
        {
                
            
                if ($db_events->checkSessionNameExists($_POST['session_name']) == true)
                {
                    echo "<p class='errorMessage'>Session Name already exists!</p>";
                }
                else 
                {
                    $startDatetime = $_POST['session_startDate'] . " " . $_POST['session_startTime'];
                    $endDatetime = $_POST['session_endDate'] . " " . $_POST['session_endTime'];
                    try 
                    {    
                        $db_events->insertSessionRow($_POST['session_name'], $startDatetime, $endDatetime, $_POST['session_capacity'], $_POST['session_selectedEvent']);
                        header("Location: ../eventManager.php");
                    }
                    catch (Exception $e)
                    {
                        echo "<p class='errorMessage'> $e </p>";
                    }
                }
        } // end is null
    
    } // end isset
    
} // end submitName
?>