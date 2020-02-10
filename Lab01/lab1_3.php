<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Lab01 Scripts</title>

    </head>
<body>
    <?php 
    echo "<h1>Sample output for all three scripts</h1>";
    echo "<h2>Question 01</h2>";
    echo "<p>Hello World</p>";
    echo "<hr>";
    echo "<h2>Question 02</h2>";
    echo "<p>Average Test Scores is ";
    
    $testScores[0] = 87;
    $testScores[1] = 75;
    $testScores[2] = 93;
    $testScores[3] = 95;
    $numberOfScores = count($testScores);
    
    $totalTestScores = 0;

    for ($i = 0; $i < $numberOfScores; $i++)
    {
        $totalTestScores += $testScores[$i];
    }

    $averageTestScores = $totalTestScores / $numberOfScores;

    echo $averageTestScores . "</p>";
    echo "<hr>";
    echo "<h2>Question 03</h2>";
    echo "<p>Average Test Scores is ";

    $testSecondScores[0] = 87;
    $testSecondScores[1] = 75;
    $testSecondScores[2] = 93;
    $testSecondScores[3] = 95;
    
    $totalSecondTestScores = 0;
    // $averageSecondTestScores = 0.00;
    $numberOfSecondScores = count($testSecondScores);

    unset($testSecondScores[1]);

    $count = 0;

    for ($i = 0; $i < $numberOfSecondScores; $i++)
    {        
        if (isset($testSecondScores[$i]))
        {
            $totalSecondTestScores += $testSecondScores[$i];
            $count += 1;
        }   

    }

    

    $averageSecondTestScores = $totalSecondTestScores / $count;

    echo $averageSecondTestScores ."</p>";



?>
</body>


</html>