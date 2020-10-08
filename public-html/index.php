<?php

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\book;

use src\ProjectConfig;
use src\SessionCookie;
use template\Page;

$session = new SessionCookie;
$config = new ProjectConfig();
$page = new Page;

echo $page->head;
$page->menu->render_headNav();

echo '<div class="main_content">';
$k = new book;
$row = $k->disp_book("no");
$c = count($row);
echo '<div class="row">';
for ($x = 0; $x < $c; $x++) {
    echo '<div class="card main" >';
    echo '<div class="container">';
    echo '<img src="' . $config->config["paths"]["images"] . '/' . $row[$x]["path"] . '" class="book-img" alt="Avatar" >';
    echo '<p>Title:' . $row[$x]["title"] . '</p>';
    echo '<p>Author:' . $row[$x]["author"] . '</p>';
    echo '<p>Category:' . $row[$x]["category"] . '</p>';
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
echo '</div>';
echo '</div>';
if (isset($_POST["issue"])) {
    $k->issue($_POST["bid"], $_SESSION["uno"]);
}
echo $page->foot;
