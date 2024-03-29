<?php
    /**
    * Amina Mahmood
    * ISTE 341
    * Server Programming
    * edituser.php
    */
    // Check if logged in as admin.
    include('classes/header.class.php');
    if($_SESSION['userType'] == "manager"){
        echo '<script>window.location.replace("registrations.php");</script>';
    }
    if($_SESSION['userType'] == "attendee"){
        echo '<script>window.location.replace("registrations.php");</script>';
    }
    // Check ID is sent and is not super admin
    if(!isset($_GET['id']) || ($_GET['id'] == 1)){
        echo '<script>window.location.replace("registrations.php");</script>';
    }

    $db = new PDODB();

    // Delete a user function.
    if(isset($_GET['deleteUser']) && !($_GET['id'] == 1)){
        $db->adminDelete("attendee", $_GET['id'], "idattendee");
        echo '<script>window.location.replace("admin.php");</script>';
    }

    // Save changes to form.
    if(isset($_GET['updated'])){
        if($_POST['role'] == 'Admin'){
            $role = 1;
        }
        else if($_POST['role'] == 'Manager'){
            $role = 2;
        }
        else{
            $role = 3;
        }
        $res = $db->adminEditUser($_POST['name'], $role, $_POST['id']);
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
        <title>Admin Edit User</title>
        <link rel="stylesheet" href="assets/css/style.css"/>
    
        <!-- Materialize.css-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    </head>
    <body>
        <!-- Header -->
        <nav class="blue-grey lighten-2 fixed" role="navigation">
            <div class="nav-wrapper container"><a id="logo-container" class="brand-logo">Edit User</a>
                <!-- Navigation -->
                <ul class="right">
                    <li><a class="blue-grey darken-1 waves-effect waves-light btn" href="events.php">Events</a></li>
                    <li><a class="blue-grey darken-1 waves-effect waves-light btn" href="registrations.php">Registrations</a></li>
                    <li><a class="blue-grey darken-1 waves-effect waves-light btn" href="admin.php">Admin Controls</a></li>
                    <li><a class="red darken-1 waves-effect waves-light btn" href="edituser.php?logout=true">Logout</a></li>
                </ul>
            </div>
        </nav>

        <!-- Edit a user -->
        <a class="blue-grey darken-1 waves-effect waves-light btn" href="admin.php">Go Back</a><br/>
        <div class="section container m9 s9">
            <?php
                $response = $db->getAttendee($_GET['id']);
                echo '<form id="myForm" action="edituser.php?updated=true&id=' . $response["idattendee"] . '" method="post">
                    ID:<input type="text" readonly name="id" value="' . $response["idattendee"] . '"><br/>
                    Name:<input type="text" name="name" value="' . $response["name"] . '"><br/>
                    Role:<br/>';
                echo '<p><label><input value="Admin" name="role" type="radio"';
                    if($response["role"] == 1){ 
                        echo ' checked';
                    }
                    echo '><span>Admin</span></label></p>
                      <p><label><input value="Manager" name="role" type="radio"';
                    if($response["role"] == 2){ 
                        echo ' checked';
                    }
                    echo '><span>Manager</span></label></p>
                      <p><label><input value="Attendee" name="role" type="radio"';
                    if($response["role"] == 3){ 
                        echo ' checked';
                    }
                    echo '><span>Attendee</span></label></p>';
                echo '<br/><input class="btn blue-grey darken-2" type="submit" value="Save Changes">&nbsp;';
                echo '<a class="btn red darken-2" href="edituser.php?deleteUser=true&id=' . $response["idattendee"] . '">Delete 
                    User</a></form>';     
            ?>
        </div>
        
        <!-- Materialize script -->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="assets/js/materialize.js"></script>
        <script src="assets/js/init.js"></script>
    </body>
</html>
