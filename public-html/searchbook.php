<html>
<title>Search book</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
</head>
<?php
// Include header and sidebar
include 'homepage.php';
// Load resource files
require_once($_SERVER["DOCUMENT_ROOT"] . "/../vendor/autoload.php");

use PDO_CONN\Connection;
?>

<body>
    <div class="container search-div">
        <form action="searchbook.php" method="post">

            <?php
            if (isset($_POST["submit_search"])) {
                echo "Title:<input type='text' name='search_query' value='" . $_POST['search_query'] . "' ><br>Filter by:<br>";
                echo "Author:<input type='text' name='author' value='" . $_POST['author'] . "'><br>";
                echo "Category:<input type='text' name='category' value='" . $_POST['category'] . "'>";
            } else {

            ?>
                Title:<input type='text' name='search_query' placeholder='Enter title of the book'>
                <br>
                <br>
                Filter by
                <br>
                Author:<input type='text' name='author' placeholder='Author Name'><br>
                Category:<input type='text' name='category' placeholder='Category/Genre'>
            <?php } ?>
            <input type="submit" value="Search" name="submit_search">

        </form>
    </div>
    <?php

        
        if (isset($_POST["submit_search"])) {
            // Fetch search result from DB
            $conn = new Connection();

            $query = "SELECT * from Book WHERE title like '%" . $_POST["search_query"] . "%' ";
            if ($_POST["author"] != "") {
                $query = $query . " AND author like '%" . $_POST["author"] . "%'";
            }
            if ($_POST["category"] != "") {
                $query = $query . " AND category like '%" . $_POST["category"] . "%'";
            }
            $result = $conn->exeQuery($query);
            if ($result) {  


    ?>
            <table legend="2px">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                    <?php
                    // Display result as table
                    foreach ($result as $row) {
                        echo "<tr>
                     <td>" . $row['title'] . "</td>
                     <td>" . $row['author'] . "</td>
                     <td>" . $row['category'] . "</td><td>";
                        if (isset($_SESSION["logged_in"])) {
                            echo '<form method="post">';
                            echo '<input type="hidden" name="bid" value="' . $row["id"] . '"/>';
                            echo '<button name="issue">ISSUE BOOK </button>';
                            echo '</form>';
                        } else {
                            echo '<h4><b><a href="login.php">Login to issue book</a></b></h4>';
                        }
                        echo "</td></tr>";
                    }

                    ?>
                </tbody>
            </table>
    <?php

        }
    }
    ?>
</body>

</html>