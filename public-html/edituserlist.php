<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\user;
use src\SessionCookie;
use template\Menu;

$session = new SessionCookie;
$session->adminCheck();

$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);

?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
  <table>
    <thead>
    <tr>
      <th>User Numner</th>
      <th>User Name</th>
      <th>User Password</th>
      <th>Email</th>
      <th>Type</th>
      <th>Change Type</th>
      <th>Edit Operation</th>
    </tr>
    </thead>
  <tbody>
    <?php
    $menu->render_header();
    $menu->render_menu();
    $k = new user;
    $k->user_info();
    ?>
  </tbody>
  </table>
  <!-- Include scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
  <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>