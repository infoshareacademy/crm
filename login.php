<?php
ob_start();
session_start();

define('ADMIN_LOGIN', 'admin');
define('ADMIN_PASS', 'admin');

    include_once 'includes/config/dbconnect.php';


    if (isset($_POST['login']))
        $_SESSION['user_login'] = $_POST['login'];
    if (isset($_POST['pass']))
        $_SESSION['user_pass'] = $_POST['pass'];

    if (!@$_SESSION['user_login'] || !@$_SESSION['user_pass']) {
        $error = 'Please enter login and password';
    }
    else {
        if ($_SESSION['user_login'] == ADMIN_LOGIN && $_SESSION['user_pass']== ADMIN_PASS) {
            header("Location: index.php");
        }
        else {
            $error = 'Invalid login or password';
        }
    }

include 'includes/header-simple.php';
?>
<div class="login-form">
    <h2>Welcome</h2>
            <p class="error"><?php if ($error) { echo $error; } ?><br/>
            <form method="post" action="">
                <input id="login" name="login" value=""  placeholder="Enter your login"/><br>
                <input id="pass" name="pass" type="password" value="" placeholder="Enter your password"/><br>
                <input class="submit-btn" type="submit" name="send" value="LOGIN" />
            </form>

</div>

<?php
include 'includes/footer-simple.php'; ?>
