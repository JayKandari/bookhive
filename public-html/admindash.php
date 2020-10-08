<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use template\Menu;
use src\ProjectConfig;
use src\SessionCookie;
use src\book;

$session = new SessionCookie;
$conf = new ProjectConfig();

$session->admincheck();


$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href='<?php echo $conf->config['paths']['css'] . "/main.css"; ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
    <?php
    $menu->render_header();
    $menu->render_menu();
    echo '  <div class="main_content">';
  $k = new book;
  $row = $k->book_info($_SESSION["uno"], "ad");
  echo '</div>';
    ?>
 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>