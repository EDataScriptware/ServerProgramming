<?php

class MyUtils{

	static function html_header($title="Untitled",$styles=""){
		$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xh
tml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>$title</title>
	<link href="$styles" type="text/css" rel="stylesheet" />
</head>
<body>\n
END;
	return $string;
}


	static function html_footer($text=""){
		$string ="\n$text\n</body>\n</html>";
		return $string;
	}

} // end class


// https://serenity.ist.rit.edu/~emr9018/341/Notes/Day14/MyUtils.class.php

/* 
- exam on Wednesday
- - Multiple choices, True/False, Multiple Select, Short Answer, Show/Complete Code Snippets

//ex:
$Arr = array("Dog" => array(1,2,3), "Cat" => array(4,5,6), "CatTwo"=>array("Food"=>"Shake", "Makeup"=>"Chocolate"));


*/
?>