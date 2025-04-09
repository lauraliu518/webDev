<!DOCTYPE html>
<html>
<head>
<style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 30px;
      font-family: sans-serif;
      background: lightpink; 
      min-height: 100vh;
      position: relative;
    }

    h1 {
      background-color: #3F51B5; 
      color: #FFFFFF;
      margin: 0 0 20px 0;
      padding: 20px;
      text-align: center;
      font-size: 2.5em;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #FFFFFF; 
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .bar {
      border: solid 1px #ccc;
      height: 50px;
      padding: 10px;
      margin: 10px 20px;
      color: #fff;
      line-height: 50px;
      font-weight: bold;
      border-radius: 4px;
      font-size: 10px;
    }

   
    #bartBar {
      background-color: #3F51B5; 
    }

    #lisaBar {
      background-color: #F7DE00; 
      color: #000; 
    }

    #homerBar {
      background-color: #8B572A; 
    }

    #margeBar {
      background-color: #F48FB1; 
      color: #3F51B5; 
    }

    a {
      display: inline-block;
      margin: 20px;
      text-align: center;
      color: #3F51B5;
      font-weight: bold;
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
