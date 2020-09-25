<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\SessionCookie;
use src\Redirect;

$session = new SessionCookie;
$redirect = new Redirect;
$session->sessionClear();
$redirect->phploc("homepage.php");
