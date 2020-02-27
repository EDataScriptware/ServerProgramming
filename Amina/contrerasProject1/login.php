
<?php include('validation.php');


if(isset($_SESSION['admin_user']) == true){
	header("location: admin.php");
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>	
<body>
	<div id="titleinfo">
		<h1>Sands Sports Leagues</h1>
		<h3>Welcome to the Official Sands Sports League website! Please log in below to view your relevant informationmy</h3>
	</div>
	<div id="frm">
		<span><?php echo "<h3>$errorUser</h3>"; echo "<h3>$errorPassword</h3>"; echo "<h3>$error</h3>"; echo "<h3>$WrongUsernPW</h3>"; echo "<h3>$plzFill</h3>";?></span>
		<form action="" method="POST">
			<div class="input-group">
				<label>Username:</label>
				<input type="text" id="user" name="user"/>
			</div>
			<div class="input-group">
				<label>Password: </label>
				<input type="Password" id="pw" name="pw"/>
			</div>
			<div class="input-group">
				<input type="submit" name="login_btn" value="Login" />
			</div>
		</form>
	</div>
</body>
</html>