<?php
session_start();
include "resources/src/user.php";
use db\user as user;
?>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="login.css">
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
				if(isset($_SESSION["error"]))
				{
					echo('<p id="e">'.$_SESSION["error"]."</p>\n");
					unset($_SESSION["error"]);
				}
				if(isset($_SESSION["success"]))
				{
					echo('<p id="g">'.$_SESSION["success"]."</p>\n");
					unset($_SESSION["success"]);
				}
			?>
 			<span>
 				<i class="fa fa-user"></i>
 				<input type="text" placeholder="Username" name="uname" required>
 			</span><br>
 			<span>
 				<i class="fa fa-lock"></i>
 				<input type="password" placeholder="password" name="upass" required>
 			</span><br>
 				<button name="login_btn">login</button>

 		</form>
		 <?php
		 if (isset($_POST["login_btn"]))
		 {

			 $k=new user();
			$row=$k->login($_POST['uname'],$_POST['upass']);
			var_dump($row);
			if ($row === false)
			{
				$_SESSION["error"]="Incorrect password.";
				header("LOCATION: login.php");
			}
			else
			{
				$_SESSION["uid"]=$_POST['uname'];
				$_SESSION["admin"]=$k->admin($_SESSION["uid"]);
				$_SESSION["success"]="Login success";
				$_SESSION["logged_in"]="pass";
				if (!empty($_POST['remember']))
				{
					setcookie ("uid", $_POST['uid'], time()+ (10 * 365 * 24 * 60 * 60));
					setcookie ("admin", $_POST['admin'], time()+ (10 * 365 * 24 * 60 * 60));
				}
				if ($_SESSION["admin"] == "1")
				{
					header("LOCATION: admindash.php");
				}
				else
				{
					header("LOCATION: userdash.php");
				}

			}
		 } 
		 ?>
 	</div>
 </div>
</body>
</html>