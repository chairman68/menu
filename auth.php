<?php
session_start();
include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db= new orange\db_Restart ($config,0);


		$tsql= "SELECT 	[Name]
	            FROM [dbo].[tb_User]
	            WHERE [dbo].[tb_User].[ObjID] = '".$_POST["userID"]."'
	            AND [dbo].[tb_User].[Password]='".$_POST["password"]."'
	           ";
$user=$db->query($tsql);

if (count($user)==1) {
	$db->close_connection();
	$_SESSION["userid"]=$_POST["userID"];
	$_SESSION["username"]=$user[1]["Name"];
	header('HTTP/1.1 200 OK');
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/main.php');
	exit();

} else {
	$db->close_connection();
	header('HTTP/1.1 200 OK');
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/exit_session.php');
	exit();

}

?>
