<?php
$config = array(
    'site-name' => 'Book Hive',
    'db' => array(
        'dbname' => '',
        'username' => '',
        'password' => '',
        'host' => 'localhost' 
    ),
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