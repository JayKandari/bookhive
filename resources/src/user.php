<?php

namespace db;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use PDO_CONN\Connection;
use PDO;

class user
{
    public $pdo;
    public function __construct()
    {
        $conn = new Connection;
        $this->pdo = $conn->connObj;
    }
    /*LOGIN*/
    function login($email, $upd)
    {
        $sql = "SELECT uname FROM user WHERE email = :email and pass = :upd ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(':email' => $email, ':upd' => sha1($upd)));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    /*userno*/
    function uno($email)
    {
        $sql = "SELECT id FROM user WHERE email='" . $email . "'";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["id"];
    }

    /*Admin check*/
    function admin($email)
    {
        $sql = "SELECT type FROM user WHERE email='" . $email . "'";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["type"];
    }

    /*SIGN-UP*/
    function sign_up($name, $email, $upd, $type)
    {

        $stmt2 = $this->pdo->query('SELECT * FROM user where email="' . $email . '"');
        $hashedpassword = sha1($upd);
        $type = "user";
        if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo "<p id='e'><br>Email Id Already Exists!<br><p>";
        } else {
            $sql = 'INSERT INTO user (uname,email,pass,type) VALUES ("' . $name . '", "' . $email . '","' . $hashedpassword . '","' . $type . '")';
            if ($this->pdo->query($sql) === FALSE) {
                echo "<br >Error <br>";
            } else {
                echo "<p id='g'>New account created successfully. Please login !<p>";
            }
        }
    }

    /* edit user info*/
    function user_info()
    {
        $stmt2 = $this->pdo->query('SELECT * FROM user');
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo '<form method="post">';
            echo '<tr>';
            echo '<td><input type="text" name="uno" value="' . $row['id'] . '" readonly></input></td>';
            echo '<td><input type="text" name="uname" value="' . $row['uname'] . '"></input></td>';
            echo '<td><input type="password" name="pass" placeholder="Password"></input></td>';
            echo '<td><input type="text" name="email" value="' . $row['email'] . '"></input></td>';
            echo '<td><input type="text" name="type" value="' . $row['type'] . '" readonly></td>';
            echo '<td><input type="radio" name="admin" value="admin">YES  </input>';
            echo '<input type="radio" name="admin" value="user">  NO</input></td>';
            echo '<td><button name="update_button"> Update Information</button></td>';
            echo "</tr>";
            echo '</form>';
        }
        if (isset($_POST["update_button"])) {
            if (!isset($_POST["admin"])) {
                $_POST["admin"] = $_POST["type"];
            }
            if (empty($_POST["pass"])) {
                $sql = 'UPDATE user SET uname=?,email=?,type=? where id=?';
                $stmt = $this->pdo->prepare($sql);
                if ($stmt->execute([$_POST["uname"], $_POST["email"], $_POST["admin"], $_POST["uno"]]) === TRUE) {
                    echo "Please refresh!";
                    //header("LOCATION: edituserlist.php");
                }
            } else {
                $sql = 'UPDATE user SET uname=?,email=?,pass=?,type=? where id=?';
                $stmt = $this->pdo->prepare($sql);
                if ($stmt->execute([$_POST["uname"], $_POST["email"], sha1($_POST["pass"]), $_POST["admin"], $_POST["uno"]]) === TRUE) {
                    echo "Please refresh!";
                    //header("LOCATION: edituserlist.php");
                }
            }
        }
    }
}
