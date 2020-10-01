<?php 
// session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\book;
use src\ProjectConfig;
use src\SessionCookie;
use template\Menu;

$session = new SessionCookie;

$config = new ProjectConfig();



if (isset($_SESSION["logged_in"])) {
    $menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
} else {
    $menu = new Menu(basename(__FILE__));
}

?>
<html>
<title>New Collection</title>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>


<body>
    <?php
    $menu->render_header();
    $menu->render_menu();
    echo '<div class="main_content">';

    echo "<div class='header'>
        <h1>New Arrivals</h1>
        </div>";
    $k = new book;
    $row = $k->disp_book("yes");
    $c = count($row);
    echo "<div class='row'>";
    for ($x = 0; $x < $c; $x++) {
        echo '<div class="card main">';
        echo '<div class="container">';
        echo '<img src="' . $menu->paths["images"] . "/" . $row[$x]["path"] . '" class="book-img" alt="Avatar" >';
        echo '<h4><b>' . $row[$x]["title"] . '</b></h4>';
        echo '<h4><b>' . $row[$x]["author"] . '</b></h4>';
        echo '<h4><b>' . $row[$x]["category"] . '</b></h4>';
        if (isset($_SESSION["logged_in"])) {
            echo '<form method="post">';
            echo '<input type="hidden" name="bid" value="' . $row[$x]["id"] . '"/>';
            echo '<button name="issue">ISSUE BOOK </button>';
            echo '</form>';
        } else {
            echo '<h4><a href="login.php"><button>Login to issue book</button></a></h4>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo "</div>";
    if (isset($_POST["issue"])) {
        $k->issue($_POST["bid"], $_SESSION["uno"]);
    }
      echo '</div">';

    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>