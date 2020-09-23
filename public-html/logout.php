<?php
  session_start();
  session_unset(); 
  session_destroy();
  setcookie ("uid", $_POST['uid'], time()- (10 * 365 * 24 * 60 * 60));
  header("LOCATION: homepage.php");

