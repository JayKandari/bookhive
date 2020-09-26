<?php

namespace template;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\ProjectConfig;

class Menu
{
    private $role;
    private $uname;
    private $current_file;
    public $paths;

    /*
        * $role could have values: 'anon','user','admin'
        * $file contains name of current file e.g 'index.php'
    */
    public function __construct($file, $role = 'anon', $name = 'Bookhive')
    {
        $this->current_file = $file;
        $this->role = $role;
        $this->uname = $name;
        $conf = new ProjectConfig();
        $this->paths = $conf->config['paths'];
    }
    public function render_header()
    {

        echo " <input type='checkbox' id='check'>
            <!--header area start-->
            <header>
                <label for='check'>
                    <i class='fas fa-bars' id='sidebar_btn'></i>
                </label>
                <div class='left_area'>
                    <h3>Bookhive</h3>
                </div>
            </header>
            <!--header area end-->";
    }
    public function construct_menu()
    {

        // Common links
        $main_menu = array(
            array(
                'link' => 'index.php',
                'ico-class' => 'fas fa-home', 'link-class' => '', 'text' => 'Home'
            ),
            array(
                'link' => 'searchbook.php',
                'ico-class' => 'fas fa-search', 'link-class' => '', 'text' => 'Search Books'
            ),
            array(
                'link' => 'displaynew.php',
                'ico-class' => 'fas fa-book-reader', 'link-class' => '', 'text' => 'Colection'
            )
        );
        // Role based menu items
        switch ($this->role) {
            case 'anon': {
                    array_push(
                        $main_menu,
                        array('link' => 'register.php', 'ico-class' => 'far fa-user-circle', 'link-class' => '', 'text' => 'Sign Up'),
                        array('link' => 'login.php', 'ico-class' => 'fas fa-user-alt', 'link-class' => '', 'text' => 'Sign In')
                    );
                }
                break;
            case 'admin': {
                    array_push(
                        $main_menu,
                        array('link' => 'addbook.php', 'ico-class' => 'fas fa-plus', 'link-class' => '', 'text' => 'Add Book'),
                        array('link' => 'listbookedit.php', 'ico-class' => 'fas fa-edit', 'link-class' => '', 'text' => 'Edit Book info'),
                        array('link' => 'edituserlist.php', 'ico-class' => 'fas fa-user-edit', 'link-class' => '', 'text' => 'Edit User'),
                        array('link' => 'ad_issued.php', 'ico-class' => 'fas fa-shopping-cart', 'link-class' => '', 'text' => 'Book Issued')
                    );
                }
                break;
        }


        array_push(
            $main_menu,
            array('link' => 'aboutus.php', 'ico-class' => 'fas fa-info-circle', 'link-class' => '', 'text' => 'About'),
            array('link' => 'contactus.php', 'ico-class' => 'fas fa-phone-alt', 'link-class' => '', 'text' => 'Contact')
        );
        if ($this->role != 'anon') {
            array_push($main_menu, array('link' => 'logout.php', 'ico-class' => 'fas fa-sign-out-alt', 'link-class' => '', 'text' => 'Sign Out'));
        }

        return $main_menu;
    }
    public function mobile_nav()
    {
        echo "<!--mobile navigation bar start-->
        <div class='mobile_nav'>
            <div class='nav_bar'>
                <i class='fa fa-bars nav_btn'></i>
            </div>
            <div class='mobile_nav_items'>";
        foreach ($this->construct_menu() as $menu) {
            if ($menu['link'] == $this->current_file) {
                $menu['link-class'] = $menu['link-class'] . ' active-menu ';
            }
            echo "<a href='" . $menu['link'] . "' class='" . $menu['link-class'] . "'><i class='" . $menu['ico-class'] . "'></i><span>" . $menu['text'] . "</span></a>";
        }
        echo "</div>
        </div>
        <!--mobile navigation bar end-->";
    }

    public function sidebar()
    {
        echo "<!--sidebar start-->
        <div class='sidebar'>
            <div class='profile_info'>";
        $image = $this->role == 'anon' ? '/booklogo.png' : '/OIP.jpg';
        echo "<img src='" . $this->paths['images'] . $image . "' class='profile_image' alt=''>";
        echo "<h4>" . $this->uname . "</h4>
              </div>";
        foreach ($this->construct_menu() as $menu) {
            if ($menu['link'] == $this->current_file) {
                $menu['link-class'] = $menu['link-class'] . ' active-menu ';
            }
            echo "<a href='" . $menu['link'] . "' class='" . $menu['link-class'] . "'><i class='" . $menu['ico-class'] . "'></i><span>" . $menu['text'] . "</span></a>";
        }
        echo "</div>";
    }

    public function render_menu()
    {
        $this->mobile_nav();
        $this->sidebar();
    }
}
