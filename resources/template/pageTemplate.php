<?php

namespace template;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\ProjectConfig;
use src\SessionCookie;
use template\Menu;
/*
 * echo/print $head to print the head which contains the imp css, title.
 * $menu->render_headNav() can be be called to print/render a whole menu.
 * If you have a page with just pure html then you can store the html code in a 
 * variable and pass it to constructPage which would build the whole page with 
 * head, menu, content and foot.
 * echo/print $foot to print the jquery and javascript part of the page
 */

class Page
{
    public $config;
    public $session;
    public $head;
    public $menu;
    public $content;
    public $foot;
    public function __construct()
    {
        $this->config = new ProjectConfig;
        $this->session = new SessionCookie;
        $title = $this->config->pageDict[basename($_SERVER['PHP_SELF'], '.php')];

        $this->head = "
        <!DOCTYPE html>
        <html lang='en'>
        <meta name='Description' content='Bookhive - A Digital Library Management System'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>" . $title . "</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
        <link rel='stylesheet' href='" . $this->config->config["paths"]["css"] . "/main.css'>
        </head>
        <body>
        ";
        $this->constructMenu();
        $this->foot = "
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js' charset='utf-8'></script>
        <script src='" . $this->config->config["paths"]["js"] . "/main.js'></script>
        </body>
        </html>
        ";
    }
    public function constructMenu()
    {
        if ($this->session->loginAccess()) {
            $this->menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
        } else {
            $this->menu = new Menu(basename(__FILE__));
        }
    }
    public function constructPage($content)
    {
        echo $this->head;
        $this->menu->render_headNav();
        echo $content;
        echo $this->foot;
    }
}
