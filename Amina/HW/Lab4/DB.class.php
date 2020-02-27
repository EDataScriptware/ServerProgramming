<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 4 - DB.class.php -->
<?php

class DB {
    private $dbh;

    function __construct() {
        $this->dbh = new mysqli($_SERVER['DB_SERVER'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB']);

        if($this->dbh->connect_error) {
            //don't do on production code
            echo "connection failed: ".mysqli_connect_error();
            die();
        }
    }

    function getAllPeople() {
        $data = array();
        if ($stmt = $this->dbh->prepare("select * from people")) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id,$last,$first,$nick);
            if($stmt->num_rows > 0) {
                while($stmt->fetch()) {
                    $data[] = array("id"=>$id,
                                    "first"=>$first,
                                    "last"=>$last,
                                    "nick"=>$nick);
                }
            } // if num rows
        }//if stmt
        return $data;
    } //getAllPeople

    function getAllPeopleAsTable(){
        $data = $this->getAllPeople();
        if (count($data) > 0) {
            $bigString = "<table border='1'> \n 
                <tr><th>ID</th><th>First</th><th>Last</th><th>Nick</th></tr>\n";
                
                foreach($data as $row) {
                    $bigString .= "<tr><td>
                        <a href = 'Lab4_2.php?id={$row['id']}'>{$row['id']}</a></td>
                        <td>{$row['first']}</td>
                        <td>{$row['last']}</td>
                        <td>{$row['nick']}</td>
                        </tr>\n";
                }
                
                $bigString .= "</table>";
        } else {
            $bigString = "<h2>No people exist</h2>";
        }
        return $bigString;
    } // get all as table

    function insert($last, $first, $nick) {
        $queryString = "insert into people (LastName,FirstName,NickName)
            values (?,?,?)";
        $insertID = -1;

        if ($stmt = $this->dbh->prepare($queryString)) {
            $stmt->bind_param("sss",$last,$first,$nick);
            $stmt->execute();
            $stmt->store_result();
            $insertID = $stmt->insert_id;
        }

        return $insertID;
    } // end of insert

    function update($fields) {
        $queryString = "update people set ";
        $updateID = 0;
        $numRows = 0;
        $items = array();
        $types = "";

        foreach($fields as $k=>$v) {
            switch($k) {
                case 'nick':
                    $queryString .= "NickName = ?,";
                    $items[] = &$v;  //may have to chg to &$fields[$k]
                    $types .= "s";
                    break;
                case 'first':
                    $queryString .= "FirstName = ?,";
                    $items[] = &$v;  //may have to chg to &$fields[$k]
                    $types .= "s";
                    break;
                case 'last':
                    $queryString .= "LastName = ?,";
                    $items[] = &$v;  //may have to chg to &$fields[$k]
                    $types .= "s";
                    break;
                case 'id':
                    $updateID = intval($v);
                    break;
            } // end of switch
        } // end of foreach

        $queryString = trim($queryString,",");
        $queryString .= " where PersonID = ?";
        $types .= "i";
        $items[] = &$updateID;
        var_dump($queryString,$types,$items);

        if($stmt = $this->dbh->prepare($queryString)) {
            $refArr = array_merge(array($types), $items);
            $ref = new ReflectionClass('mysqli_stmt');
            $method = $ref->getMethod("bind_param");
            $method->invokeArgs($stmt,$refArr);

            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }

        return $numRows;
    } // end of update

    function delete($id) {
        $queryString = "delete from people where PersonID = ?";
        $numRows = 0;

        if ($stmt = $this->dbh->prepare($queryString)) {
            $stmt->bind_param("i", intval($id));
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }
        return $numRows;
    } //end of delete

    function getPhoneNumbersAsTable($id){
        
        $queryString = "select * from phonenumbers where PersonID = ?";

        if($stmt = $this->dbh->prepare($queryString)){
            $stmt->bind_param("i", intval($id));
            $stmt->execute();  
            $stmt->store_result();
            $numRows = $stmt->num_rows;
            $stmt->bind_result($id, $type, $num, $areaCode);
            echo "$id, $type, $num, $areaCode";
        }
        
        $bigString = "<h2>{$numRows} records found!</h2>";

        if($numRows > 0) {
            while($stmt->fetch()){
                $data[] = array('id'=>$id,
                                'type'=>$type,
                                'num'=>$num,
                                'areaCode'=>$areaCode
                            );
            }
            $bigString .= "<table border = '1'>\n
                <tr>
                    <th>ID</th><th>Phone Type</th><th>Phone Number</th><th>Area Code</th>
                </tr>
                ";
        foreach($data as $row) {
            $bigString .= "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['type']}</td>
                            <td>{$row['num']}</td>
                            <td>{$row['areaCode']}</td>
                        </tr>";
        }
        $bigString .= "<table>\n";
        } else {
            $bigString = "<h2>No phone numbers exist for this ID.</h2>";
        }
        return $bigString; 
    } // end of getPhoneNumbersAsTable
} // end of class