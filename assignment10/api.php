<?php

$filename = getcwd() . '/data/todo_list.txt';

if ($_GET['command'] == 'save') {
    $items = $_POST['items'];
    if(!$items) {
        print "error: no items";
        exit();
    } else {
        file_put_contents($filename, $items);
        echo "success";
        exit();
    }
} 
else if ($_GET['command'] == 'load') {
    if ($filename) {
        $data = file_get_contents($filename);
        if ($data) {
            print $data;
        } 
    } else {
        print [];
    }
    exit();
}

else {
    echo "error: invalid request";
    exit();
}

?>