<?php 
  session_start();

  include "../resources/src/books.php";
    use db\book as book;
  if ($_SESSION["admin"]=="admin")
  {
?>
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
    $k=new book();
    $k->edit();
  ?>
  </table>

</body>
</html>
  <?php }
  else{
    header("LOCATION: userdash.php");
  } ?>