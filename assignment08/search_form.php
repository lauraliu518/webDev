<!doctype html>
<html>
    <head>
        <title>Assignment 8</title>
        <style>
            table {
                width: 100%;
            }

            .saved {
                background-color: lightgreen;
                color: #FFFFFF;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 4px;
                text-align: center;
            }

            .error {
                background-color: red;
                color: #FFFFFF;
                padding: 10px;
                margin-bottom: 20px;
                border-radius: 4px;
                text-align: center;
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
            $submitted = $_GET['searched'];
            $movieName = $_GET['movieName'];
            $movieYear = $_GET['movieYear'];
            if($submitted == "Submit"){
                if (!$movieName || !$movieYear) {
        ?>

        <div class="error">Fill out the form!</div>

        <?php
                }else if($submitted == "Submit"){
                    $search = "%$movieName%";
                    $db = new SQlite3(getcwd() . '/databases/movies.db');
                    $sql = "select * from movies where title like $search;";
                    $statement = $db->prepare($sql);
                    $result = $statement->execute();

                    

                    while ($row = $result->fetchArray()) {

                        $id = $row[0];
                        $title = $row[1];
                        $year = $row[2];
        
                        print "<ul>";
                        print "    <li>$title $year</li>";
                        print "</ul>";
                    }

                    $db->close();
                    unset($db);
            
        ?>
        
        <div class="error">Movie saved successfully.</div>

        <?php
                }
            }

            
        ?>

        <form action="search_form.php" method="GET">
            Movie Name: <input type="text" name="movieName"> <br>
            Year: <input type="text" name="movieYear"> <br>
            <input type="submit" name="searched">
        </form>

    </body>
</html>