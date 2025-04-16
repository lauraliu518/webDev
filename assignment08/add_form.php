<!doctype html>
<html>
    <head>
        <title>Assignment 8</title>
        <style>
body {
                margin: 0;
                padding: 0;
            }
            h1 {
                text-align: center;
                margin-top: 30px;
            }
            #selectionBar {
                display: flex;
                justify-content: center;
                margin: 30px 0 40px 0;
            }
            #selectionBar a div {
                color: black;
                padding: 12px 28px;
                font-weight: 500;
            }
            form {
                background: #fff;
                margin: 0 auto 30px auto;
                padding: 30px 32px 24px 32px;
                display: flex;
                flex-direction: column;
            }
            
            ul {
                background: #fff;
                margin: 18px auto;
                padding: 18px 24px;
                border-radius: 7px;
            }
            ul li {
                font-size: 1.08rem;
                color: #222;
                padding: 6px 0;
            }
            .saved {
                background-color: #43a047;
                color: #FFFFFF;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 4px;
                text-align: center;
            }
            .error {
                background-color: #e53935;
                color: #FFFFFF;
                padding: 10px;
                margin-bottom: 20px;
                text-align: center;
                margin-left: auto;
                margin-right: auto;
            }

            form input[type="submit"] {
                background: #lightpurple;
                color: #000;
                border: none;
                border-radius: 4px;
                padding: 12px 0;
                font-size: 1rem;
                font-weight: 600;
            }
        </style>
    </head>
    <body>
        <h1>Movie Database</h1>

        <div id="selectionBar">
            <a href="index.php"><div>View All</div></a>
            <a href="add_form.php"><div>Add Movie</div></a>
            <a href="search_form.php"><div>Search Movies</div></a>
        </div>

        <?php
            include('config.php');
            $submitted = $_GET['submitted'];
            $movieName = $_GET['movieName'];
            $movieYear = $_GET['movieYear'];
            if($submitted == "Submit"){
                if (!$movieName || !$movieYear) {
        ?>

        <div class="error">Fill out the form!</div>

        <?php
                }else if($submitted=="Submit"){
                    $db = new SQlite3(getcwd() . '/databases/movies.db');
                    $sql = "insert into movies (title, year) values (:movieName, :movieYear);";
                    $statement = $db->prepare($sql);
                    $statement->bindValue(':movieName', $movieName);
                    $statement->bindValue(':movieYear', $movieYear);
                    $result = $statement->execute();

                    $db->close();
                    unset($db);
            
        ?>
        
        <div class="saved">Movie saved successfully.</div>

        <?php
                }
            }
        ?>

        <form action="add_form.php" method="GET">
            Movie Name: <input type="text" name="movieName"> <br>
            Year: <input type="text" name="movieYear"> <br>
            <input type="submit" name="submitted">
        </form>



    </body>
</html>