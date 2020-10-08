<?php
require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

use src\SessionCookie;

$session = new SessionCookie;
?>
<html>
<title>Contact us</title>

<head>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

    use template\Menu;

    if (isset($_SESSION["logged_in"])) {
        $menu = new Menu(basename(__FILE__), $_SESSION["admin"], $_SESSION["uname"]);
    } else {
        $menu = new Menu(basename(__FILE__));
    }
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href='<?php echo $menu->paths['css'] . "/main.css"; ?>'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>
<body > 
    <?php
    $menu->render_header();
    $menu->render_menu();
    ?>
    <!-- 
     <div class="main_content">
        <div class="row">
                <div class="card">
                    <img src="../asset/images/qed42.png" alt="Avatar" style="width:100%">

                    <h3>QED42</h3>
                    <p> Nyati Tech Park, 203, 2nd Floor, </br>"B" Wing, Kalyani Nagar - Wadgaon Sheri Rd, Pune, 411014
                    </p>
                    <p>Website:<a href="https://www.qed42.com/" target="_blank">www.qed42.com</a></p>
                    <p>:<a href="https://www.qed42.com/" target="_blank">careers@qed42.com</a><br></p>

                </div>
        </div>
    </div> 
    -->
    <div class="main_content">
        <section class="contactus">
            <div class="contactcontent">
                <h2>Contact Us</h2>
                <p>Let's make something great together! </p>
            </div>
            <div class="contactcontainer">
                <div class="contactinfo">
                    <div class="contactbox">
                        <div class="contacttext">
                            <h3>Address</h3>
                            <p> <i class="fas fa-map-pin"> &nbsp  </i>Nyati Tech Park, 203, 2nd Floor,<br> &nbsp "B" Wing, Kalyani Nagar - Wadgaon Sheri Rd, Pune, 411014</p>
                        </div>
                    </div>
                    <div class="contactbox">
                        <div class="contacttext">
                            <h3>Email</h3>
                            <p><i class="fas fa-at"> &nbsp  </i><a href="mailto:careers@qed42.com">careers@qed42.com</a></p>
                        </div>
                    </div>
                    <div class="contactbox">
                        <div class="contacttext">
                            <h3>Website</h3>
                            <p><a href="www.qed42.com">www.qed42.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="contactform">
                    <form>
                        <h2>Send Message</h2>
                        <div class="contactinputbox">
                            <input type="text" name="fullname" required >
                            <span>Full Name</span>
                        </div>
                        <div class="contactinputbox">
                            <input type="email" name="email" required >
                            <span>Email</span>
                        </div>
                        <div class="contactinputbox">
                            <textarea required ></textarea>
                            <span>Your message</span>
                        </div>
                        <div class="contactinputbox">
                            <button>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src='<?php echo $menu->paths['js'] . "/main.js" ?>'></script>
</body>
</html>