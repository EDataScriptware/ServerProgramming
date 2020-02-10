<?php 

    $expire = time() + 10; // Ten seconds from now
    $path = "/~emr9018/";
    $domain = "serenity.ist.rit.edu";
    $secure = false;

    setcookie("test_cookie", "chocolate chip", $expire, $path, $domain, $secure);

    $counter = $_COOKIE["counter"];
    $counter++;
    setcookie("counter", $counter, $expire, $path, $domain, $secure);
    
    $getCounter = $_COOKIE["counter"];
    
    echo "<h2>counter=$getCounter</h2>";

    echo "<h2>\$_COOKIE Variables</h2>";
    foreach ($_COOKIE as $k => $v)
    {
        echo "$k=$v<br />";
    }

?>