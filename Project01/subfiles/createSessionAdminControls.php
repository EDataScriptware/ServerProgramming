<?php 
require_once("../class/admin.class.php");
$db_admin = new Admin();
$db_admin->establishConnection();

echo "<title>Administrator Session</title>";

echo '<head><style>';
include '../css/forms.css';
echo '</style></head>';


echo "<h1>Administrator Session Page</h1>";
echo "<form method='POST'>";
echo "<p> Session ID: <input type='text' id='id' name='id'></p>";
echo "<p> Session Name: <input type='text' id='session_name' name='session_name'></p>";
echo "<p> Start Date and Time: <input type='date' id='session_startDate' name='session_startDate'><input type='time' id='session_startTime' name='session_startTime'></p>";
echo "<p> End Date and Time: <input type='date' id='session_endDate' name='session_endDate'><input type='time' id='session_endTime' name='session_endTime'></p>";
echo "<p> Capacity: <input type='text' id='session_capacity' name='session_capacity'></p>";

$db_admin->getAllSelectedMenuEvent();

echo "<input type='submit' name='submitSession' value='Create Session'>";
echo "<input type='submit' name='adminControls' value='Back To Admin Page'>";
echo "</form>";

if (isset($_POST['adminControls']))
{
    header("location: ../adminControls.php");
}

if (isset($_POST['submitSession']))
{
    if ( !(isset($_POST['session_capacity'])) || !(isset($_POST['session_name'])) || !(isset($_POST['id']) || !(isset($_POST['session_startDate'])) || !(isset($_POST['session_startTime'])) || !(isset($_POST['session_endDate'])) || !(isset($_POST['session_endTime'])) || !(isset($_POST['session_selectedEvent'])) ))
    {
        echo "Missing information! One or more input is blank!";


    }
    else 
    {

        if ($_POST['id'] == null || $_POST['session_capacity'] == null || $_POST['session_name'] == null || $_POST['session_startDate'] == null || $_POST['session_startTime'] == null || $_POST['session_endTime'] == null || $_POST['session_endDate'] == null || $_POST['session_selectedEvent'] == null)
        {
            echo "Missing information! One or more input is blank!";
        }
        else 
        {
                
                if  ($db_admin->checkSessionIdExists($_POST['id']) == true)
                {
                    echo "Session ID already exists!";
                }
                else if ($db_admin->checkSessionNameExists($_POST['session_name']) == true)
                {
                    echo "Session Name already exists!";
                }
                else 
                {
                    $startDatetime = $_POST['session_startDate'] . " " . $_POST['session_startTime'];
                    $endDatetime = $_POST['session_endDate'] . " " . $_POST['session_endTime'];
                    try 
                    {    
                        $db_admin->insertSessionRow($_POST['id'], $_POST['session_name'], $startDatetime, $endDatetime, $_POST['session_capacity'], $_POST['session_selectedEvent']);
                        header("Location: ../adminControls.php");
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