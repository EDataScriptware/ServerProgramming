<?php

class DB{
	private $db;

	function __construct(){
		try{
            //open a connection
			$this->db = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}",$_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);
			$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			die("Big problem");
		}
	}//constructor

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////User


    function getAllUserclass($user, $password){
    try{
        include "classes/User.class.php";
        $data = array();
        $query = "select * from server_user where password = '{$password}' && username = '{$user}'";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"User");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }


  function insertUser($username,$password,$Role, $team, $league){
  try{
    $stmt = $this->db->prepare("insert into server_user (username,password, role, team, league) values
        (:username,:password,:role,:team,:league)");

    $stmt->execute(array(
        "username"=>$username,
        "password"=>$password,
        "role"=>$Role,
        "team"=>$team,
        "league"=>$league
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

  	function ViewUserclass(){
    try{
   		include "classes/User.class.php";
		$data = array();
		$query = "select * from server_user";
		$statement = $this->db->prepare($query);
		$statement->execute();
		$statement->setFetchMode(PDO::FETCH_CLASS,"User");
		while ($account = $statement->fetch()) {
			$data[] = $account;
		}
  		return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updateUser($username,$password,$role,$team,$league,$getOldusername){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_user set username = :username, password = :password, role = :role, team = :team, league = :league where username = :getOldusername");

    $stmt->execute(array(
        "username"=>$username,
        "role"=>$role,
        "password"=>$password,
        "team"=>$team,
        "league"=>$league,
        "getOldusername"=>$getOldusername

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deleteUser($username){

    try{
    $stmt = $this->db->prepare("Delete from server_user where username= :username");

    $stmt->execute(array(
        "username"=>$username
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End User





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Sport
  function insertSport($name){
  try{
    $stmt = $this->db->prepare("insert into server_sport (name) values
        (:name)");

    $stmt->execute(array(
        "name"=>$name
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewSportclass(){
    try{
        include "classes/Sport.class.php";
        $data = array();
        $query = "select * from server_sport";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"Sport");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updateSport($id,$name){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_sport set name = :name where id = :id");

    $stmt->execute(array(
        "name"=>$name,
        "id"=>$id

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deleteSport($id){

    try{
    $stmt = $this->db->prepare("Delete from server_sport where id= :id");

    $stmt->execute(array(
        "id"=>$id
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End Sport



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Season
  function insertSeason($year,$desc){
  try{
    $stmt = $this->db->prepare("insert into server_season (year,description) values
        (:year,:desc)");

    $stmt->execute(array(
        "year"=>$year,
        "desc"=>$desc
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewSeasonclass(){
    try{
        include "classes/Season.class.php";
        $data = array();
        $query = "select * from server_season";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"Season");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updateSeason($id,$year,$desc){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_season set year = :year, description = :desc  where id = :id");

    $stmt->execute(array(
        "id"=>$id,
        "year"=>$year,
        "desc"=>$desc

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deleteSeason($id){

    try{
    $stmt = $this->db->prepare("Delete from server_season where id= :id");

    $stmt->execute(array(
        "id"=>$id
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End Season



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////League
  function insertLeague($name){
  try{
    $stmt = $this->db->prepare("insert into server_league (name) values
        (:name)");

    $stmt->execute(array(
        "name"=>$name
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewLeagueclass(){
    try{
        include "classes/League.class.php";
        $data = array();
        $query = "select * from server_league";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"League");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updateLeague($id,$name){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_league set name = :name where id = :id");

    $stmt->execute(array(
        "name"=>$name,
        "id"=>$id

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deleteLeague($id){

    try{
    $stmt = $this->db->prepare("Delete from server_league where id= :id");

    $stmt->execute(array(
        "id"=>$id
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End League


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Slseason
  function insertSlseason($sport,$league,$season){
  try{
    $stmt = $this->db->prepare("insert into server_slseason (sport,league,season) values
        (:sport,:league,:season)");

    $stmt->execute(array(
        "sport"=>$sport,
        "league"=>$league,
        "season"=>$season

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewSlseasonclass(){
    try{
        include "classes/Slseason.class.php";
        $data = array();
        $query = "select * from server_slseason";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"Slseason");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updateSlseason($sport,$league,$season,$oldSport){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_slseason set sport = :sport, league = :league, season = :season where sport = :oldSport");

    $stmt->execute(array(
        "sport"=>$sport,
        "league"=>$league,
        "season"=>$season,
        "oldSport"=>$oldSport

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deleteSlseason($sport){

    try{
    $stmt = $this->db->prepare("Delete from server_slseason where sport = :sport");

    $stmt->execute(array(
        "sport"=>$sport
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End Slseason



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Schedule
  function insertSchedule($sport,$league,$season,$hometeam,$awayteam,$homescore,$awayscore,$scheduled,$completed){
  try{
    $stmt = $this->db->prepare("insert into server_schedule (sport,league,season,hometeam,awayteam,homescore,awayscore,scheduled,completed) values
        (:sport,:league,:season,:hometeam,:awayteam,:homescore,:awayscore,:scheduled,:completed)");

    $stmt->execute(array(
        "sport"=>$sport,
        "league"=>$league,
        "season"=>$season,
        "hometeam"=>$hometeam,
        "awayteam"=>$awayteam,
        "homescore"=>$homescore,
        "awayscore"=>$awayscore,
        "scheduled"=>$scheduled,
        "completed"=>$completed

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewScheduleclass(){
    try{
        include "classes/Schedule.class.php";
        $data = array();
        $query = "select * from server_schedule";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"Schedule");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updateSchedule($sport,$league,$season,$hometeam,$awayteam,$homescore,$awayscore,$scheduled,$completed,$oldHT){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_schedule set sport = :sport, league = :league, season = :season, hometeam = :hometeam, awayteam = :awayteam, homescore = :homescore, awayscore = :awayscore, scheduled = :scheduled, completed = :completed where homescore = :oldHT");

    $stmt->execute(array(
        "sport"=>$sport,
        "league"=>$league,
        "season"=>$season,
        "hometeam"=>$hometeam,
        "awayteam"=>$awayteam,
        "homescore"=>$homescore,
        "awayscore"=>$awayscore,
        "scheduled"=>$scheduled,
        "completed"=>$completed,
        "oldHT"=>$oldHT

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deleteSchedule($hometeam){

    try{
    $stmt = $this->db->prepare("Delete from server_schedule where hometeam = :hometeam");

    $stmt->execute(array(
        "hometeam"=>$hometeam
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End Schedule



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////User for Team manager and Coach

    function ViewUsertmNcclass(){
    try{
        include "classes/User.class.php";
        $data = array();
        $query = "select * from server_user where role = 3 || role = 4";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"User");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////end TM and C



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Position 
    function insertPosition($name){
  try{
    $stmt = $this->db->prepare("insert into server_position (name) values
        (:name)");

    $stmt->execute(array(
        "name"=>$name
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewPositionclass(){
    try{
        include "classes/Position.class.php";
        $data = array();
        $query = "select * from server_position";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"Position");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updatePosition($id,$name){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_position set name = :name where id = :id");

    $stmt->execute(array(
        "name"=>$name,
        "id"=>$id

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deletePosition($id){

    try{
    $stmt = $this->db->prepare("Delete from server_position where id= :id");

    $stmt->execute(array(
        "id"=>$id
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////EndPosition 







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////Player 

 function insertPlayer($id,$firstname,$lastname,$dateofbirth,$jerseynumber,$team){
  try{
    $stmt = $this->db->prepare("insert into server_player (id,firstname,lastname,dateofbirth,jerseynumber,team) values
        (:id,:firstname,:lastname,:dateofbirth,:jerseynumber,:team)");

    $stmt->execute(array(
        "id"=>$id,
        "firstname"=>$firstname,
        "lastname"=>$lastname,
        "dateofbirth"=>$dateofbirth,
        "jerseynumber"=>$jerseynumber,
        "team"=>$team

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}
}

    function ViewPlayerclass(){
    try{
        include "classes/Player.class.php";
        $data = array();
        $query = "select * from server_player";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"Player");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }

function updatePlayer($id,$firstname,$lastname,$dateofbirth,$jerseynumber,$team){
// when you change username, it doesn't remember old username
    try{
    $stmt = $this->db->prepare("Update server_player set firstname = :firstname, lastname = :lastname, dateofbirth = :dateofbirth, jerseynumber = :jerseynumber, team = :team where id = :id");

    $stmt->execute(array(
        "id"=>$id,
        "firstname"=>$firstname,
        "lastname"=>$lastname,
        "dateofbirth"=>$dateofbirth,
        "jerseynumber"=>$jerseynumber,
        "team"=>$team

    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}


function deletePlayer($id){

    try{
    $stmt = $this->db->prepare("Delete from server_player where id = :id");

    $stmt->execute(array(
        "id"=>$id
    ));
    return $this->db->lastInsertId();
}catch(PDOException $e){
    echo $e->getMessage();
    die("insert: Big problem");
}

}







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////End Player 


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////View Team
    function ViewTeampageclass(){
    try{
        include "classes/ViewTeam.class.php";
        $data = array();
        $query = "select distinct picture, st.name, firstname, lastname, jerseynumber, spos.name from server_team as st inner join server_player as sp on st.id = sp.team inner join server_playerpos as spp on sp.id = spp.player inner join server_position as spos on spp.position = spos.id ;";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"ViewTeam");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////View Schedule
    function ViewSchedulepageclass($id){
    try{
        include "classes/ViewSchedule.class.php";
        $data = array();
        $query = "select name, homescore, awayscore, scheduled, completed from server_team inner join server_schedule on server_team.id = server_schedule.hometeam where server_schedule.hometeam = :id ";
        $statement = $this->db->prepare($query);
        $statement->execute(array(
            "id"=>$id
        ));
        $statement->setFetchMode(PDO::FETCH_CLASS,"ViewSchedule");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  }  


      function selectSchedulepageclass(){
    try{
        include "classes/ViewSchedule.class.php";
        $data = array();
        $query = "select name from server_team inner join server_schedule on server_team.id = server_schedule.hometeam";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS,"ViewSchedule");
        while ($account = $statement->fetch()) {
            $data[] = $account;
        }
        return $data;
    }catch(PDOException $e){
        echo $e->getMessage();
        die("Error: User Fetch ");
    }
  } 



}






