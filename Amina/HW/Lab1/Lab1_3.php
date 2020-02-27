<!-- Amina Mahmood -->
<!-- ISTE 341 -->
<!-- Server Programming -->
<!-- Professor Bryan French -->
<!-- HW Lab 1c -->
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Lab 1c</title>
</head>
<body>
    <?php
        echo "<h1>Question #3</h1>";
        $array1 = array(87,75,93,95);
        $avg = 0;
        unset($array1[1]);
        foreach($array1 as $val) {
            $avg += $val;
        }

        $avg = $avg / count($array1);
        echo "Average test score is $avg.";
    ?>
</body>
</html>

