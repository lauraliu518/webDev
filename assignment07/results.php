<!DOCTYPE html>
<html>
<head>
</head>

<body>
    <h1>Results</h1>

    <?php
        error_reporting(0);
        $filepath = getcwd() . '/data/results.txt';

        // access the text file 
        $data = file_get_contents($filepath);

        // isolate each character 
        $line = explode("\n", $data);

        // generate counts
        $bartCount = 0;
        $homerCount = 0;
        $lisaCount = 0;
        for ($i = 0; $i < count($line); $i++) {
            if ($line[$i] == "bart"){
                $bartCount = $bartCount + 1;
            }else if ($line[$i] == "homer"){
                $homerCount = $homerCount + 1;
            }else if ($line[$i] == "lisa"){
                $lisaCount = $lisaCount + 1;
            }
        }
        
        //generate bar charts

    ?>
</body>
</html>