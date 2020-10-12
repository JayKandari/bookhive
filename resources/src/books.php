<?php

namespace src;

require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\ProjectConfig;
use src\Connection;
use src\SessionCookie;
use src\Redirect;

use PDO;
/*
 * All the function related to book management reside here.
 */

class book
{
   public $pdo;
   public $ob;
   public $conn;
   public $session;
   public function __construct()
   {
      $this->conn = new Connection;
      $this->pdo = $this->conn->connObj;
      $this->ob = new ProjectConfig;
      $this->session = new SessionCookie;
      $this->redr = new Redirect;
   }
   /*
    * Function to display recent books
    */
   public function disp_book($recent)
   {
      if ($recent == 'no') {
         $stmt2 = $this->pdo->query('SELECT * FROM Book order by added_on desc');
      } else {
         $stmt2 = $this->pdo->query('SELECT * FROM Book order by added_on desc limit 4');
      }
      $op = array();
      while ($row = $stmt2->fetch()) {
         array_push($op, array('id' => $row['id'], 'title' => $row['title'], 'path' => $row['ipath'], 'author' => $row['author'], 'added_on' => $row['added_on'], 'category' => $row['category'], 'available' => $row['available']));
      }
      return $op;
   }

   /**
    * Search book using id
    * @param int `$bid`
    * The `id` of book to be searched
    * @return array `$book` 
    * which contains details of book.
    * OR @return bool false
    * In case of failure.
    */
   public function searchById(int $bid)
   {
      $stmt = $this->pdo->query('SELECT * FROM Book where id = ' . $bid . ' LIMIT 1');
      $book = $stmt->fetch();
      return $book;
   }
   /**
    * Search book using its `title`,`author` or `category`.
    * @param array $values
    * Associative array containing values for `title`,`author` and `category`
    * @return `$book` 
    * which contains details of book.
    * OR @return bool false
    * In case of failure.
    */
   public function search($values)
   {
      $query = "SELECT * from Book WHERE title like ?";

      $paramArr = array('%' . $values["title"] . '%'); // Parameters for prepare statement      
      if ($values["author"] != "") {
         $query = $query . " AND author like ?";
         array_push($paramArr, "%" . $values["author"] . "%");
      }
      if ($values["category"] != "") {
         $query = $query . " AND category like ?";
         array_push($paramArr, "%" . $values["category"] . "%");
      }

      $book = $this->conn->exeQuery($query, $paramArr);
      if ($book) {
         return $book;
      }
      return false;
   }

   /** 
    * Updates book details in `book` table, and sets `$_SESSION["success"]` on successful execution 
    * else sets `$_SESSION["error"]` if some error is encountered.
    * @param array $book_details  
    * Associative array which contains details of book to be added in this order:
    *  ["title", "author","category","added_on", "qty","available","bcover"]
    * @return void 
    */
   public function edit($book_details)
   {

      $filename = $book_details['cover_name'];
      // If book cover image is updated
      if (isset($book_details['bcover'])) {
         $filepath = $_SERVER['DOCUMENT_logo.pngROOT'] . $this->ob->config["paths"]["images"] . "/";
         move_uploaded_file($book_details['bcover']['tmp_name'],  $filepath . basename($book_details['bcover']['name']));
         unlink($filepath . basename($book_details['cover_name'])); //Remove old file
         $filename = $book_details['bcover']['name'];
      }

      // Prepare query to update
      $sql = 'UPDATE Book SET title=?,author=?,category=?,added_on=?,qty=?,available=?,ipath=? where id=?';
      $stmt = $this->pdo->prepare($sql);
      $valArr = [$book_details["title"], $book_details["author"], $book_details["category"], $book_details["added_on"], $book_details["qty"], $book_details["available"], $filename, $book_details["id"]];

      // Set status message for success/failure
      if ($stmt->execute($valArr) === TRUE) {
         $_SESSION["success"] = "Details updated successfully!";
      } else {
         $_SESSION["error"] = "Information edit unsuccessful. Try Again!";
      }
      $this->redr->jsloc("addbook.php");
   }

   /**
    * Deletes record of book from table and corresponding image in files.
    * Sets `$_SESSION["success"]`/`$_SESSION["error"]` for successful deletion /failure respectively.
    * @param int `$bid`
    * ID of the book to be deleted
    * @return void
    */
   public function delete($bid)
   {
      $book_details = $this->searchById($bid);
      if ($book_details == false) {
         $_SESSION["error"] = "No matching books found";
      } else {
         // Delete cover image from files
         $filepath = $_SERVER['DOCUMENT_logo.pngROOT'] . $this->ob->config["paths"]["images"] . "/";
         unlink($filepath . basename($book_details['ipath']));
         // Delete record of book from the table.
         if ($this->pdo->query('DELETE FROM Book where id=' . $bid)) {
            $_SESSION["success"] = "Deleted successfully!";
         } else {
            $_SESSION["error"] = "Deletion unsuccessful. Try Again!";
         }
         $this->redr->jsloc("addbook.php");
      }
   }


