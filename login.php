<?php
ob_start();


define('ADMIN_LOGIN', 'admin');
define('ADMIN_PASS', '12345');

session_start();

if (isset($_POST['login']) && $_POST['login'])
    $_SESSION['user_login'] = $_POST['login'];
if (@$_POST['pass'])
    $_SESSION['user_pass'] = $_POST['pass'];


//if (@$_SESSION['user_login'] && @$_SESSION['user_pass']) {

if (!@$_SESSION['user_login'] || !@$_SESSION['user_pass']) {
    $error = 'Podaj login i haslo';
}
else {
    if ($_SESSION['user_login'] == ADMIN_LOGIN && $_SESSION['user_pass']== ADMIN_PASS) {
        $error = '';
    }
    else {
        $error = 'Bledny login lub haslo';
    }
}



if ($error) {
    echo '<p style="color:red;">'.$error.'<br/>';
    echo '<form method="post" action="">';
    echo 'login: <input name="login" value="" /><br/>';
    echo 'haslo: <input name="pass" type="password" value="" /><br/>';
    echo '<input type="submit" name="send" value="ZALOGUJ" />';
    echo '</form>';
}