<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 3 - feeling.php -->
<!DOCTYPE html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Untitled</title>
 	<style type="text/css">
 		form div
 		{
 			margin: 1em;
 		}
 		form div label
 		{
 			float: left;
 			width: 10%;
 		}
 		form div.radio {
 			float: left;
 		}
 		.clearfix {
 			clear: both;
 		}
 	</style>
</head>
<body>
	<form action = "/~axm6392/341/lab3/feeling.php" method="POST">
		<div>
			<label for="fname">First Name:</label>
			<input type="text" name="fname" size="30" />
		</div>
		<div>
			<label for="lname">Last Name:</label>
			<input type="text" name="lname" size="30" />
		</div>
		<div>
			<label for="date">Date:</label>
			<input type="text" name="date" size="30" />
		</div>
		<div>
			<label for="comments">Comments:</label>
			<textarea name="comments" rows="3" cols="30"></textarea>
		</div>
		<div>
			<label for="mood">Mood:</label>
			<div class="radio">
				<input type="radio" name="mood" value="happy" />Happy<br />
				<input type="radio" name="mood" value="mad" />Mad<br />
				<input type="radio" name="mood" value="indifferent" />Indifferent<br />
			</div>
		</div>
		<div class="clearfix">
			<input type="reset" value="Reset Form" />
			<input type="submit" name="submit" value="Submit Form" />
		</div>	
    </form>
    
    <?php
        if(isset($_POST['fname'], $_POST['lname'], $_POST['date'], $_POST['comments'])){
            require_once('Validator.class.php');
            $val = new Validator();
            
            $today = $val->validate($_POST["date"]);
            $fname = $val->validate($_POST["fname"]);
            $lname = $val->validate($_POST["lname"]);
            $comments = $val->validate($_POST["comments"]);

            if(!isset($_POST['mood']) || !Validator::length($today) || !Validator::length($fname) || !Validator::length($lname) || !Validator::length($comments)){
                echo "<h2>Please fill all the field!</h2>";
            }else{
                $mood = $_POST["mood"];

                echo "<p>Today is ".$today."</p>";
                echo "<p>Hello ".$fname." ".$lname;
                if($mood == 'happy'){
                    echo ". I'm glad you're happy today.</p>";
                }
                else if($mood = 'mad'){
                    echo ". I'm sorry you're mad today.</p>";
                }
                else {
                    echo ". I'm indifferent that you're indifferent to me today.</p>";
                }
                echo "<p>Your comments: ".$comments."</p>";
            }
        }
    ?>
</body>
</html>