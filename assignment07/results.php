<!DOCTYPE html>
<html>
<head>
    <style>
        .bar{
            border: solid 1px black;
            height: 50px;
            padding: 10px;
            margin-left: 20px;
            margin-right: 20px;
        }

        #bartBar{
            background-color: lightblue;
        }

        #lisaBar{
            background-color: lightyellow;
        }

        #homerBar{
            background-color: lightgreen;
        }

        #margeBar{
            background-color: pink;
        }
    </style>
</head>

<body>
    <h1>Results</h1>

    <?php

        // for MAMP - hide any PHP errors from the browser
        include('config.php');

        // access the text file 
        $resultsPath = getcwd() . '/data/results.txt';
        $data = file_get_contents($resultsPath);


        // isolate each character 
        $line = explode("\n", $data);

        // generate bar chart
        $bartCount = 0;
        $homerCount = 0;
        $lisaCount = 0;
        $margeCount = 0;

        for ($i = 0; $i < count($line); $i++) {
            if ($line[$i] == "bart"){
                $bartCount = $bartCount + 1;
            }else if ($line[$i] == "homer"){
                $homerCount = $homerCount + 1;
            }else if ($line[$i] == "lisa"){
                $lisaCount = $lisaCount + 1;
            }else if ($line[$i] == "marge"){
                $margeCount = $margeCount + 1;
            }
        }
        $bartPercent = $bartCount/($bartCount+$homerCount+$lisaCount+$margeCount);
        $homerPercent = $homerCount/($bartCount+$homerCount+$lisaCount+$margeCount);
        $lisaPercent = $lisaCount/($bartCount+$homerCount+$lisaCount+$margeCount);
        $margePercent = $margeCount/($bartCount+$homerCount+$lisaCount+$margeCount);
    ?>
    <div id="barsContainer">
        <div id="bartBar" class="bar" style="width:<?php echo $bartPercent*100;?>%;">
            Bart <?php echo $bartPercent*100;?>%
        </div>
        <div id="homerBar" class="bar" style="width:<?php echo $homerPercent*100;?>%;">
            Homer <?php echo $homerPercent*100;?>%
        </div>
        <div id="lisaBar" class="bar" style="width:<?php echo $lisaPercent*100;?>%;">
            Lisa <?php echo $lisaPercent*100;?>%
        </div>
        <div id="margeBar" class="bar" style="width:<?php echo $margePercent*100;?>%;">
            Marge <?php echo $margePercent*100;?>%
        </div>
    </div>

    <a href="index.php">Back to quiz</a>
</body>
</html>
