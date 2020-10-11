<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\user;
use src\SessionCookie;
use template\Menu;

$session = new SessionCookie();
$session->login_check();

$menu = new Menu(basename(__FILE__));

?>
<html>

<head>
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
	<?php
	$menu->render_header();
	$menu->render_menu();
	?>
   <div class="main_content">;
	<div class="container">
		<div class="header">
			<h1>Sign Up</h1>
		</div>
		<div class="main">
			<form action="" method="POST">
			<?php if (isset($_SESSION["success"])) { ?>
					<div class="alert alert-<?= $_SESSION['success_mesgtype'] ?>">
					<?php echo $_SESSION['success'];
					unset($_SESSION["success"]); ?>
					</div>
					<?php
				 } 
				  if (isset($_SESSION["error"])) { ?>
					<div class="alert alert-<?= $_SESSION['error_mesgtype'] ?>">
					<?php echo $_SESSION['error'];
					unset($_SESSION["error"]); ?>
					</div>
					<?php
				 } ?>
				<span>
					<i class="fa fa-user"></i>
					<input type="text" placeholder="Username" name="rname" required>
				</span><br>
				<span>
					<i class="fa fa-at"></i>
					<input type="email" placeholder="Email Address" name="remail" required>
				</span><br>
				<span>
					<i class="fa fa-lock"></i>
					<input type="password" placeholder="password" name="rpass" 
					pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
				</span><br>
				<span>Your password must contain(uppercase,lowercase,number,8 characters)</span><br><br>
				<button name="sign_up">Register</button>
			</form>
			<?php
			if (isset($_POST["sign_up"])) {
				$k = new user();
				$k->sign_up($_POST["rname"], $_POST["remail"], $_POST["rpass"], "0");
			}
			?>
		</div>
	</div>
   </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
	<script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>
</html>