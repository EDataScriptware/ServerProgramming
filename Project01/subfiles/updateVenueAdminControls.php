<?php
    require_once("../class/admin.class.php");
    
    $admin = new Admin();
    $admin->establishConnection();
    

    $venueID = $_SESSION['venueID_pass'];
    $venueName = $_SESSION['venuename_pass'];
    $venueCapacity = $_SESSION['venuecapacity_pass'];
    echo '<link rel="icon" href="../media/favicon.png" type="media/png" sizes="16x16">';

    echo '<head><style>';
    include '../css/forms.css';
    echo '</style></head>';

    echo "<form method='POST'>";
    echo "<p> Venue Name: <input type='text' id='name' name='name' value='$venueName'></p>";    
    echo "<p> Venue Capacity: <input type='text' id='capacity' name='capacity' value='$venueCapacity'></p>";    

    echo "<input type='submit' class='button' name='updateVenue' value='Update'>";
    echo "<input type='submit' class='button' name='deleteVenue' value='Delete This Venue'>";
    echo "<input type='submit' class='button' name='goBack' value='Go Back'>";
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