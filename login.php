<?php
ob_start();
session_start();

define('ADMIN_LOGIN', 'admin');
define('ADMIN_PASS', 'admin');

//include_once 'includes/config/dbconnect.php';
require_once 'includes/class/user.class.php';

$loggingUser = new User();
$error = null;


    if (isset($_POST['login']))
        $loggingUser->login = $_POST['login'];

    if (isset($_POST['pass'])) {
        $loggingUser->setPassword($_POST['pass']);
    }


    if (!$loggingUser -> login || !$loggingUser -> pass) {
        $error = 'Please enter login and password';
    }
    else {
        $loggingUser -> login($loggingUser->login);
        if ($loggingUser -> logged) {
            $_SESSION['user'] = $loggingUser->login;
            $_SESSION['permissions'] = $loggingUser -> permissions;
            $_SESSION['logged'] = $loggingUser->logged;
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
            <p class="has-warning"><?php if ($error) { echo $error; } ?><br/>
            <form method="post" action="">
                <input id="login" name="login" value=""  placeholder="Enter your login"/><br>
                <input id="pass" name="pass" type="password" value="" placeholder="Enter your password"/><br>
                 <input class="submit-btn" type="submit" name="send" value="LOGIN" />
            </form>

</div>

<?php
include 'includes/footer-simple.php'; ?>
