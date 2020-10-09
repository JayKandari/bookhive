<html>
<title>Search book</title>
<?php

// Load resource files
require_once($_SERVER["DOCUMENT_ROOT"] . "/../vendor/autoload.php");

use src\SessionCookie;
use template\Menu;
use src\book;
use src\ProjectConfig;

$session = new SessionCookie;
$config = new ProjectConfig;

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
    <div class="main_content">

        <div class="main">
            <div class='header'>
                <h1>Search Books</h1>
            </div>

            <form action="searchbook.php" method="post">

                <?php

                if (isset($_SESSION["searchmsg"])) {
                    echo ('<p id="e">' . $_SESSION["searchmsg"] . "</p>\n");
                    unset($_SESSION["searchmsg"]);
                }
                if (isset($_POST["submit_search"])) {
                    $title =  $_POST['search_query'];
                    $author = $_POST['author'];
                    $catergory = $_POST['category'];
                } else {
                    $title =  '';
                    $author = '';
                    $catergory = '';
                }
                ?>
                <div class="search-inputs">
                <span>
                    <i class="fa fa-search"></i>
                    <input type='text' name='search_query' placeholder='Enter title of the book' value='<?php echo $title; ?>'>
                </span><br>
                <span>
                    <i class="fa fa-pen-nib"></i>
                    <input type='text' name='author' placeholder='Author Name' value='<?php echo $author; ?>'>
                </span><br>
                <span>
                    <i class="fa fa-list"></i>
                    <input type='text' name='category' placeholder='Category/Genre' value='<?php echo $catergory; ?>'>
                </span><br>
                <button name="submit_search" class="bmarg"> Search </button>

            </form>


            <?php
            if (isset($_POST["submit_search"])) {
                $book = new book();
                $values = array(
                    'title' => $_POST["search_query"],
                    'author' => $_POST["author"],
                    'category' => $_POST["category"]
                );
                $result = $book->search($values);
                if ($result) {
                    echo '<div class="row">';
                    foreach ($result as $row) {
                        echo '
                    <div class="card main" >
                    <div class="container">
                    <img src="' . $config->config["paths"]["images"] . '/' . $row['ipath'] . '" class="book-img" alt="Avatar" >
                    <p><b>Title:</b>  ' . $row['title'] . '</p>
                    <p><b>Author:</b>  ' . $row['author'] . '</p>
                    <p><b>Category:</b>  ' . $row['category'] . '</p>';
                        if ($session->loginAccess()) {
                            echo '<form method="post">';
                            echo '<input type="hidden" name="bid" value="' . $row["id"] . '"/>';
                            echo '<button name="issue">ISSUE BOOK </button>';
                            echo '</form>';
                            if ($_SESSION['admin'] == 'admin') {
                                echo "</td><td data-label='Edit_book'>
                               <a href='addbook.php?idb=" . $row['id'] . "'><button name='edit-book'> Edit </button></a> 
                        ";
                            }
                        } else {
                            echo '<h4><a href="login.php"><button>Login to issue book</button></a></h4>';
                        }
                        echo '</div>
                    </div>
                    ';
                    }
                    echo '</div>';
                    echo '</div>';
                } else {
                    $_SESSION["searchmsg"] = "Sorry ! No books found!!";
                    header("LOCATION: searchbook.php");
                }
            }
            ?>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>