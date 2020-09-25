<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use Session\SessionCookie;
use Redirect\Redirect;

$session = new SessionCookie;
$redirect = new Redirect;
$session->sessionClear();
$redirect->phploc("homepage.php");
