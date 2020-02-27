<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 4 - PDO.DB.class.php -->
<?php
class DB {
    private $dbh;

    function __construct() {
        include "PhoneNumbers.class.php";
        try {
            //open the connection
            $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}",
                $_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);
            //change error reporting 
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("There was a problem");
        }
    }

    function getPeople($id) {
        try {
            $data = array();
            $stmt = $this->dbh->prepare("select * from people where PersonID = :id");

            $stmt->execute(array("id"=>$id)); //array(":id"=>$id)
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function getPhoneNumber($id) {
        try {
            $data = array();
            $stmt = $this->dbh->prepare("select * from phonenumbers where PersonID = :id");

            $stmt->execute(array("id"=>$id)); //array(":id"=>$id)
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function getPeopleAlt($id) {
        try {
            $data = array();
            $stmt = $this->dbh->prepare("select * from people where PersonID = :id");

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            while($row = $stmt->fetch()) {
                $data[] = $row;
            }
            return $data;

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function getPeopleAlt2($id) {
        try {
            $data = array();
            $stmt = $this->dbh->prepare("select * from people where PersonID = :id");

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll();
            return $data;

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function insert($last,$first,$nick) {
        try {

            $stmt = $this->dbh->prepare("insert into people (LastName,FirstName,NickName) values (:last, :first, :nick)");

                  $stmt->execute(array(
                      "last" => $last,
                      "first" => $first,
                      "nick" => $nick
                  ));

                  return $this->dbh->lastInsertId();

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function getAllObjects() {
        try {
            include "Person.class.php";
            $data = array();
            $stmt = $this->dbh->prepare("select * from people");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Person");

            while($person = $stmt->fetch()) {
                $data[] = $person;
            }
            return $data;

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    function getAllPhoneNumbers($id) {
        try {
            $data = array();
            $stmt = $this->dbh->prepare("select * from phonenumbers where PersonID = :id");
            $stmt->execute(['id'=>$id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS,"PhoneNumbers");
            while($phonenumbers = $stmt->fetch()) {
                $data[] = $phonenumbers;
            }
            return $data;

        } catch(PDOException $e) {
            echo $e->getMessage();
            die();
        }

        function getAllPeopleAsTable() {
            $data = $this->getAllObjects();
            if(count($data) > 0){
                $bigString .= "<table border = '1'>\n
                                <tr>
                                <th>ID</th><th>First</th><th>Last</th><th>Nick</th>
                                </tr>
                                ";
                foreach($data as $row) {
                    $bigString .= "<tr>
                                    <td><a href = 'Lab4_4.php?id={$row->getID()}'>{$row->getID()}</a></td>
                                    <td>{$row->getFName()}</td>
                                    <td>{$row->getLName()}</td>
                                    <td>{$row->getNick()}</td>
                                </tr>";
                }
                $bigString .="</table>\n";
            } else {
                $bigString = "<h2>No people exist.</h2>";
            }
            return $bigString;
        }

        function getPhoneNumbersAsTable($id) {
            $data = $this->getAllPhoneNumbers($id);
            $numRows = count($data);
            $bigString = "<h2>{$numRows} records found!</h2>";

            if(count($data) > 0){
                $bigString .= "<table border = '1'>\n
                                <tr>
                                    <th>ID</th><th>Phone Type</th><th>Phone Number</th><th>Area Code</th>
                                </tr>
                                ";
                foreach($data as $row) {
                    $bigString .= "<tr>
                                    <td>{$row->getID()}</td>
                                    <td>{$row->getPhoneType()}</td>
                                    <td>{$row->getPhoneNum()}</td>
                                    <td>{$row->getAreaCode()}</td>
                                </tr>";
                }
                $bigString .="</table>\n";
            } else {
                $bigString = "<h2>No phone numbers exits for this ID.</h2>";
            }
            return $bigString;
        } // end of getAllPeopleAsPeople
    } // end of getAllPhoneNumbers
} // end of class