<?php session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\book;
use src\ProjectConfig;
use src\SessionCookie;

$session = new SessionCookie;
$session->includeAccess();

$config = new ProjectConfig();


?>
<html>
<title>New Collection</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
</head>
<?php
if (isset($_SESSION["logged_in"])) {
    if ($_SESSION["admin"] == "admin") {
        include 'admindash.php';
    } else {
        include 'userdash.php';
    }
} else {
    include 'homepage.php';
}
?>

<body>
    <?php
    $k = new book;
    $row = $k->disp_book("yes");
    $c = count($row);
    for ($x = 0; $x < $c; $x++) {
        echo '<div class="card">';
        echo '<img src="' . $config->config["paths"]["images"] . '/' . $row[$x]["path"] . '" alt="Avatar" style="width:100%">';
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
</body>

</html>