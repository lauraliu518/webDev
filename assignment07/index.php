<!DOCTYPE html>
<html>
    <head>
        <title>What's Your Simpsons Character?</title>
        <style>
            * {
                box-sizing: border-box;
            }
            
            body {
                margin: 0;
                padding: 30px;
                font-family: sans-serif;
                background: #F7DE00; 
                line-height: 1.6;
                min-height: 100vh;
                position: relative;
            }
            
            h1 {
                background-color: #3F51B5; 
                color: #FFFFFF;
                margin: 0;
                padding: 20px;
                text-align: center;
                font-size: 2.5em;
            }
            
            .container {
                max-width: 800px;
                margin: 30px auto;
                background: #FFFFFF; 
                padding: 25px;
                border-radius: 8px;
            }
            
            .error {
                background-color: #8B572A;
                color: #FFFFFF;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 4px;
                text-align: center;
            }
            
            form {
                display: flex;
                flex-direction: column;
            }
            
            form label,
            form select {
                display: block;
                width: 100%;
            }
            
            form label {
                font-weight: bold;
                margin-bottom: 5px;
            }
            
            form select {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 1em;
            }
            
            input[type="submit"] {
                background-color: #F48FB1;
                color: #3F51B5;          
                padding: 10px;
                border: none;
                border-radius: 4px;
                font-size: 1.1em;
                margin-top: 10px;
            }
            
            input[type="submit"]:hover {
                background-color: #F9ABC9; 
            }
            
            img {
                display: block;
                margin: 20px auto;
                max-width: 100%;
                height: auto;
                border-radius: 4px;
                /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            }
        </style>


    </head>
    <body>
        <h1>What's Your Simpsons Character?</h1>

        <?php
            include('config.php');

            if($_GET['tryagain']=="true"){
                setcookie('character', '', time()-3600);
                $character = "";
            }else{
                $character = $_GET['character'];
                if(!$character){
                    $character = $_COOKIE["character"];
                }
            }

            $error = $_GET['error'];
            if ($error && $error == "missingstuff") {
        ?>

        <div class="error">Fill out the form!</div>

        <?php
            }else if ($error && $error == "invalidcharacter"){
        ?>

        <div class="error">Error: Please choose a valid answer.</div>

        <?php
            }else if ($error && $error == "cannotprocessresult"){
        ?>

        <div class="error">Error: Cannot process result.</div>

        <?php
            }
        ?>

        <?php
            if(!$character){
        ?>
        <form action="process.php" method="GET">
            <div>
                What is your favourite food?
                <select id="food" name="food">
                    <option value="empty">Select an option</option>
                    <option value="bart">Pizza</option>
                    <option value="homer">Cake</option>
                    <option value="lisa">Apples</option>
                    <option value="marge">Biscuit</option>
                </select>
            </div>
            <div>
                What is your favorite activity?
                <select id="activity" name="activity">
                    <option value="empty">Select an option</option>
                    <option value="bart">Skateboard</option>
                    <option value="homer">Sleep</option>
                    <option value="lisa">Study</option>
                    <option value="marge">Knit</option>
                </select>
            </div>
            <div>
                What is your biggest fear?
                <select id="fear" name="fear">
                    <option value="empty">Select an option</option>
                    <option value="bart">Sock puppets</option>
                    <option value="homer">Flying</option>
                    <option value="lisa">School</option>
                    <option value="marge">I have no fear</option>
                </select>
            </div>
            <input type="submit">
        </form>
        <?php
            }else{
                $filename = "";

                if ($character == 'bart') {
                    $filename = 'Bart.png';
                }
                else if ($character == 'lisa') {
                    $filename = 'Lisa.png';
                }
                else if ($character == 'homer') {
                    $filename = 'Homer.png';
                }
                else if ($character == 'marge') {
                    $filename = 'Marge.png';
                }

                if ($filename) {
                    print "<img src=images/$filename>";
                }
        ?>
        <a href="index.php?tryagain=true">Try Again</a>
        <?php
            }
        ?>

        <a href="results.php">Results</a>
        
    </body>
</html>



