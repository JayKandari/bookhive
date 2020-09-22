<?php
namespace Session;
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Redirect\Redirect;
class SessionCookie
{
    public $redirect = '';
    public function __construct()
    {
        $this->redirect = new Redirect;
        session_start();
        if (isset($_SESSION['lastact']) and time() - $_SESSION['lastact'] > 9000) {
            $this->sessionClear();
            $this->redirect->phploc('index.php');
        } else $_SESSION['lastact'] = time();
        if (isset($_SESSION['uid'])) {
            // $requests = exequery('select type from users where username = ?', 's', $_SESSION['uid']);
            $requests = '';
            $row = mysqli_fetch_array($requests);
            if ($row[0] == 'admin') $_SESSION['admin'] = $_SESSION['uid'];
        }
    }
    public function rememberMe()
    {
        $keygen = bin2hex(random_bytes(mt_rand(5, 10))) . $_SESSION['uid'] . bin2hex(random_bytes(mt_rand(1, 5)));
        $key = password_hash($keygen, PASSWORD_ARGON2ID);
        setcookie('remembering', $key, time() + 31556926);
        // exequery('update users set log=? where username=?', "ss", $keygen, $_SESSION['uid']);
        unset($keygen);
    }
    public function sessionClear()
    {
        session_unset();
        session_destroy();
        setcookie("remembering", "", time() - 31556926);
        unset($_COOKIE['remembering']);
        session_start();
    }
    public function sessionCheck()
    {
        if (!isset($_SESSION['uid'])) $this->redirect->phploc('index.php');
    }
}
