<?php
class security 
{
	// Проверка на права доступа к странице
	function testUser() 
	{
		if(!isset($_SESSION['userid']) or !isset($_COOKIE['PHPSESSID']))    {
			header('HTTP/1.1 200 OK');
			header('Location: http://'.$_SERVER['HTTP_HOST'].'/exit_session.php');
			exit();
		}
	}
}
?>