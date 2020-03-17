<?php
    require_once("../class/admin.class.php");

    $db_admin = new Admin();
    $db_admin->establishConnection();
    
    $sessionID = $_SESSION['sessionID_pass'];
    $sessionName = $_SESSION['sessionname_pass'];
    $sessionCapacity = $_SESSION['sessioncapacity_pass'];
    $sessionStart = $_SESSION['sessionstart_pass'];
    $sessionEnd = $_SESSION['sessionend_pass'];
    $sessionEvent = $_SESSION['sessionevent_pass'];

    $sessionStartArray = preg_split("/[\s,]+/", $sessionStart);
    $sessionEndArray = preg_split("/[\s,]+/", $sessionEnd);

    $sessionStartDate = $sessionStartArray[0];
    $sessionStartTime = $sessionStartArray[1];
    
    $sessionEndDate = $sessionEndArray[0];
    $sessionEndTime = $sessionEndArray[1];

    echo "<title>Administrator Session</title>";
    echo '<link rel="icon" href="../media/favicon.png" type="media/png" sizes="16x16">';

    echo '<head><style>';
    include '../css/forms.css';
    echo '</style></head>';    

    echo "<h1>Administrator Session Page</h1>";
    echo "<form method='POST'>";
    echo "<p> Session Name: <input type='text' id='session_name' name='session_name' value='$sessionName'></p>";
    echo "<p> Start Date and Time: <input type='date' id='session_startDate' name='session_startDate' value='$sessionStartDate'><input type='time' id='session_startTime' name='session_startTime' value='$sessionStartTime'></p>";
    echo "<p> End Date and Time: <input type='date' id='session_endDate' name='session_endDate'value='$sessionEndDate'><input type='time' id='session_endTime' name='session_endTime' value='$sessionEndTime'></p>";
    echo "<p> Capacity: <input type='text' id='session_capacity' name='session_capacity' value='$sessionCapacity'></p>";
    
    $db_admin->getAllSelectedMenuEvent();
    
    echo "<input type='submit' class='button' name='updateSession' value='Update'>";
    echo "<input type='submit' class='button' name='deleteSession' value='Delete This Session'>";
    echo "<input type='submit' class='button' name='goBack' value='Go Back'>";
       echo "</form>";

    if (isset($_POST['goBack']))
    {
        header("location: ../adminControls.php");
    }

    if (isset($_POST["deleteSession"]))
    {
        $db_admin->deleteSession($sessionID);
        header("location: ../adminControls.php");
    }

    if (isset($_POST["updateSession"]))
    {
        $newSessionName = $_POST['session_name'];
        $newSessionStartDate = $_POST['session_startDate'];
        $newSessionStartTime = $_POST['session_startTime'];
        $newSessionEndDate = $_POST['session_endDate'];
        $newSessionEndTime = $_POST['session_endTime'];
        $newSessionCapacity = $_POST['session_capacity'];
        $newSessionEvent = $_POST['session_selectedEvent'];

        $newSessionStart = $newSessionStartDate . " " . $newSessionStartTime;
        $newSessionEnd = $newSessionEndDate . " " . $newSessionEndTime;


        $db_admin->updateSession($sessionID, $newSessionName, $newSessionStart, $newSessionEnd, $newSessionCapacity, $newSessionEvent);
        header("location: ../adminControls.php");
    }
    
?>