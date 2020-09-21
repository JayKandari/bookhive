<?php
// Getting credentials from json file
$creds = json_decode(file_get_contents("dbcred.json"), true); 

$config = array(
    'site-name' => 'Book Hive',
    'db' => array(
        'type' => $creds["type"],
        'dbname' => $creds["dbname"],
        'username' => $creds["username"],
        'password' => $creds["pass"],
        'host' => $creds["host"].":".$creds["port"]
    ),
    //URL of the site you can add URLs for Log, Error etc.
    'urls' => array(
        'baseUrl' => 'book-hive.local' //cange according to your configuration
    ),
    'paths' => array(
        "resources" => $_SERVER["DOCUMENT_ROOT"]."/resources",
        "images" => $_SERVER["DOCUMENT_ROOT"]."/asset/images",
        "css" => $_SERVER["DOCUMENT_ROOT"]."/asset/css",
        "js" => $_SERVER["DOCUMENT_ROOT"]."/asset/js"
    
        )
 );

    
?>