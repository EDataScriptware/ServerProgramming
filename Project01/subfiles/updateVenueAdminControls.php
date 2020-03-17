<?php
    require_once("../class/admin.class.php");

    if (!isset($_SESSION['user']) || !isset($_SESSION['userID']) || !isset($_SESSION['role']) ) 
    {
        header("location: login.php");
    }

    $admin = new Admin();
    $admin->establishConnection();
    

    $venueID = $_SESSION['venueID_pass'];
    $venueName = $_SESSION['venuename_pass'];
    $venueCapacity = $_SESSION['venuecapacity_pass'];

    echo "<form method='POST'>";
    echo "<p> Venue Name: <input type='text' id='name' name='name' value='$venueName'></p>";    
    echo "<p> Venue Capacity: <input type='text' id='capacity' name='capacity' value='$venueCapacity'></p>";    

    echo "<input type='submit' name='updateVenue' value='Update'>";
    echo "<input type='submit' name='deleteVenue' value='Delete This Venue'>";
    echo "<input type='submit' name='goBack' value='Go Back'>";
    echo "</form>";


    if (isset($_POST['goBack']))
    {
        header("location: ../adminControls.php");
    }

    if (isset($_POST["deleteVenue"]))
    {
        $admin->deleteVenue($venueID);
        header("location: ../adminControls.php");
    }

    if (isset($_POST["updateVenue"]))
    {
        $newVenueName = $_POST["name"];
        $newVenueCapacity = $_POST["capacity"];

        $admin->updateVenue($venueID, $newVenueName, $newVenueCapacity);
        header("location: ../adminControls.php");
    }
?>