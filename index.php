<?php
ob_start();

session_start();

if(!(@$_SESSION['clientId'])) {
 /* Redirect to login page */
 $host  = $_SERVER['HTTP_HOST'];
 $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
 $login = 'login.php';
 header("Location: $login");
 exit;
}


include 'includes/layout.php';







$content = ob_get_contents();
$length = strlen($content);
header('Content-Length: '.$length);

echo $content;
?>