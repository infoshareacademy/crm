<?php
ob_start();



include 'includes/layout.php';







$content = ob_get_contents();
$length = strlen($content);
header('Content-Length: '.$length);

echo $content;
?>