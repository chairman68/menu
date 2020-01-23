<?php
// Подключение БД
include ("../lib/db_Restart.php");
$config=json_decode(file_get_contents("../json/config.json")); //Получить параметры системы
$db= new orange\db_Restart ($config,0);
var_dump($_ENV);
echo $_SERVER["COMPUTERNAME"].'</br>';
echo $_SERVER["REMOTE_USER"].'</br>';
echo gethostbyaddr ( $_SERVER['REMOTE_ADDR']).'</br>';
if (isset($_POST['submit'])){
	var_dump($_ENV);
}
$json=' [
			{ 
				"num" : 1,
				"date" : "2019-04-23T18:25:43.511Z",
				"nameprod" : "Котлета",
				"kolvo" : 20,
				"test" : 5
			},
			{ 
				"num" : 2,
				"date" : "2019-04-23T18:30:43.511Z",
				"nameprod" : "Макароны",
				"kolvo" : 40,
				"test" : 3
			}
		]
			';
$column_data=json_decode($json);


$db->addRecord("[dbo].[tb_Production]",$column_data[0]);
/*

		$tsql= "SELECT [ObjID]
				      ,[ObjActive]
				      ,[ExtrnCode]
				      ,[ObjTS]
				      ,[ObjCrtnTS]
				      ,[Num]
				      ,[OrderID]
				      ,[Subunit]
				      ,[CookID]
				      ,[ProductID]
				      ,[Count]
				      ,prod.[Name]
				  FROM [CAFE2019].[dbo].[tb_Production] production
				  LEFT JOIN [dbo].[tb_Product] prod ON  production.ProductID=prod.ObjID
				  WHERE production.ObjTS>";

$Item = $db->query($tsql);

$db->close_connection();
*/
$json=' [
			{ 
				"num" : 1,
				"date" : "2019-04-23T18:25:43.511Z",
				"nameprod" : "Котлета",
				"kolvo" : 20,
				"test" : 5
			},
			{ 
				"num" : 2,
				"date" : "2019-04-23T18:30:43.511Z",
				"nameprod" : "Макароны",
				"kolvo" : 40,
				"test" : 3
			}
		]
			';
echo $json;
?>