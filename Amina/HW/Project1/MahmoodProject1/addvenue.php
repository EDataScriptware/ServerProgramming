<?php
    /**
    * Amina Mahmood
    * ISTE 341
    * Server Programming
    * addvenue.php
    */
    // Check if logged in as admin.
    include('classes/header.class.php');
    if($_SESSION['userType'] == "attendee"){
        echo '<script>window.location.replace("registrations.php");</script>';
    }
    if($_SESSION['userType'] == "manager"){
        echo '<script>window.location.replace("registrations.php");</script>';
    }

    $db = new PDODB();

    // Save changes to form.
    if(isset($_GET['updated'])){
        if($res = $db->insertVenue($_POST['name'], $_POST['capacity']) == 1){
            echo "<script type='text/javascript'>alert('Venue Successfully added!')</script>";
        }
        else{
            echo "<script type='text/javascript'>alert('Venue Unsuccessfully Added.')</script>"; 
        }
    }

    // Logout button.
	if(isset($_GET['logout'])){
        logout();
    }
    // Destroy session.
	function logout(){
		session_destroy();
		header("Location: http://serenity.ist.rit.edu/~axm6392/341/project1/login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Add Venue</title>
        <link rel="stylesheet" href="assets/css/style.css"/>
    
        <!-- Materialize.css-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    </head>
    <body>
        <!-- Header -->
        <nav class="blue-grey lighten-2 fixed" role="navigation">
            <div class="nav-wrapper container"><a id="logo-container" class="brand-logo">Add Venue</a>
                <!-- Navigation -->
                <ul class="right">
                    <li><a class="blue-grey darken-1 waves-effect waves-light btn" href="events.php">Events</a></li>
                    <li><a class="blue-grey darken-1 waves-effect waves-light btn" href="registrations.php">Registrations</a></li>
                    <li><a class='blue-grey darken-1 waves-effect waves-light btn' href='admin.php'>Admin Controls</a></li>
                    <li><a class="red darken-1 waves-effect waves-light btn" href="addvenue.php?logout=true">Logout</a></li>
                </ul>
            </div>
        </nav>

        <!-- Add a venue -->
        <a class="blue-grey darken-1 waves-effect waves-light btn" href="admin.php">Go Back</a><br/>
        <div class="section container m9 s9">
            <?php
                $result = $db->getVenues();
                echo '<form id="myForm" action="addvenue.php?updated=true" method="post">
                    Name:<input data-length="50" type="text" name="name" required="required" value=""><br/>
                    Capacity:<input type="number" name="capacity" required="required" value="">';
                echo '<br/><input class="btn blue-grey darken-2" type="submit" value="Add Venue"></form>';  
            ?>
        </div>
        
        <!-- Materialize script -->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="assets/js/materialize.js"></script>
        <script src="assets/js/init.js"></script>
    </body>
</html>
