<?php session_start();
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
    $k = new book;
    $row = $k->disp_book("yes");
    $c = count($row);
    for ($x = 0; $x < $c; $x++) {
        echo '<div class="card">';
        echo '<img src="' . $menu->paths["images"] . "/" . $row[$x]["path"] . '" alt="Avatar" style="width:100%">';
        echo '<div class="container">';
        echo '<h4><b>' . $row[$x]["title"] . '</b></h4>';
        echo '<h4><b>' . $row[$x]["author"] . '</b></h4>';
        echo '<h4><b>' . $row[$x]["category"] . '</b></h4>';
        if (isset($_SESSION["logged_in"])) {
            echo '<form method="post">';
            echo '<input type="hidden" name="bid" value="' . $row[$x]["id"] . '"/>';
            echo '<button name="issue">ISSUE BOOK </button>';
            echo '</form>';
        } else {
            echo '<h4><b><a href="login.php">Login to issue book</a></b></h4>';
        }
        echo '</div>';
        echo '</div>';
    }
    if (isset($_POST["issue"])) {
        $k->issue($_POST["bid"], $_SESSION["uno"]);
    }

    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>