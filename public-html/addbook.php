<?php session_start();
include "../resources/src/books.php";
use db\book as book;
if(isset($_SESSION["logged_in"]))
{
	if ($_SESSION["admin"]=="user")
	{
		header("LOCATION: userdash.php");
	}
}
?>
<html>

<head>
    <title>BookADD</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
</head>
<?php include 'admindash.php'; ?>

<body>
<?php $k = new book;
    $row = $k->add();
?>
</body>

</html>