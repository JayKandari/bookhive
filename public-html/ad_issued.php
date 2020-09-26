<!DOCTYPE html>
<html>
<title>Edit Book</title>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use template\Menu;
use src\book;

use src\ProjectConfig;
use src\SessionCookie;

$session = new SessionCookie;
$conf = new ProjectConfig();
$session->admincheck();
$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);

?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">

</head>

<body>
  <?php



  ini_set("display_errors", 1);
  error_reporting(E_ALL);

  $menu->render_header();
  $menu->render_menu();

  $k = new book;
  $row = $k->book_info($_SESSION["uno"], "ad");

  ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
  <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>