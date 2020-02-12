<?php 
    class DB{
        private $dbh;
        


        function __construct(){
            try
            {
                $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}", 
                $_SERVER['DB'], $_SERVER['DB_SERVER']);
            }
            catch (PDOException $pe)
            {
                echo $pe->getMessage();
                die("Bad Database");
            }
        } // end construct

        //get Person's data
        function getPerson($id)
        {
            try 
            {
                //initialize array
                $data = array();
                $stmt = $this->dbh->prepare("SELECT & FROM people WHERE PersonID = :id");
                //
                $stmt->execute(array("id"=>$id));

                while ($row=$stmt->fetch())
                {
                    $data[] = $row;            
                }
                return $data;
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
                return array();
            }
        }

        function getAltPerson($id)
        {
            try 
            {
                //initialize array
                $data = array();
                $stmt = $this->dbh->prepare("SELECT & FROM people WHERE PersonID = :id");
                
                
                //bind the data
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);

                $stmt->execute(array("id"=>$id));

                while ($row=$stmt->fetch())
                {
                    $data[] = $row;            
                }
                return $data;
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
                return array();
            }
        }


    function getAltPersonTwo($id)
    {
        try 
        {
            //initialize array
            $data = array();
            
            $stmt = $this->dbh->prepare("SELECT & FROM people WHERE PersonID = :id");
            
            
            //bind the data
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            $stmt->execute(array("id"=>$id));

            $data = $stmt->fetchAll();
            
            return $data;
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
            return array();
        }
    }

    //insert the data into mysql
    function insert($last, $first, $nick)
    {
        try 
        {
            //initialize array
            $data = array();
            
            $stmt = $this->dbh->prepare("INSERT INTO people WHERE (LastName,FirstName,NickName) 
                VALUES (:lastName,:firstName,:nickName)");
            
            
            //bind the data
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);

            //using last name
            $stmt->execute(array("lastName"=>$last,
                                "firstName"->$first,
                                "nickName"->$nick));

            
            return $this->dbh->lastInsertId();
            
        } //guys, install live share chat
        // if you didn't register in as MS account then you'd be in read mode.
        // click the invitation link again then make sure you sign in MS account, Justin.
        catch (PDOException $e)
        {
            //error message
            echo $e->getMessage();
            return -1;
        }
    }

    function getAllObjects()
    {
        try 
        {
            $data = array();
            
            // Checks if the code from a file is already included, 
            // then will be not included again.
            include_once "Person.class.php";

            $stmt = $this->dbh->prepare("SELECT * FROM people");

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
        
            while ($person = $stmt->fetch())
            {
                $data = $person;
            }

            // Live Share Chat is found in extensions by Arjun Attam. 
            return $data;
        }
        catch (PDOException $e) 
        {
            echo $e->getMessage();
            return array();
        }

        //how to turn on the live share chat?

    }

} // end DB

?>