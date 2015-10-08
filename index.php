<?php
ob_start();
session_start();

define('ADMIN_LOGIN', 'admin');
define('ADMIN_PASS', '12345');

if ($_SESSION['user_login'] != ADMIN_LOGIN && $_SESSION['user_pass'] != ADMIN_PASS) {
 header("Location: login.php");
 exit;
}



include 'includes/layout.php';




$content = ob_get_contents();
$length = strlen($content);
header('Content-Length: '.$length);
echo $content;
?>