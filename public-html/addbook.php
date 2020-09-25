<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\book;
use src\SessionCookie;

$session = new SessionCookie;
$session->adminCheck();

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