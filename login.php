<?php

define('ADMIN_LOGIN', 'admin');
define('ADMIN_PASS', 'admin');

require_once __DIR__ . '/includes/classes/User.php';

$loggingUser = User::getUser();
$error = null;

if (isset($_POST['login']))
    $loggingUser->login = $_POST['login'];

if (isset($_POST['pass'])) {
    $loggingUser->setPassword($_POST['pass']);
}


if (!$loggingUser->login || !$loggingUser->pass) {
    $error = 'Please enter login and password';
} else {
    $loggingUser->login($loggingUser->login);
    if ($loggingUser->logged) {
        $_SESSION['user'] = $loggingUser->login;
        $_SESSION['permissions'] = $loggingUser->permissions;

        header("Location: index.php");
    } else {
        $error = 'Invalid login or password';
    }
}

include 'includes/header-simple.php';
?>
<div class="login-form">
    <h2>Welcome</h2>

    <p class="has-warning"><?php if ($error) {
            echo $error;
        } ?><br/>

    <form method="post" action="">
        <input id="login" name="login" value="" placeholder="Enter your login"/><br>
        <input id="pass" name="pass" type="password" value="" placeholder="Enter your password"/><br>
        <input class="submit-btn" type="submit" name="send" value="LOGIN"/>
    </form>

</div>

<?php include 'includes/footer-simple.php'; ?>
