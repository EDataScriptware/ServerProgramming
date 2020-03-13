<?php 
require_once("../class/admin.class.php");
$db_admin = new Admin();
$db_admin->establishConnection();

echo "<title>Administrator Venue</title>";

echo "<h1>Administrator Venue Page</h1>";
echo "<form method='POST'>";
echo "<p> Venue ID: <input type='text' id='id' name='id'></p>";
echo "<p> Venue Name: <input type='text' id='venue_name' name='venue_name'></p>";
echo "<p> Capacity: <input type='text' id='capacity' name='capacity'></p>";

echo "<input type='submit' name='submitVenue' value='Create Venue'>";
echo "<input type='submit' name='adminControls' value='Back To Admin Page'>";
echo "</form>";

if (isset($_POST['adminControls']))
{
    header("location: ../adminControls.php");
}

if (isset($_POST['submitVenue']))
{

   
    if (!(isset($_POST['capacity'])) || !(isset($_POST['venue_name'])) || !(isset($_POST['id'])))
    {
        echo "Missing information! One or more input is blank!";
    }
    else 
    {

        if ($_POST['id'] == null || $_POST['venue_name'] == null || $_POST['capacity'] == null)
        {
            echo "Missing information! One or more input is blank!";
        }
        else 
        {
                
                if  ($db_admin->checkVenueIdExists($_POST['id']) == true)
                {
                    echo "Venue ID already exists!";
                }
                else if ($db_admin->checkVenueNameExists($_POST['venue_name']) == true)
                {
                    echo "Venue Name already exists!";
                }
                else 
                {
                    try 
                    {    
                        $db_admin->insertVenueRow($_POST['id'], $_POST['venue_name'], $_POST['capacity']);
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