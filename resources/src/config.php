<?php

namespace src;

class ProjectConfig
{
    public $config;
    public $pageDict;
    public function __construct()
    {
        $creds = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/../resources/dbcreds.json"), true);
        $this->config = array(
            'site-name' => 'Book Hive',
            'db' => array(
                'type' => $creds["type"],
                'dbname' => $creds["dbname"],
                'username' => $creds["username"],
                'password' => $creds["pass"],
                'host' => $creds["host"],
                'port' => $creds["port"],
            ),
            //URL of the site you can add URLs for Log, Error etc.
            'urls' => array(
                'baseUrl' => $creds['baseurl'] //change according to your configuration
            ),
            // Paths of all the required folders
            'paths' => array(
                "resources" => "/../resources",
                "images" =>  "/asset/images",
                "css" =>  "/asset/css",
                "js" => "/asset/js"
            )
        );
        // a Dictonary of pages to make code/mentioning them more easy!
        $this->pageDict = array(
            "aboutus" => "About Us",
            "ad_issued" => "Edit Book",
            "addbook" => "Add Book",
            "admindash" => "Dashboard",
            "contactus" => "Contact Us",
            "displaynew" => "New Collection",
            "editbook" => "Edit Book",
            "edituserlist" => "Edit User",
            "index" => "Home",
            "listbookedit" => "Edit Book",
            "login" => "Login",
            "logout" => "Logout",
            "register" => "Sign Up",
            "searchbook" => "Search Book",
            "userdash" => "Dashboard",
            "test" => "LAB"
        );
    }
    public function dispConfig()
    {
        var_dump($this->config);
    }
    public function disableError()
    {
        error_reporting(0);
    }
    public function enableError()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
