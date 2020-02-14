<?php 
class DB 
{
    private $conn;

    function __construct()
    {
        $this->conn = new mysqli($_SERVER['DB_SERVER'],
                                    $_SERVER['DB_USER'],
                                    $_SERVER['DB_PASSWORD'],
                                    $_SERVER['DB']);

        if ($this->conn->connect_error)
        {
            echo "Connection Failed: " . mysqli_connect_error();
            die();
        } 
        
    
    } // constructor

    function getAllPeople()
    {
        $data = array(); // or []

        if ($stmt = $this->conn->prepare("SELECT * FROM people"))
        {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $last, $first, $nick);
            $records = $stmt->num_rows;
            
            if ($records > 0)
            {
                while ($stmt->fetch())
                {
                    $data[] = array('id'=>$id,'first'=>$first,'last'=>$last,'nick'=>$nick);
                } // end while

            } // end if num_rows


        } // end stmt

        return $data;
    }

    function getAllPeopleAsTable()
    {
        $data = $this->getAllPeople();
        if (count($data) > 0)
        {
            echo "<h1>" . count($data) .  " Records Found!</h1>";
            $bigString = "<table border='1'>\n
                            <tr>
                                <th>ID</th>
                                <th>First</th>
                                <th>Last</th>
                                <th>Nick</th>
                            </tr>";

                            foreach ($data as $row)
                            {
                                $bigString .= "<tr>
                                    <td><a href='Lab4_2.php?id={$row['id']}'>{$row['id']}</a></td>
                                    <td>{$row['first']}</td>
                                    <td>{$row['last']}</td>
                                    <td>{$row['nick']}</td>                                    
                                    </tr>\n";
                            }

            $bigString .= "</table>";
        }
        else 
        {
            $bigString = "<h2>No people exists!</h2>";
        }
        return $bigString;
        
    }

    function getAllPhone($id)
    {
        $data = array();

        if($stmt = $this->conn->prepare("SELECT * FROM phonenumbers WHERE PersonID= " . $id . ";"));
        {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $type, $phoneNumber, $areaCode);
            $numRows = $stmt->num_rows;

            if ($numRows > 0)
            {
                while ($stmt->fetch())
                {
                    $data[] = array('id'=>$id,'type'=>$type,'phonenumber'=>$phoneNumber,'areacode'=>$areaCode);
                } // end while

            } // end if num_rows

        }
        return $data;
    }

    function getAllPhoneAsTable($id)
    {
        $data = $this->getAllPhone($id);
        if (count($data) > 0)
        {
            echo "<h1>" . count($data) .  " Records Found!</h1>";
            $bigString = "<table border='1'>\n
                            <tr>
                                <th>Phone ID</th>
                                <th>Phone Type</th>
                                <th>Phone Number</th>
                                <th>Area Code</th>
                            </tr>";

                            foreach ($data as $row)
                            {
                                $bigString .= "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['type']}</td>
                                    <td>{$row['phonenumber']}</td>
                                    <td>{$row['areacode']}</td>                                    
                                    </tr>\n";
                            }

            $bigString .= "</table>";
        }
        else 
        {
            $bigString = "<h2>Error: Selected Person does not have a Phone Number!</h2>";
        }
        return $bigString;
    }



    function insert($last, $first, $nick)
    {
        $query = "insert into people (LastName,FirstName,NickName)
                    values (?,?,?)";
        $insertId = -1;
        
        if ($stmt = $this->conn->prepare($query))
        {
            $stmt->bind_param("sss",$last,$first,$nick);
            $stmt->execute();
            $stmt->store_result();
            $insertId = $stmt->insert_id;
        }
    } // insert

    function delete($id)
    {
        $query = "delete from people where PersonID = ?";
        $numRows = 0;
        
        if ($stmt = $this->conn->prepare($query))
        {
            $stmt->bind_param("i",intval($id));
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }
    } // delete

    function update($fields)
    {
        // make sure id is an element in $fields
        $query = "update people set ";
        $updateId = 0;
        $numRows = 0;
        $items = array();
        $types = "";
        
        foreach($fields as $k=>$v)
        {
            switch ($k)
            {
                case "nick":
                    $query .= "Nickname = ?,";
                    $items[] = &$fields[$k];
                    $types .= "s";
                break;
                case "last":
                    $query .= "LastName = ?,";
                    $items[] = &$fields[$k];
                    $types .= "s";
                break;
                case "first":
                    $query .= "FirstName = ?,";
                    $items[] = &$fields[$k];
                    $types .= "s";
                break;
                case "id":
                    $updateId = intval($v);
                break;
                

            } // end switch


        } // end foreach

        $query = trim($query, ",");
        $query .= " where PersonID = ?";
        $types .= "i";
        $items[] = &$updateId;

        if ($stmt = $this->conn->prepare($query))
        {
            $refArr = array_merge(array($types), $items);
            $ref    = new ReflectionClass('mysqli_stmt');
            $method = $ref->getMethod("bind_param");
            $method->invokeArgs($stmt, $refArr);

            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->affected_rows;
        }


        return $numRows;

    } // update

} // class




?>