<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Array Tester</title>
</head>
<body>
<?php

echo "<h1>#1 - Standard indexed array</h1>";
$array1 = array(55,66,77,88); // or [55,66,77,88]
$array1[] = 99;
$array1[0] = 11;
$count = 0;

for ($i = 0; $i < count($array1); $i++)
{
	$count += 1;
	echo $count . " " . $array1[$i] . "</br>";
}

echo "<h1>#2 - Associative array value</h1>";

echo "<h1>#3- Associative array value and key</h1>";

echo "<h1>#4 - Associative array build some links</h1>";

echo "<h1>#5 - Nested Asoociative Array - one at a time</h1>";

echo "<h1>#6 - Nested Asoociative Array - nested for loops</h1>";

?>
</body>
</html>
