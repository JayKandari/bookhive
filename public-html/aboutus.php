<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
use src\SessionCookie;
$session = new SessionCookie;
$session->includeAccess();
?>
<html>
<title>About us</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="card">
        <img src="../asset/images/aastha.jpg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Aastha Shrivastava</b></h4>
            <p>Drupal Frontend Intern</p>
        </div>
    </div>
    <div class="card">
        <img src="../asset/images/pragati.jpeg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Pragati Kanade</b></h4>
            <p>Drupal Frontend Intern</p>
        </div>
    </div>

    <div class="card">
        <img src="../asset/images/a.jpg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Anjali Rathod</b></h4>
            <p>Drupal Frontend Intern</p>
        </div>
    </div>
    <div class="card">
        <img src="../asset/images/alphonse.jpg" alt="Avatar" style="width:100%">
        <div class="container">
            <h4><b>Alphons Jaimon</b></h4>
            <p>Drupal Frontend Intern</p>
        </div>
    </div>

</body>

</html>