<?php 
session_start();
include "../resources/src/user.php";
use db\user as user;
if (isset($_SESSION['uid']))
{
	if ($_SESSION["admin"] == "admin")
	{
		header("LOCATION: admindash.php");
	}
	else
	{
		header("LOCATION: userdash.php");
	}
}
else
{
?>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/css/login.css">
</head>
<?php include 'homepage.php'; ?>

<body>
 <div class="container">
 	<div class="header">
 		<h1>Register Here</h1>
 	</div>
 	<div class="main">
 		<form action="" method="POST">
 			<span>
 				<i class="fa fa-user"></i>
 				<input type="text" placeholder="Username" name="rname" required>
			 </span><br>
 				<i class="fa fa-at"></i>
 				<input type="email" placeholder="Email Address" name="remail" required>
 			</span><br>
 			<span>
 				<i class="fa fa-lock"></i>
 				<input type="password" placeholder="password" name="rpass" required>
			 </span><br>
			 <span>
			 <i class="fas fa-key"></i>
             <input type="password" placeholder="Confirm password" name="rcpass" >
 			</span><br>
 				<button name="sign_up">Register</button>

 		</form>
		 <?php 
		if (isset($_POST["sign_up"]))
		{
			$k=new user();
			$k->sign_up($_POST["rname"],$_POST["remail"],$_POST["rpass"],"0");
		}
		?>
 	</div>
 </div>
</body>
</html>
	<?php } ?>