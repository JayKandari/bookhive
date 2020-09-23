<?php
namespace Config;
class ProjectConfig
{
    public $config;
    public function __construct()
    {
        $creds = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/dbcreds.json'), true);
        $this->config = array(
                'site-name' => 'Book Hive',
                'db' => array(
                'type' => $creds["type"],
                'dbname' => $creds["dbname"],
                'username' => $creds["username"],
                'password' => $creds["pass"],
                'host' => $creds["host"] . ":" . $creds["port"]
                ),
                //URL of the site you can add URLs for Log, Error etc.
                'urls' => array(
                    'baseUrl' => $creds['baseurl'] //cange according to your configuration
                ),
                // Paths of all the required folders
                'paths' => array(
                    "resources" => "/resources",
                    "images" =>  "/asset/images",
                    "css" =>  "/asset/css",
                    "js" => "/asset/js"
                )
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
