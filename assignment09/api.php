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
        $sql = "SELECT COUNT(*) FROM users WHERE (username = :username AND password = :password)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $statement->bindValue(':password', $_POST['password']);
        $result = $statement->execute();
        $count = $result->fetchArray(SQLITE3_NUM)[0];
        if($count == 1){
            print "success";
        }else{
            $sql = "SELECT COUNT(*) FROM users WHERE (username = :username)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', $_POST['username']);
            $res = $statement->execute();
            $usernameCheck = $res->fetchArray(SQLITE3_NUM)[0];
            if($usernameCheck == 0){
                $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
                $statement = $db->prepare($sql);
                $statement->bindValue(':username', $_POST['username']);
                $statement->bindValue(':password', $_POST['password']);
                $saveCheck = $statement->execute();
                if($saveCheck){
                    print "new";
                }else{
                    print "An error occured while adding new user.";
                }
            }else{
               print "wrong"; 
            }
        }

    }

    else if ($_GET['command'] == 'roll' && isset($_POST['username'])) {
        // CREATE TABLE dieRolls (id INTEGER PRIMARY KEY, username TEXT, rollValue INTEGER, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);
        $rollValue = rand(1, 100);
        $sql = "INSERT INTO dieRolls (username, rollValue) VALUES (:username, :rollValue)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $_POST['username']);
        $statement->bindValue(':rollValue', $rollValue);
        $result = $statement->execute();
        if ($result) {
            $message = $_POST['username'] . " rolled a " . $rollValue . " on a 100-sided die\n\n";
            $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', 'SYSTEM MESSAGE');
            $statement->bindValue(':message', $message);
            $result = $statement->execute();
            $id = $db->lastInsertRowID();
        } 
    }

    else if ($_GET['command'] == 'rollhistory' && isset($_POST['username']) && isset($_POST['numberOfRollsToShow'])) {
        $sql = "SELECT username, rollValue, timestamp FROM dieRolls ORDER BY id DESC LIMIT :numberOfRollsToShow";
        $statement = $db->prepare($sql);
        $statement->bindValue(':numberOfRollsToShow', $_POST['numberOfRollsToShow']);
        $result = $statement->execute();
        if($result){
            $send_back = [];
            while ($row = $result->fetchArray()) {
                $pair = [];
                $pair['username'] = $row[0];
                $pair['rollValue'] = $row[1];
                $pair['timestamp'] = $row[2];
                array_push($send_back, $pair);
            }
            $message = $_POST['username'] . " requested the roll history for the last " . $_POST['numberOfRollsToShow'] . " rolls:\n\n";
            foreach ($send_back as $roll) {
                $message .= $roll['username'] . " rolled a " . $roll['rollValue'] . " on a 100-sided die at " . $roll['timestamp'] . "\n";
            }
            $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', 'SYSTEM MESSAGE');   
            $statement->bindValue(':message', $message);
            $result = $statement->execute();
            $id = $db->lastInsertRowID();
        }
    }

    else if ($_GET['command'] == 'coinflip' && isset($_POST['username'])) {
        $coinFlip = rand(0, 1);
        $message = $_POST['username'] . " flipped a coin - " . ($coinFlip ? "Heads" : "Tails") . "!\n\n";
        // CREATE TABLE coinFlips (    id INTEGER PRIMARY KEY AUTOINCREMENT,    head INTEGER,    tail INTEGER);
        $sql = "INSERT INTO coinFlips (head, tail) VALUES (:head, :tail)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':head', $coinFlip);
        $statement->bindValue(':tail', !$coinFlip);
        $result = $statement->execute();
        if($result){
            $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', 'SYSTEM MESSAGE');
            $statement->bindValue(':message', $message);
            $result = $statement->execute();
            $id = $db->lastInsertRowID();
        }
    }

    else if ($_GET['command'] == 'coinfliphistory' && isset($_POST['username']) && isset($_POST['numberOfCoinFlipsToShow'])) {
        $sql = "SELECT head, tail FROM coinFlips ORDER BY id DESC LIMIT :numberOfCoinFlipsToShow";
        $statement = $db->prepare($sql);
        $statement->bindValue(':numberOfCoinFlipsToShow', $_POST['numberOfCoinFlipsToShow']);
        $result = $statement->execute();
        if($result){
            $flipHistory = [];
            while ($row = $result->fetchArray()) {
                $flipHistory['head'] += $row[0];
                $flipHistory['tail'] += $row[1];
            }
            $message = $_POST['username'] . " requested the coin flip history for the last " . $_POST['numberOfCoinFlipsToShow'] . " flips:\n\n";
            $message .= "Heads: " . $flipHistory['head'] . "\n";
            $message .= "Tails: " . $flipHistory['tail'] . "\n";
            $sql = "INSERT INTO messages (username, message) VALUES (:username, :message)";
            $statement = $db->prepare($sql);
            $statement->bindValue(':username', 'SYSTEM MESSAGE');
            $statement->bindValue(':message', $message);    
            $result = $statement->execute();
            $id = $db->lastInsertRowID();   
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
