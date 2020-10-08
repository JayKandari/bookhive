<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\user;
use src\SessionCookie;
use template\Menu;

$session = new SessionCookie;
$session->adminCheck();

$menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
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
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
  <?php
  $menu->render_header();
  $menu->render_menu();
  ?>
  <div class="main_content">
    <div class="header">
      <h1><?php echo $mode == 'edit' ? 'Edit User' : 'Users' ?></h1>
    </div>
    <div class="main">

      <?php
      if (isset($_SESSION["error"])) {
        echo ('<p id="e">' . $_SESSION["error"] . "</p>\n");
        unset($_SESSION["error"]);
      }
      if (isset($_SESSION["success"])) {
        echo ('<p id="g">' . $_SESSION["success"] . "</p>\n");
        unset($_SESSION["success"]);
      }
      $k = new user;
      $users = $k->getAllUsers();
      ?>
      <div <?php echo $mode == "edit" ? ("class='hidden'") : " "; ?>>
        <table>
          <thead>
            <tr>
              <th>User Numner</th>
              <th>User Name</th>
              <th>Email</th>
              <th>Type</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($users as $row) {
            ?>
              <tr>
                <td data-label="User ID"><?php echo $row['id']; ?> </td>
                <td data-label="Name"><?php echo $row['uname']; ?></td>
                <td data-label="Email"><?php echo $row['email']; ?></td>
                <td data-label="Role"><?php echo $row['type']; ?></td>
                <td data-label="Update"> <a href="edituserlist.php?idu=<?php echo $row['id']; ?>"><button name="update_button"> Edit </button></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div <?php echo $mode == "list" ? ("class='hidden'") : " "; ?>>

        <form method="post">
          <span>
            <label for="uname">Name</label>
            <input type="text" name="uname" value="<?php echo $name; ?>"></input>
          </span><br>

          <span>
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="Password"></input>
          </span><br>

          <span>
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo $email; ?>"></input>
          </span><br>

          <span>
            <label for="admin">Admin</label>
            <input type="radio" name="admin" value="admin" <?php echo $role == "admin" ? "checked" : " " ?>>YES </input>
            <input type="radio" name="admin" value="user" <?php echo $role == "admin" ? " " : "checked" ?>> NO</input>
          </span><br>

          <button name="submit"> Update Information</button>
          <button name="delete_button" class="icon-btn-delete"><i class="fas fa-trash"></i></button>
        </form>
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
  ?>
  <!-- Include scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
  <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>

</body>

</html>