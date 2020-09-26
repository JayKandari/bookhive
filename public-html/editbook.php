<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\SessionCookie;
use template\Menu;

$session = new SessionCookie;
$session->adminCheck();

$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);

?>
<html>

<head>
    <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
    <div class="container">
        <?php
        $menu->render_header();
        $menu->render_menu();
        ?>
        <div class="header">
            <h1>Edit Book</h1>

        </div>
        <div class="main">
            <form action="" method="POST">
                <span>
                    <input type="text" placeholder="Book Name" name="ebname">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Department" name="ebdept">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Author" name="ebauthor">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Year" name="ebyear">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Quantity" name="ebquantity">
                </span><br>
                <span>
                    <input type="file" placeholder="Book Coverphoto" name="ebcover">
                </span><br>
                <button name="submit">Update</button>

            </form>
        </div>
    </div>
    <!-- Include scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>