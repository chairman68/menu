<?php
//  Скрипт возвращает список аудитов в формате JSON
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
    "Database" => "CAFE2019",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 
if (isset($_GET['page'])) { // Проверяем наличие идентификатора страницы
$page=$_GET['page'];
}else{
$page=1;    
}


		$tsql= "SELECT audit.*
                        ,count(auditItem.[ID]) as item
                FROM [CAFE2019].[dbo].[tb_My_Audit] audit
                JOIN [CAFE2019].[dbo].[tb_My_AuditItem] auditItem ON audit.ObjID=auditItem.LinkID
                GROUP BY audit.[ObjID],audit.[Name],audit.[Activ],audit.[Right]";
	






$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data[$i]=$row;
    $i++;
}
sqlsrv_free_stmt($getResults);
 // Выдаем JSON ответ 
$json_data= json_encode($data);
header("Content-type: application/json; charset=utf-8");
echo $_GET['callback'] . ' (' . $json_data . ');';