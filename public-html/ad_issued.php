<!DOCTYPE html>
<html>
  <title>Edit Book</title>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>
<?php include 'admindash.php'; ?>

<body>
<?php 
    include "../resources/src/books.php";
    use db\book as book; 
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        $k = new book;
        $row = $k->book_info($_SESSION["uno"]);
    ?>

</body>
</html>
 