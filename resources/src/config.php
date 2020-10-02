<?php

namespace src;

class ProjectConfig
{
    public $config;
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
    }
    /*
    * A debugging function.
    */
    public function dispConfig()
    {
        var_dump($this->config);
    }
    /*
    * Function to disable display of errors
    */
    public function disableError()
    {
        error_reporting(0);
    }
    /*
    * Function to enable display of errors
    */
    public function enableError()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}
