<!doctype html>
<html>
    <head>
        <title>Assignment 8</title>
        <style>
            table {
                width: 100%;
                margin: 0 auto 30px auto;
                padding: 30px 32px 24px 32px;
            }

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
        </style>
    </head>
    <body>
        <h1>Movie Database</h1>

        <div id="selectionBar">
            <a href="index.php"><div class="link">View All</div></a>
            <a href="add_form.php"><div class="link">Add Movie</div></a>
            <a href="search_form.php"><div class="link">Search Movies</div></a>
        </div>

        <table border="1" width="100%">
            <tr>
                <td>Movie</td>
                <td>Title</td>
                <td>Options</td>
            </tr>


            <?php
            include('config.php');

            // connect to our database!
            $db = new SQlite3(getcwd() . '/databases/movies.db');

            if($_GET['delete']){
                $idToDelete = $_GET['delete'];
                $sql = "DELETE FROM movies WHERE id = $idToDelete";
                $statement = $db->prepare($sql);
                $result = $statement->execute();

            ?>

            <div class="saved">Movie deleted successfully.</div>
            
            <?php
            }
            ?>
            <?php

            // use a SQL query to grab all movie records
            $sql = "SELECT id, title, year FROM movies ORDER BY title, year";
            $statement = $db->prepare($sql);
            $result = $statement->execute();

            // render movie records into the table
            while ($row = $result->fetchArray()) {

                $id = $row[0];
                $title = $row[1];
                $year = $row[2];

                $deletePath = "index.php?delete=$id";

                print "<tr>";
                print "    <td>$title</td>";
                print "    <td>$year</td>";
                print "    <td><a href=$deletePath>DELETE</a></td>";
                print "</tr>";
            }

            $db->close();
            unset($db);
            ?>

        </table>

    </body>
</html>