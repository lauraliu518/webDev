<!DOCTYPE html>
<html>
    <head>
        <title>Assignment 07</title>
        <style>
            .error {
                background-color: red;
                color: white;
                padding: 10px;
                width: 100%;
                height: 50px;
            }
        </style>
    </head>
    <body>
        <h1>Assignment 07</h1>

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



