<html>
<title>Search book</title>
<?php

// Load resource files
require_once($_SERVER["DOCUMENT_ROOT"] . "/../vendor/autoload.php");

use src\SessionCookie;
use template\Menu;
use src\Connection;

$session = new SessionCookie;

if (isset($_SESSION["logged_in"])) {
    $menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
} else {
    $menu = new Menu(basename(__FILE__));
}
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>


<body>
    <?php
    $menu->render_header();
    $menu->render_menu();
    ?>
    <div class="container">
		<div class="main">
        <div class="header">
		</div>

    <!-- <div class="container search-div"> -->
        <form action="searchbook.php" method="post">
        
            <?php 

            if (isset($_SESSION["searchmsg"])) {
                echo ('<p id="e">' . $_SESSION["searchmsg"] . "</p>\n");
                unset($_SESSION["searchmsg"]);
             }
            if (isset($_POST["submit_search"])) {
                echo "Title:<input type='text' placeholder='Enter title of the book' name='search_query' value='" . $_POST['search_query'] . "' ><br>";
                echo "Author:<input type='text' placeholder='Author Name' name='author' value='" . $_POST['author'] . "'><br>";
                echo "Category:<input type='text' placeholder='Category/Genre' name='category' value='" . $_POST['category'] . "'>";
            }
            else {

            ?>
                Title:<input type='text' name='search_query' placeholder='Enter title of the book'>          
                Author:<input type='text' name='author' placeholder='Author Name'>
                Category:<input type='text' name='category' placeholder='Category/Genre'>
            <?php } ?>
            <input type="submit" value="Search" name="submit_search">

        </form>
    </div>
    </div>
    <!-- </div> -->

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
        else{
            $_SESSION["searchmsg"] = "Sorry ! No books found!!";
            header("LOCATION: searchbook.php");
            
        }
    }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>