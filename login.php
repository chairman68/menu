
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/login.css" rel="stylesheet">
    <title>Вход в систему</title>        
</head>
<body>
<?php

	include ("lib/db_Restart.php");

	$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

	$db= new orange\db_Restart ($config,0);


			$tsql= "SELECT 	[ObjID],[Name]  
		            FROM [dbo].[tb_User]
		            WHERE [dbo].[tb_User].[IsGroup] = 0 AND [dbo].[tb_User].[ObjActive]=1
		            ORDER BY [dbo].[tb_User].[Name]";

	$users = $db->query($tsql);

	$db->close_connection();

	
	echo '<div id="wrapper">
			<form id="login-form" action="auth.php" method="POST">
				<select id="user-id" name="userID">';
		  
	foreach ($users as $user) {
		echo '<option value="'.$user["ObjID"].'">'.$user["Name"].'</option>';
	}

	echo	'</select>';
	if (isset($_GET["error"])){
		if ($_GET["error"]==1) echo "<label>Неправильный пароль, попробуйте еще раз</label>";
	}
	echo '
		<input id="password" name="password" type="password">
		<button class="button" name="submit" type="submit">Войти</button>
		</form>
		</div>
		</body>
		</html>';

?>
