<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/../vendor/autoload.php");

use src\SessionCookie;
use template\Menu;

$session = new SessionCookie;

?>
<html>
<title>About us</title>

<head>
    <?php
    if (isset($_SESSION["logged_in"])) {
        $menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
    } else {
        $menu = new Menu(basename(__FILE__));
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>

</head>
<body>
    <?php
    $menu->render_header();
    $menu->render_menu();
    ?>
    <div class="main_content">

    <div class="row">
  <div class="column">
    <div class="card">
    <img src="../asset/images/aastha.jpg" alt="Avatar" style="width:100%">
      <h3>Aastha Shrivastava</h3>
      <p>Drupal Frontend Intern</p>
    </div>
  </div>
  <div class="column">
    <div class="card">
    <img src="../asset/images/pragati.jpeg" alt="Avatar" style="width:100%">
      <h3>Pragati Kanade</h3>
      <p>Drupal Frontend Intern</p>
    </div>
  </div> 
  </div>
  
  <div class="row">
  <div class="column">
    <div class="card">
    <img src="../asset/images/a.jpg" alt="Avatar" style="width:100%">
      <h3>Anjali Rathod</h3>
      <p>Drupal Frontend Intern</p>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
    <img src="../asset/images/alphonse.jpg" alt="Avatar" style="width:100%">
      <h3>Alphons Jaimon</h3>
      <p>Drupal Frontend Intern</p>
    </div>
  </div>
</div>
</div>

    <!-- Include scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>