   /** 
    * Inserts book details in `book` table, and sets `$_SESSION["success"]` on successful execution 
    * else sets `$_SESSION["error"]` if some error is encountered.
    * @param array $book_details  
    * Associative array which contains details of book to be added in this order:
    *  ["title", "author","category","added_on", "qty","available","bcover"]
    * @return void 
    */
   public function add($book_details)
   {
      $filepath = $_SERVER['DOCUMENT_ROOT'] . $this->ob->config["paths"]["images"] . "/" . basename($book_details['bcover']['name']);
      $valArr = [$book_details["title"], $book_details["author"], $book_details["category"], $book_details["added_on"], $book_details["qty"], $book_details["available"], $book_details['bcover']['name']];
      $this->conn->exeQuery("insert into Book (title, author, category, added_on, qty, available, ipath) values (?,?,?,?,?,?,?)", $valArr);

      if (move_uploaded_file($book_details['bcover']['tmp_name'],  $filepath)) {
         $_SESSION["success"] = "New book added successfully.!";
      } else {
         $_SESSION["error"] = "New book not added successfully.!";
      }
      $this->redr->jsloc("addbook.php");
   }




   /*
    * Function to issue books
    */
   public function issue($bid, $id)
   {
      $stmt2 = $this->pdo->query('SELECT returned FROM book_user where id="' . $id . '" and bid="' . $bid . '"');
      if ($row2 = $stmt2->fetch()) {
         if ($row2["returned"] == "0") {
            echo "Book already issued to you!";
         } else {
            $sql1 = "SELECT available FROM Book WHERE Book.id='" . $bid . "'";
            $stmt1 = $this->pdo->query($sql1);
            $row1 = $stmt1->fetch();
            if ((int)$row1["available"] > 0) {
               $q = ((int)$row1["available"]) - 1;
               $sql = 'UPDATE Book SET available=? where Book.id=?';
               $stmt = $this->pdo->prepare($sql);
               if ($stmt->execute([$q, $bid]) === TRUE) {
                  $sql2 = 'INSERT into book_user (bid,id,issued_on) values ("' . $bid . '","' . $id . '","' . date('y-m-d') . '")';
                  if ($this->pdo->query($sql2) === TRUE) {
                     $_SESSION["success"] = "Issued";
                  }
               }
            } else {
               $_SESSION["error"] = "Sorry the book isn't available";
            }
         }
      } else {
         $sql1 = "SELECT available FROM Book WHERE Book.id='" . $bid . "'";
         $stmt1 = $this->pdo->query($sql1);
         $row1 = $stmt1->fetch();
         if ((int)$row1["available"] > 0) {
            $q = ((int)$row1["available"]) - 1;
            $sql = 'UPDATE Book SET available=? where Book.id=?';
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$q, $bid]) === TRUE) {
               $sql2 = 'INSERT into book_user (bid,id,issued_on) values ("' . $bid . '","' . $id . '","' . date('y-m-d') . '")';
               if ($this->pdo->query($sql2) === TRUE) {
                  $_SESSION["success"] = "Issued";
               }
            }
         } else {
            $_SESSION["error"] = "Sorry the book isn't available";
         }
      }
   }
   /*
    * Function to display book info
    */
   public function book_info($id, $c)
   {
      if ($c == "ad") {
         $stmt2 = $this->pdo->query('SELECT * FROM book_user ');
      } else {
         $stmt2 = $this->pdo->query('SELECT * FROM book_user where id="' . $id . '"');
      }
      echo '<div class="row">';
      while ($row2 = $stmt2->fetch()) {
         $stmt1 = $this->pdo->query('SELECT title FROM Book where Book.id="' . $row2["bid"] . '"');
         while ($row1 = $stmt1->fetch()) {
            echo '
         <div class="card main" >
                    <div class="container">';
            echo '
                    <p><b>Title:</b>  ' . $row1['title'] . '</p>
                    <p><b>Issued On:</b>  ' . $row2["issued_on"] . '</p>
                    ';
            if ($row2["returned"] == "1") {
               echo '<p><b>Status:</b>  Returned</p>';
            } else {
               echo '<p><b>Status:</b>  Issued</p>';
            }
            echo '</div>';
            echo '</div>';
         }
      }
   }
   /*
    * Function to check if a book is issued or not
    */
   public function issue_check()
   {
      $stmt2 = $this->pdo->query('SELECT * FROM book_user');
      while ($row2 = $stmt2->fetch()) {
         if (date('Y-m-d')>$row2["issued_on"]) {
            $sql1 = 'SELECT available FROM Book WHERE Book.id="' . $row2["bid"] . '"';
            $stmt1 = $this->pdo->query($sql1);
            $row1 = $stmt1->fetch();
            $q = ((int)$row1["available"]) + 1;
            $sql = 'UPDATE Book SET available=? where Book.id=?';
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute([$q, $row2["bid"]]) === TRUE) {
               $sql3 = 'UPDATE book_user SET returned=? where bid=? and id=?';
               $stmt3 = $this->pdo->prepare($sql3);
               $stmt3->execute(["1", $row2["bid"], $row2["id"]]);
            }
         }
      }
   }
}
