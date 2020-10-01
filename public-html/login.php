<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\user;
use src\book;
use src\SessionCookie;
use template\Menu;


$session = new SessionCookie;
$session->login_check();
$menu = new Menu(basename(__FILE__));
?>
<html>

<head>
	<title>login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
	<?php $menu->render_header();
	$menu->render_menu(); ?>

<div class="main_content">
	<div class="container">
		<div class="header">
			<h1>Sign In</h1>
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
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
<script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</html>