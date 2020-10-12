<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\user;
use src\SessionCookie;
use template\Menu;
use template\Page;

$session = new SessionCookie;
$session->adminCheck();

$k = new user;
$mode = "list";
if (isset($_GET["idu"])) {
    $mode = "edit";
    $uid = (int)$_GET["idu"];
    $user_details = $k->searchById($uid);
    if ($user_details) {
        // If user_id is supplied through URL populate the form
        $name = $user_details['uname'];
        $role = $user_details['type'];
        $email = $user_details['email'];
    } else {
        $_SESSION["error"] = "No users found";
    }
}
$page = new Page;

echo $page->head;
$page->menu->render_headNav();
?>
<div class="main_content">
    <div class="header">
        <h1><?php echo $mode == 'edit' ? 'Edit User' : 'Users' ?></h1>
    </div>
    <div class="main">
    <?php
            if (isset($_SESSION["error"])) { ?>
                <div class="alert alert-<?= $_SESSION['errormesgtype'] ?>">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION["error"]); ?>
                </div>
            <?php
            }
            if (isset($_SESSION["success"])) { ?>
                <div class="alert alert-<?= $_SESSION['successmesgtype'] ?>">
                    <?php echo $_SESSION['success'];
                    unset($_SESSION["success"]); ?>
                </div>
            <?php
            }
        $k = new user;
        $users = $k->getAllUsers();
        ?>
        <div <?php echo $mode == "edit" ? ("class='hidden'") : " "; ?>>
            <?php
            echo '<div class="row">';
            foreach ($users as $row) {
                echo '
                    <div class="card main" >
                    <div class="container">
                    <p><b>ID:</b>  ' . $row['id'] . '</p>
                    <p><b>Name:</b>  ' . $row['uname'] . '</p>
                    <p><b>Email</b>  :' . $row['email'] . '</p>
                    <p><b>Role:</b>  ' . $row['type'] . '</p>
                    <p> <a href="edituserlist.php?idu=' . $row["id"] . '"><button name="update_button"> Edit </button></a> <p>
                    </div>
                    </div>
                    ';
            }
            echo '</div>';
            echo '</div>';
            ?>
        </div>
        <div <?php echo $mode == "list" ? ("class='hidden'") : " "; ?>>
            <div class="row">
                <div class="card main">
                    <div class="container">
                        <form method="post">
                            <p>
                                <span>
                                    <label for="uname">Name</label>
                                    <input type="text" name="uname" value="<?php echo $name; ?>"></input>
                                </span><br>
                            </p>
                            <p>
                                <span>
                                    <label for="pass">Password</label>
                                    <input type="password" name="pass" placeholder="Password"></input>
                                </span><br>
                            </p>
                            <p>
                                <span>
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="<?php echo $email; ?>"></input>
                                </span><br>
                            </p>
                            <p>
                                <span>
                                    <label for="admin">Admin</label>
                                    <input type="radio" name="admin" value="admin" <?php echo $role == "admin" ? "checked" : " " ?>>YES </input>
                                    <input type="radio" name="admin" value="user" <?php echo $role == "admin" ? " " : "checked" ?>> NO</input>
                                </span><br>
                            </p>
                            <p>
                                <button name="submit"> Update Information</button>
                            </p>
                            <p>
                                <button name="delete_button" class="icon-btn-delete"><i class="fas fa-trash"></i></button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST["submit"])) {
            $row = array(
                "uno" => $uid,
                "uname" => $_POST["uname"],
                "email" => $_POST["email"],
                "pass" => $_POST["pass"],
                "admin" => $_POST["admin"],
            );
            $k->edit($row);
        }
        if (isset($_POST["delete_button"])) {
            $k->delete($uid);
        }
        echo $page->foot;
