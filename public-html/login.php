<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use db\user;

if (isset($_SESSION["logged_in"])) {
	if ($_SESSION["admin"] == "admin") {
		header("LOCATION: admindash.php");
	} else {
		header("LOCATION: userdash.php");
	}
}

?>
<html>

<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
</head>

<body>
	<?php include 'homepage.php'; ?>

	<div class="container">
		<div class="header">
			<h1>login Here</h1>
		</div>
		<div class="main">
			<form action="" method="POST">
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
				<span>
					<i class="fa fa-user"></i>
					<input type="text" placeholder="Email" name="email" required>
				</span><br>
				<span>
					<i class="fa fa-lock"></i>
					<input type="password" placeholder="password" name="upass" required>
				</span><br>
				<button name="login_btn">login</button>

			</form>
			<?php
			if (isset($_POST["login_btn"])) {
				ini_set("display_errors", 1);
				error_reporting(E_ALL);
				$k = new user();
				$row = $k->login($_POST['email'], $_POST['upass']);
				var_dump($row);
				if ($row === false) {
					$_SESSION["error"] = "Incorrect password.";
					header("LOCATION: login.php");
				} else {
					$_SESSION["uname"] = $row['uname'];
					$_SESSION["email"] = $_POST['email'];
					$_SESSION["admin"] = $k->admin($_SESSION["email"]);
					$_SESSION["uno"] = $k->uno($_SESSION["email"]);
					$_SESSION["success"] = "Login success";
					$_SESSION["logged_in"] = "pass";
					if (!empty($_POST['remember'])) {
						setcookie("email", $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
					}
					if ($_SESSION["admin"] == "admin") {
						header("LOCATION: admindash.php");
					} else {
						header("LOCATION: userdash.php");
					}
				}
			}
			?>
		</div>
	</div>
</body>

</html>