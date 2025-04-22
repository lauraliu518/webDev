<?php
    if (!isset($_GET['command'])) {
        print "error1";
        exit();
    }

    $path = '/home/databases';
    $db = new SQLite3($path.'/chat.db');        

    // command: get_messages
    if ($_GET['command'] == 'get_messages') {

        $sql = "SELECT id, message, username, date FROM messages ORDER BY date";
        $statement = $db->prepare($sql);
        $result = $statement->execute();

        

        // set up an array in PHP to store the results
        $send_back = [];

        // turn the array into a JSON string
        while ($row = $result->fetchArray()) {
            $record = [];
            $record['id'] = $row[0];
            $record['message'] = $row[1];
            $record['username'] = $row[2];
            $record['date'] = $row[3];
            array_push( $send_back, $record );
        }

        // send back to the client
        print json_encode($send_back);
        exit();

    }

    // command: save_message
    // requires a 'message' variable sent via POST
    //          a 'username' variable sent via POST
    if ($_GET['command'] == 'save_message') {


        // construct a SQL statement
        $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $statement->bindValue(':message', $_POST['message']);
        $result = $statement->execute();
        $id = $db->lastInsertRowID();

        // tell the browser everything worked
        if ($id) {
            print "success";
        }
        else {
            print "error2";
        }
    }    
?>
