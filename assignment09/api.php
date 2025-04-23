<?php

    if (!isset($_GET['command'])) {
        print "error: no command found";
        exit();
    }

    // connect to our database
    $path = 'databases';
    $db = new SQLite3($path.'/chat.db');

    // API call to save a message to the 'messages' table
    // requirements:
    //                  command = "savemessage"
    //                  $_POST['username'] (string)
    //                  $_POST['message'] (string)
    if ($_GET['command'] == 'savemessage' && isset($_POST['username']) && isset($_POST['message'])) {

        // construct a SQL statement to save this message to our database
        $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $statement->bindValue(':message', $_POST['message']);
        $result = $statement->execute();
        $id = $db->lastInsertRowID();

        // make sure the record was saved successfully and report back to the client
        if ($id) {
            print "success";
        }
        else {
            print "pass error";
        }
    }

    // API call to retrieve all messages from the 'messages' table after a given id
    // requirements:
    //                  command = "getmessages"
    //                  $_POST['id'] (integer)
    else if ($_GET['command'] == 'getmessages' && isset($_POST['id'])) {

        // construct a SQL statement to retrieve all messages greater than the supplied id
        $sql = "SELECT id, username, message, date FROM messages WHERE id > :id ORDER BY id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $_POST['id']);
        $result = $statement->execute();

        // construct an object to send back to the client
        // this object will have two properties:
        // - messages: an array of messages, ordered by id
        // - id: an integer representing the last id included in the messages array
        $send_back = [];
        $send_back['messages'] = [];
        $send_back['id'] = $_POST['id'];

        // iterate over the result set
        while ($row = $result->fetchArray()) {
            
            // store the result in an object
            $record = [];
            $record['id'] = $row[0];
            $record['username'] = $row[1];
            $record['message'] = $row[2];
            $record['date'] = $row[3];

            // push the object onto the 'messages' array
            array_push($send_back['messages'], $record);

            // update the 'id' variable to keep track of the largest id
            $send_back['id'] = $record['id'];
        }

        // encode the object as a JSON string and send it to the client
        print json_encode($send_back);
    }

    else if ($_GET['command'] == 'authenticate' && isset($_POST['username']) && isset($_POST['password'])) {
        $sql = "SELECT username, password FROM users WHERE (username = :username)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $result = $statement->execute();
        $send_back = [];
        if($result){
            while ($row = $result->fetchArray()) {
                $userpair = [];
                $userpair['username'] = $row[0];
                $userpair['password'] = $row[1];

                // push the object onto the 'messages' array
                array_push($send_back, $userpair);
            }
            print json_encode($send_back);
        }else{
            print "An error occured while authenticating user.";
        }
    }

    else if ($_GET['command'] == 'addnewuser' && isset($_POST['username']) && isset($_POST['password'])) {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $statement->bindValue(':password', $_POST['password']);
        $result = $statement->execute();
        if($result){
            print "php saved user name";
        }else{
            print "An error occured while adding new user.";
        }
    }

    // invalid command
    else {
        print "error";
    }

    // close the database and release it for the next request
    $db->close();
    unset($db);

?>
