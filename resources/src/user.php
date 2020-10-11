<?php

namespace src;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\Connection;
use PDO;
use src\Redirect;

class user
{
    public $pdo;
    public function __construct()
    {
        $conn = new Connection;
        $this->pdo = $conn->connObj;
        $this->redr = new Redirect;
    }
    /*LOGIN*/
    function login($email, $upd)
    {
        $sql = "SELECT * FROM user WHERE email = :email and pass = :upd ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(':email' => $email, ':upd' => sha1($upd)));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    /*SIGN-UP*/
    function sign_up($name, $email, $upd, $type)
    {

        $stmt2 = $this->pdo->query('SELECT * FROM user where email="' . $email . '"');
        $hashedpassword = sha1($upd);
        $type = "user";
        if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION["error"] = "Email Id Already Exists!";
            $_SESSION["error_mesgtype"] = "danger";

        } else {
            $sql = 'INSERT INTO user (uname,email,pass,type) VALUES ("' . $name . '", "' . $email . '","' . $hashedpassword . '","' . $type . '")';
            if ($this->pdo->query($sql) === FALSE) {
                $_SESSION["error"] = "error";
                $_SESSION["error_mesgtype"] = "danger";

            } else {
                $_SESSION["success"] = "New account created successfully. Please login !";
                $_SESSION["success_mesgtype"] = "success";

            }
        }
        header("Refresh:0");
    }

    /** 
     * Updates user details in `user` table, and sets `$_SESSION["success"]` on successful execution 
     * else sets `$_SESSION["error"]` if some error is encountered.
     * @param array $values
     * Associative array which contains details of user to be added.
     * @return void 
     */
    public function edit($values)
    {   
    
        if (empty($values["pass"])) {
            $sql = 'UPDATE user SET uname=?,email=?,type=? where id=?';
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$values["uname"], $values["email"], $values["admin"], $values["uno"]]) === TRUE) {
                $_SESSION["success"] = "Details updated successfully!";
                $_SESSION["successmesgtype"] = "success";

            } else {
                $_SESSION["error"] = "Information edit unsuccessful. Try Again!";
                $_SESSION["errormesgtype"] = "danger";


            }
        } else {
            $sql = 'UPDATE user SET uname=?,email=?,pass=?,type=? where id=?';
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$values["uname"], $values["email"], sha1($values["pass"]), $values["admin"], $values["uno"]]) === TRUE) {
                $_SESSION["success"] = "Details updated successfully!";
                $_SESSION["successmesgtype"] = "success";

            } else {
                $_SESSION["error"] = "Information edit unsuccessful. Try Again!";
                $_SESSION["errormesgtype"] = "danger";

            }
        }
        $this->redr->jsloc("edituserlist.php");
    }
    /**
     * Searches for user by ID
     * @param int $uid
     * ID of the user to search
     * @return array/bool $user
     * If search is successful returns an associative array of user details.
     * Returns false in case of any failure.
     */
    public function searchById($uid)
    {
        $stmt2 = $this->pdo->query('SELECT * FROM user where id=' . $uid . ' LIMIT 1');
        $user = $stmt2->fetch();
        return $user;
    }

    /**
     * Returns an associative array having all the records of user table.
     */
    public function getAllUsers()
    {
        $users = array();
        $stmt2 = $this->pdo->query('SELECT * FROM user');
        if ($stmt2) {
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                array_push($users, $row);
            }
            return $users;
        }
        return false;
    }
    /**
     * Deletes record of use from table.
     * Sets `$_SESSION["success"]`/`$_SESSION["error"]` for successful deletion /failure respectively.
     * @param int `$Uid`
     * ID of the User to be deleted
     * @return void
     */
    public function delete($uid)
    {
        // Delete record of user from the table.
        if ($this->pdo->query('DELETE FROM user where id=' . $uid)) {
            $_SESSION["success"] = "Deleted successfully!";
            $_SESSION["successmesgtype"] = "success";

        } else {
            $_SESSION["error"] = "Deletion unsuccessful. Try Again!";
            $_SESSION["errormesgtype"] = "danger";

        }
        $this->redr->jsloc("edituserlist.php");
    }
}
