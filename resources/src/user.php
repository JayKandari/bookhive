<?php 
namespace db;
use PDO;
class user
{
    public $pdo;
    public $id;
    public function __construct()
    {
        $this->pdo= new PDO('mysql:host=localhost;port=3307;dbname=bookhive', 'anjali', 'ctc');
    }
    /*LOGIN*/
    function login($uname, $upd)
    {
        $sql = "SELECT uname FROM user WHERE uname = :uname and pass = :upd ";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute(array(':uname'=>$uname,':upd'=>sha1($upd)));
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /*Admin check*/
    function admin($id)
    {
        $sql = "SELECT rid FROM user WHERE uname='". $id."'";
        $stmt=$this->pdo->query($sql);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row["rid"];
    }

    /*SIGN-UP*/
    function sign_up($name,$email, $upd,$rid)
    {
        
        $stmt2 = $this->pdo->query('SELECT * FROM user where uname="'. $name.'"');
        $hashedpassword = sha1($upd);
        $rid=0;
        if ($row=$stmt2->fetch(PDO::FETCH_ASSOC))
        {
            echo "<p id='e'><br>User Id Already Exists!<br><p>";
        }
        else
        {
            $sql = 'INSERT INTO user (uname,email,pass,rid) VALUES ("'.$name.'", "'.$email.'","'.$hashedpassword.'","'.$rid.'")';
            if ($this->pdo->query($sql) === FALSE) 
            {
                echo "<br >Error <br>";
            }
            else
            {
                echo "<p id='g'>New account created successfully. Please login !<p>";
            }
        
        }
    }

    /* TODO User and book check*/
}
