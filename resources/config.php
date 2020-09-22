<?php

// PHP Error Hide
 error_reporting(0);

// Uncomment below lines to PHP Show Error 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Getting credentials from json file
$creds = json_decode(file_get_contents("dbcred.json"), true);
$config = array(
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
