<?php
//  Скрипт возвращает меню в формате JSON
include ("../lib/db_Restart.php");
$config=json_decode(file_get_contents("../json/config.json")); //Получить параметры системы


if (isset($_GET['menu'])) { // Проверяем наличие идентификатора меню

	switch ($_GET['menu']){
		case 1:
		// Меню на раздачу
		$db= new orange\db_Restart ($config,0);
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Image],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '44f21079-2737-4807-8b60-c02f717141e0'
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY ISNULL ([dbo].[tb_MenuItem].[ParentID],[dbo].[tb_MenuItem].[ID]), [dbo].[tb_MenuItem].[IsGroup] DESC, [dbo].[tb_MenuItem].[Pos]";
			$getResults= $db->query($tsql);
			$db->close_connection();
		break;
			case 2:
		// Банкетное меню
			$db= new orange\db_Restart ($config,1);
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Image],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '3d48809f-1fa0-11e9-bba7-00155d012807'
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY ISNULL ([dbo].[tb_MenuItem].[ParentID],[dbo].[tb_MenuItem].[ID]), [dbo].[tb_MenuItem].[IsGroup] DESC, [dbo].[tb_MenuItem].[Pos]";
			$getResults= $db->query($tsql);
			$db->close_connection();
		break;
			
	}
};

$i=1;
while (isset ($getResults[$i])){
    
	$getResults[$i]["obj_comment"]=json_decode($getResults[$i]["Comment"]);
	if (json_last_error()<>JSON_ERROR_NONE) {
		$getResults[$i]["obj_comment"]= new stdClass();
		$getResults[$i]["obj_comment"]->comment=$getResults[$i]["Comment"];
	}
	$i++;
}



 // Выдаем JSON ответ 
$json_data= json_encode($getResults);
header("Content-type: application/json; charset=utf-8");
echo $json_data;

