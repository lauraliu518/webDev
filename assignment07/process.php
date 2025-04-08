<?php

    // grab the incoming data
    $food = $_GET['food'];
    $activity = $_GET['activity'];
    $fear = $_GET['fear'];
    $dataArray = array($food, $activity, $fear);

    // make sure the user filled everything out
    if ($food == 'empty' || $activity == 'empty' || $fear == 'empty') {
        // if not, generate an error message
        header("Location: index.php?error=missingstuff");
        exit();
    }


    // if everything is OK, diagnose the character!
    $bart = 0;
    $homer = 0;
    $lisa = 0;
    $marge = 0;

    foreach($dataArray as $data){
        if ($data == 'bart') {
            $bart++;
        }
        else if ($data == 'homer') {
            $homer++;
        }
        else if ($data == 'lisa') {
            $lisa++;
        }
        else if ($data == 'marge') {
            $marge++;
        }
        else {
            header("Location: index.php?error=invalidcharacter");
            exit();
        }
    }

    // if ($food == 'bart') {
    //     $bart++;
    // }
    // else if ($food == 'homer') {
    //     $homer++;
    // }
    // else if ($food == 'lisa') {
    //     $lisa++;
    // }
    // else if ($food == 'marge') {
    //     $marge++;
    // }
    // else {
    //     header("Location: index.php?error=invalidcharacter");
    //     exit();
    // }


    // if ($activity == 'bart') {
    //     $bart++;
    // }
    // else if ($activity == 'homer') {
    //     $homer++;
    // }
    // else if ($activity == 'lisa') {
    //     $lisa++;
    // }
    // else if ($activity == 'marge') {
    //     $marge++;
    // }
    // else {
    //     header("Location: index.php?error=invalidcharacter");
    //     exit();
    // }

    // absolute file path to our results file
    $filename = getcwd() . '/data/results.txt';


    if ($bart >= $homer && $bart >= $lisa && $bart >= $marge) {
        // store the name of the character in our text file
        file_put_contents($filename, "bart\n", FILE_APPEND);
        setcookie('character', 'bart');
        header("Location: index.php?character=bart");
        exit();
    }
    else if ($homer >= $bart && $homer >= $lisa && $homer >= $marge) {
        file_put_contents($filename, "homer\n", FILE_APPEND);
        setcookie('character', 'homer');
        header("Location: index.php?character=homer");
        exit();
    }
    else if ($lisa >= $bart && $lisa >= $homer && $lisa >= $marge) {
        file_put_contents($filename, "lisa\n", FILE_APPEND);
        setcookie('character', 'lisa');
        header("Location: index.php?character=lisa");
        exit();
    }
    else if ($marge >= $bart && $marge >= $lisa && $marge >= $homer) {
        file_put_contents($filename, "marge\n", FILE_APPEND);
        setcookie('character', 'marge');
        header("Location: index.php?character=marge");
        exit();
    }
    else {
        header("Location: index.php?error=cannotprocessresult");
        exit();
    }


?>
