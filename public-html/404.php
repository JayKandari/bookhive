<?php
http_response_code(404);
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use template\Page;

$new = new Page;
$new->pageNotFound();
