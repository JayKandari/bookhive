<?php

namespace src;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\Redirect;
use src\Connection;
use src\ProjectConfig;

class SessionCookie
{
    public $redirect;
    public $dbConn;
    public function __construct()
    {
        $this->redirect = new Redirect;
        $conf = new ProjectConfig;
        $conf->enableError();
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['lastact']) and time() - $_SESSION['lastact'] > 9000) {
            $this->sessionClear();
            $this->redirect->phploc('index.php');
        } else $_SESSION['lastact'] = time();
        if (isset($_SESSION['uid'])) {
            $this->dbConn = new Connection;
            $row = $this->dbConn->exeQuery('select type from user where uname = ?', $_SESSION['uid']);
            if ($row[0]['type'] == 'admin') $_SESSION['admin'] = "admin";
        }
    }
    /*
    * Function to enable remember me functionality
    */
    public function rememberMe()
    {
        $keygen = bin2hex(random_bytes(mt_rand(5, 10))) . $_SESSION['uid'] . bin2hex(random_bytes(mt_rand(1, 5)));
        $key = password_hash($keygen, PASSWORD_ARGON2ID);
        setcookie('remembering', $key, time() + 31556926);
        $this->dbConn->exeQuery('update user set remember=? where uname=?', $keygen, $_SESSION['uid']);
        unset($keygen);
    }
    /*
    * Function to clear session
    */
    public function sessionClear()
    {
        session_unset();
        session_destroy();
        setcookie("remembering", "", time() - 31556926);
        setcookie("uid", "", time() - 31556926);
        unset($_COOKIE['remembering']);
        session_start();
    }
    /*
    * All the function from here are for checking sessions
    */
    public function sessionCheck()
    {
        if (!isset($_SESSION['uid'])) $this->redirect->phploc('index.php');
    }
    public function loginAccess()
    {
        if (isset($_SESSION["logged_in"])) return true;
        else return false;
    }
    // Functions not being used as of now
    public function adminCheck()
    {
        if ($_SESSION["admin"] == "user") {
            $this->redirect->phploc("userdash.php");
        }
    }
    public function userCheck()
    {
        if ($_SESSION["admin"] == "admin") {
            $this->redirect->phploc("admindash.php");
        }
    }
    public function headAccess()
    {
        if (isset($_SESSION["logged_in"])) {
            if ($_SESSION["admin"] == "admin") {
                $this->redirect->phploc('admindash.php');
            } else {
                $this->redirect->phploc('userdash.php');
            }
        } else {
            $this->redirect->phploc('index.php');
        }
    }

    public function login_check()
    {
        if (isset($_SESSION["logged_in"])) {
            $this->redirect->phploc('admindash.php');
        }
    }
}
