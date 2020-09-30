<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\ProjectConfig;
use src\SessionCookie;

$session = new SessionCookie;
$conf = new ProjectConfig();
$session->admincheck();
?>
<!DOCTYPE html>
<html>
<title>Edit Book</title>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use template\Menu;

$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);

?>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
  <table>
    <thead>
    <tr>
      <th>Book ID</th>
      <th>Book Title</th>
      <th>Author </th>
      <th>Category</th>
      <th>Added On</th>
      <th>Quantity</th>
      <th>Availability</th>
      <th>Path</th>
      <th colspan="2">Operations</th>
    </tr>
</thead>
<tbody>
    <?php

    use src\book;

    $menu->render_header();
    $menu->render_menu();
    $k = new book;
    $k->edit();
    ?>
    </tbody>
  </table>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
  <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>