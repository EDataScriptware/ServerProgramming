<html>
    <body>
        <?php
            // Single line comment

            /*
                Multi-line comment
            */


            $title = "First PHP Program!";

        ?>


    </body>
    <h1>
        <?php 
            echo "<p>Hello World! - $title</p>";
            echo "<br /> Name is " . $_GET['name'] ;

            $version = phpversion();
            echo "<h2>PHP version is $version</h2>";

            // Do not leave this in assignments - will leak server information and allow hackers get your information 
            // phpinfo();


            // Tells you variable/object details. 
            var_dump($title);

        ?>
    </h1>

</html>