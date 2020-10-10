<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use template\Menu;
use src\ProjectConfig;
use src\SessionCookie;
use src\book;
use template\Page;

$page = new Page;
$session = new SessionCookie;
$conf = new ProjectConfig();

$session->admincheck();

echo $page->head;
$page->menu->render_headNav();

echo '
      <div class="main_content">
            <div class="container">
                  <div class="header">
                  <h1> All Books Issued</h1>
</div> </div>';

$k = new book;
$row = $k->book_info($_SESSION["uno"], "ad");
echo '</div>';
echo $page->foot;
