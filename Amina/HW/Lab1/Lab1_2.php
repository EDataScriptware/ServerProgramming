<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 1b -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Lab 1b</title>
</head>
<body>
    <?php
        echo "<h1>Question #2</h1>";
        $array1 = array(87,75,93,95);
        $avg = 0;

        for($i = 0; $i < count($array1); $i++){
            $avg += $array1[$i];
        }

        $avg = $avg / count($array1);
        echo "Average test score is $avg.";
    ?>
</body>
</html>