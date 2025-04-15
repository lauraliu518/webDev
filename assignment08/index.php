<!doctype html>
<html>
    <head>
        <title>Assignment 8</title>
        <style>
            table {
                width: 100%;
            }

            /* .link{
                width: 30px;
                height: 10px;
                background-color: lightblue;
            } */
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
            }

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