<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\book;
use src\SessionCookie;
use template\Menu;

$session = new SessionCookie;
$session->adminCheck();
$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
$mode = "add"; // Specifies mode in which form is viewed i.e add/edit
$k = new book;

// Initially set all the input fields empty
$title = $category = $author = $qty = '';

if (isset($_GET["idb"])) {
      $mode = "edit";
      $bid = (int)$_GET["idb"];
      $book_details = $k->searchById($bid);
      if ($book_details) {
            // If book_id is supplied through URL populate the form
            $title = $book_details['title'];
            $category = $book_details['category'];
            $author = $book_details['author'];
            $added_on = $book_details['added_on'];
            $qty = $book_details['qty'];
            $bcover = $book_details['ipath'];
      } else {
            $_SESSION["error"] = "No books found";
      }
}
?>
<html>

<head>
      <title>Book Add/Edit</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
      <?php
      $menu->render_header();
      $menu->render_menu();

      ?>
      <div class="main_content">
            <div class="container">
                  <div class="header">
                        <h1><?php echo $mode == 'edit' ? 'Edit Book' : 'Add Book' ?></h1>
                  </div>
                  <div class="main">
                        <form action="" method="POST" enctype="multipart/form-data">
                              <span>
                                    <?php
                                    if (isset($_SESSION["error"])) {
                                          echo ('<p id="e">' . $_SESSION["error"] . "</p>\n");
                                          unset($_SESSION["error"]);
                                    }
                                    if (isset($_SESSION["success"])) {
                                          echo ('<p id="g">' . $_SESSION["success"] . "</p>\n");
                                          unset($_SESSION["success"]);
                                    }
                                    ?>
                                    <input type="text" placeholder="Book Name" name="title" value="<?php echo $title ?>" required>
                              </span><br>
                              <span>
                                    <input type="text" placeholder="Book Department" name="category" value="<?php echo $category ?>" required>
                              </span><br>
                              <span>
                                    <input type="text" placeholder="Book Author" name="author" value="<?php echo $author ?>" required>
                              </span><br>

                              <?php if ($mode == 'add') { ?>
                                    <span>
                                          <input type="date" placeholder="Book Year" name="added_on" required>
                                    </span><br>
                              <?php      } ?>

                              <span>
                                    <input type="number" placeholder="Book Quantity" name="qty" value="<?php echo $qty ?>" required>
                              </span><br>
                              <span>
                                    <?php if ($mode == 'edit') {
                                          echo '<input type="file" placeholder="Book Coverphoto"  name="bcover">';
                                          echo '<img src="' . $menu->paths['images'] . '/' . $bcover . '" alt="bookcover" width="50px"></span><br>';
                                          echo '<button name="submit">Update Book</button>';
                                          echo '<button name="delete_button" class="icon-btn-delete"><i class="fas fa-trash"></i></button>';
                                    } else {
                                    ?>
                                          <input type="file" placeholder="Book Coverphoto" name="bcover" required>
                              </span><br>
                              <button name="submit">Add Book</button>
                        <?php    }
                        ?>

                        </form>
                  </div>
            </div>

      </div>
      <?php

      if (isset($_POST["submit"])) {
            $row = array(
                  "title" => $_POST["title"],
                  "author" => $_POST["author"],
                  "category" => $_POST["category"],
                  "qty" => $_POST["qty"],
                  "available" => $_POST["qty"],
            );

            if ($mode == "edit") {
                  $row["added_on"] = $added_on;
                  $row["cover_name"] = $bcover; // Name of current cover image
                  $row["id"] = $bid;
                  // If book cover is changed
                  if ($_FILES['bcover']["name"] != '') {
                        $book_details['bcover'] = $_FILES['bcover'];
                        $row["bcover"] = $_FILES['bcover'];
                  }
                  $k->edit($row);
            } else {

                  $row["added_on"] = $_POST["added_on"];
                  $row["bcover"] = $_FILES['bcover'];
                  $k->add($row);
            }
      }
      if (isset($_POST["delete_button"])) {
            $k->delete($bid);
      }
      ?>

      <!-- Include scripts -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
      <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>