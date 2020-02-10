<!DOCTYPE HTML>
<!-- https://serenity.ist.rit.edu/~emr9018/341/Labs/Lab03/feelings.php -->
<html>
<h1>Feelings</h1>
<?php
$firstnameError = $lastnameError = $dateError = $commentsError = $moodError = "";
$firstName = $lastName = $date = $comments = $mood = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["firstname"])) {
          $firstnameError = "First Name is required!";
        } else {
          $firstName = ($_POST["firstname"]);
        }
        if (empty($_POST["lastname"])) {
            $lastnameError = "Last Name is required!";
          } else {
            $lastName = ($_POST["lastname"]);
          }
          if (empty($_POST["date"])) {
            $dateError = "Date is required!";
          } else {
            $date = ($_POST["date"]);
          }
          if (empty($_POST["comments"])) {
            $commentsError = " Comments is required!";
          } else {
            $comments = ($_POST["comments"]);
          }
          if (empty($_POST["mood"])) {
            $moodError = "Your feelings is required!";
          } else {
            $mood = ($_POST["mood"]);
          }
    }
?>

<form action="feelings.php" method="post">
    <p>First Name: <input type="text" name="firstname"> <?php echo $firstnameError ?> </p>

    <p>Last Name: <input type="text" name="lastname"> <?php echo $lastnameError ?></p>

    <p>Date: <input type="date" id="start" name="date" min="2020-02-03"> <?php echo $dateError ?></p>

    <p>Comments: </p>
    <textarea rows="5" cols="60" name="comments"></textarea><?php echo $commentsError ?>

    <p>Mood: </p>
        <input type="radio" name="mood" value="happy"> Happy<br>
        <input type="radio" name="mood" value="mad"> Mad<br>
        <input type="radio" name="mood" value="indifferent"> Indifferent<br>
        <?php echo $moodError ?>
    <p>
        <input type="submit" value="Submit Form">
        <input type="reset"  value="Reset Form">
    </p>
</form>

<?php


    if (($firstnameError == "") && ($lastnameError == "") && ($dateError == "") && ($commentsError == "") && ($moodError == ""))
    {
        if (isset($_POST["date"]))
        {
            echo "<p>Today is " ;
            echo "<i>" . $_POST["date"] . "</i><br/></p>"; 
        }
        if (isset($_POST["firstname"]))
        {
            echo "<p>Hello ";
            echo $_POST["firstname"];
        }

        if (isset($_POST["lastname"]))
        {
            echo " " . $_POST["lastname"]; 
        }
        if (isset($_POST["mood"]))
        {
            if ($_POST["mood"] == "happy")
            {
                echo ", I am so glad that you're happy today!</p>";
            }
            else if ($_POST["mood"] == "indifferent")
            {
                echo ", you seem indifferent for some reason... You mind talking to me about it?</p>";
            }
            else if ($_POST["mood"] == "mad")
            {
                echo ", there is no reason to be mad. Let's talk about it rationally.</p>";
            }
            else 
            {
                echo ", YOU DON'T HAVE FEELINGS. JUST WHAT ARE YOU!</p>";
            }
        }        
        if (isset($_POST["comments"]))
        {
            echo "<p>Comments: " . $_POST["comments"] . "</p>"; 
        }
       
    }
    else 
    {
        echo "<h2> One or more missing required information above.</h2>";
    }

    
?>


</html>