<?php

namespace db;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use Config\ProjectConfig;
use PDO_CONN\Connection;
// TODO edit() add()
// use PDO;

class book
{
   public $pdo;
   public $ob;
   public function __construct()
   {
      $conn = new Connection;
      $this->pdo = $conn->connObj;
      $this->ob = new ProjectConfig;
   }
   public function disp_book($recent)
   {
      if ($recent == 'no') {
         $stmt2 = $this->pdo->query('SELECT * FROM Book order by added_on desc');
      } else {
         $stmt2 = $this->pdo->query('SELECT * FROM Book order by added_on desc limit 4');
      }
      $op = array();
      while ($row = $stmt2->fetch(  )) {
         array_push($op, array('id' => $row['id'], 'title' => $row['title'], 'path' => $row['ipath'], 'author' => $row['author'], 'added_on' => $row['added_on'], 'category' => $row['category'], 'available' => $row['available']));
      }
      return $op;
   }
   public function search($name)
   {
      $stmt2 = $this->pdo->query('SELECT * FROM Book where title LIKE "%' . $name . '%"');
      $op = array();
      $row = 0;
      if ($stmt2->fetch(  )) {
         while ($row = $stmt2->fetch(  )) {
            array_push($op[$row], (array('id' => $row['id'], 'title' => $row['title'], 'path' => $row['path'], 'author' => $row['author'], 'added_on' => $row['added_on'])));
            $row = $row + 1;
         }
      } else {
         echo "Sorry ! No books found!";
      }
      return $op;
   }
   public function edit()
   {
      $stmt2 = $this->pdo->query('SELECT * FROM Book');
      while ($row = $stmt2->fetch(  )) {
         echo '<form method="post">';
         echo "<tr>";
         echo '<td><input type="number" name="id" value="' . $row['id'] . '" readonly></input></td>';
         echo '<td><input type="text" name="title" value="' . $row['title'] . '"></input></td>';
         echo '<td><input type="text" name="author" value="' . $row['author'] . '"></input></td>';
         echo '<td><input type="text" name="category" value="' . $row['category'] . '"></input></td>';
         echo '<td><input type="date" name="added_on" value="' . $row['added_on'] . '"></input></td>';
         echo '<td><input type="number" name="qty" value="' . $row['qty'] . '"></input></td>';
         echo '<td><input type="number" name="available" value="' . $row['available'] . '"></input></td>';
         echo '<td><input type="text" name="ipath" value="' . $row['ipath'] . '"></input></td>';
         echo '<td><button name="update_button" class="iconbtnedit"><i class="fas fa-edit"></i></button></td>';
         echo '<td><button name="delete_button" class="iconbtndelete"><i class="fas fa-trash"></i></button></td>';
         echo "</tr>";
         echo '</form>';
      }
      if (isset($_POST["update_button"])) {
         $sql = 'UPDATE Book SET title=?,author=?,category=?,added_on=?,qty=?,available=?,ipath=? where id=?';
         $stmt = $this->pdo->prepare($sql);
         if ($stmt->execute([$_POST["title"], $_POST["author"], $_POST["category"], $_POST["added_on"], $_POST["qty"], $_POST["available"], $_POST["ipath"], $_POST["id"]]) === TRUE) {
            header("LOCATION: listbookedit.php");
         } else {
            echo "<p id='e'>Information edit unsuccessful. Try Again !<p>";
         }
      }
      if (isset($_POST["delete_button"])) {
         $stmt2 = $this->pdo->query('DELETE FROM Book where id=' . $_POST["id"]);
         header("LOCATION: admindash.php");
      }
   }
   public function add()
   {
      echo '<div class="container">
            <div class="header">
               <h1>Add Book</h1>
            </div>
            <div class="main">
               <form action="" method="POST" enctype="multipart/form-data">
                  <span>
                        <input type="text" placeholder="Book Name" name="title" required>
                  </span><br>
                  <span>
                        <input type="text" placeholder="Book Department" name="category" required>
                  </span><br>
                  <span>
                        <input type="text" placeholder="Book Author" name="author" required>
                  </span><br>
                  <span>
                        <input type="text" placeholder="Book Year" name="added_on" required>
                  </span><br>
                  <span>
                        <input type="text" placeholder="Book Quantity" name="qty" required>
                  </span><br>
                  <span>
                        <input type="file" placeholder="Book Coverphoto" name="bcover" required>
                  </span><br>
                  <button name="submit">Add Book</button>
   
               </form>
            </div>
          </div>';
      if (isset($_POST["submit"])) {
         $dest_path = $this->ob->config["paths"]["images"] . "/" . $_FILES['bcover']['name'];
         $sql = 'INSERT into Book (title,author,category,added_on,qty,available,ipath) values ("' . $_POST["title"] . '","' . $_POST["author"] . '","' . $_POST["category"] . '","' . $_POST["added_on"] . '","' . $_POST["qty"] . '","' . $_POST["qty"] . '","' . $dest_path . '")';
         if (move_uploaded_file($_FILES['bcover']['tmp_name'], $this->ob->config["paths"]["images"] . "/")) {
            if ($this->pdo->query($sql) === FALSE) {
               echo "<br >Error <br>";
            } else {
               echo "<p>New book added successfully.!<p>";
            }
         }
      }
   }
   public function issue($bid, $id)
   {
      $sql1 = "SELECT available FROM Book WHERE Book.id='" . $bid . "'";
      $stmt1 = $this->pdo->query($sql1);
      $row1 = $stmt1->fetch(  );
      if ((int)$row1["available"] > 0) {
         $q = ((int)$row1["available"]) - 1;
         $sql = 'UPDATE Book SET available=? where Book.id=?';
         $stmt = $this->pdo->prepare($sql);
         if ($stmt->execute([$q, $bid]) === TRUE) {
            echo "here";
            $sql2 = 'INSERT into book_user (bid,id,issued_on) values ("' . $bid . '","' . $id . '","' . date('y-m-d') . '")';
            if ($this->pdo->query($sql2) === TRUE) {
               // header("LOCATION: userdash.php");
               echo "Issued";
            }
         }
      } else {
         echo "Sorry the book isn't available";
      }
   }
   public function book_info($id)
   {
      $stmt2 = $this->pdo->query('SELECT * FROM book_user where id="' . $id . '"');
      echo "<table><th>Book Title</th><th>Issued On</th><th>Status</th>";
      while ($row2 = $stmt2->fetch(  )) {
         if ((date("d") - (int)substr($row2["issued_on"], 8)) > 7) {
            $s = "Returned";
         } else {
            $s = "Issued";
         }
         $stmt1 = $this->pdo->query('SELECT title FROM Book where Book.id="' . $row2["bid"] . '"');

         while ($row1 = $stmt1->fetch(  )) {
            echo '<tr>';
            echo '<td>' . $row1["title"] . '</td>';
            echo '<td>' . $row2["issued_on"] . '</td>';
            echo '<td>' . $s . '</td>';
            echo '</tr>';
         }
      }
      echo "</table>";
   }
}
