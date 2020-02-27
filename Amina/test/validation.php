<?php
require_once("PDO.DB.class.php");
session_start();
$error=$errorPassword=$errorUser=$WrongUsernPW=$plzFill ="";
try{

	$db = new DB();
	if(isset($_POST['login_btn'])){
	//valid if user and pass arent empty
		if(!empty($_POST['user']) && !empty($_POST['pw'])){

			$inputname = $_POST['user'];
			$inputpw = hash('sha256', $_POST['pw']);
		//echo $inputname;
		//echo $inputpw;


		//creates a connection to DB
			$data = $db->getAllUserclass($inputname, $inputpw);

			//var_dump($data);

		//if(count($data) > 0 ){

			$getDBusername = "";
			$getDBpw = "";
			$getDBrole = 0;



			foreach ($data as $account) {
				$getDBusername = "{$account->getUsername()}";
				$getDBpw = "{$account->getPassword()}";
				$getDBrole = $account->getRole();
			}

			//checks if input user/pass matches one of the accounts' user/pass

			//echo $getDBusername;
			//echo $getDBpw;

			if($inputname === $getDBusername && $inputpw === $getDBpw){
			//if right user/pass

					//$_SESSION['admin_user']==true;

				switch ($getDBrole) {
					case 1:
					header("location: admin.php");
					exit();
					break;
					case 2:
					header("location: League_Manager.php");
					exit();
					case 3:
					header("location: coachNteamManager.php");
					exit();
					break;
					case 4:
					header("location: coachNteamManager.php");
					exit();
					break;
					case 5:
					header("location: parent.php");
					exit();
					break;


					default:
					# code...
					break;
				}

				
				





			}else{
			//if wrong user/pass
				$WrongUsernPW =  "Oops! Wrong pw and username";
				//header("location: login.php");

			}

		//}//count data

		}elseif(empty($_POST['user']) && empty($_POST['pw'])){
		//if empty user/pass
			$plzFill =  "Please fill your user and password correctly";
			//header("location: login.php");
		}
		elseif(empty($_POST['user'])){

			$errorUser =  "Please fill your user";
			//header("location: login.php");


		}elseif(empty($_POST['pw'])){

			$errorPassword =  "Please fill your password";
			//header("location: login.php");


		}
 }//ISSET(LOGIN)

}catch(PDOEXception $error){
	die("Error");
}



?>