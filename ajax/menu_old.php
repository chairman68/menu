<?php
//  Скрипт возвращает меню в формате JSON
function FormatErrors( $errors )
{
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."";
        echo "Code: ".$error['code']."";
        echo "Message: ".$error['message']."";
    }
}

$serverName = "CASH\RESTART";
$connectionOptions = array(
    "Database" => "CAFE",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 
if (isset($_GET['menu'])) { // Проверяем наличие идентификатора экрана

	switch ($_GET['menu']){
		case 1:
		// Меню на раздачу
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
		break;
			case 2:
		// Банкетное меню
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
			WHERE [dbo].[tb_MenuItem].[LinkID] = '62d2fe20-bf69-11e5-83ea-00155d012807'
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY ISNULL ([dbo].[tb_MenuItem].[ParentID],[dbo].[tb_MenuItem].[ID]), [dbo].[tb_MenuItem].[IsGroup] DESC, [dbo].[tb_MenuItem].[Pos]";
		break;
			
	}
};

$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data[$i]=$row;
	$data[$i]["obj_comment"]=json_decode($data[$i]["Comment"]);
    $i++;
}
sqlsrv_free_stmt($getResults);
 // Выдаем JSON ответ 
$json_data= json_encode($data);
header("Content-type: application/json; charset=utf-8");
echo $json_data;

