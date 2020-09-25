<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\user;
use src\book;
use src\SessionCookie;
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
				$session = new SessionCookie;
				$k = new user();
				$row = $k->login($_POST['email'], $_POST['upass']);
				if ($row === false) {
					$_SESSION["error"] = "Incorrect password.";
					header("LOCATION: login.php");
				} else {
					$_SESSION["uname"] = $row['uname'];
					$_SESSION["email"] = $_POST['email'];
					$_SESSION["admin"] = $row["type"];
					$_SESSION["uno"] = $row["id"];
					$ob = new book;
					$ob->issue_check($_SESSION["uno"]);
					$_SESSION["success"] = "Login success";
					$_SESSION["logged_in"] = "pass";
					if (!empty($_POST['remember'])) {
						setcookie("email", $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
					}
					$session->headAccess();
				}
			}
			?>
		</div>
	</div>
</body>

</html>