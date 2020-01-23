<?php
session_start();
session_destroy();
header('HTTP/1.1 200 OK');
header('Location: http://'.$_SERVER['HTTP_HOST'].'/login.php');
exit();
?>