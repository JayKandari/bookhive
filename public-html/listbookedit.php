<!DOCTYPE html>
<html>
<title>Edit Book</title>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>
<?php include 'admindash.php'; ?>

<body>
  <table>
    <tr>
      <th>Book ID</th>
      <th>Book Title</th>
      <th>Author </th>
      <th>Category</th>
      <th>Added On</th>
      <th>Quantity</th>
      <th>Availability</th>
      <th>Path</th>
      <th colspan="2">Operations</th>
    </tr>
    <?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

    use db\book;

    $k = new book;
    $k->edit();
    ?>
  </table>

</body>

</html>