<html>
<body>
    <?php $title = "First PHP Program";
        // Single ling
        /*
            multi line comment

        */
    ?>
    <h1><?php echo "<p>Hi World! - $title</p>";
    echo "<br /> Name is ".$_GET['name']."<br />";
    ?>
    </h1>

    <?php 
        $version = phpversion();
        echo "<h2>The version of php is $version</h2>";
        phpinfo();

        var_dump($_SERVER);
    ?>
</body>
</html>