<?php
//Копирование комментариев из базы в базу
/******* Обработчик ошибок SQL Server*/
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
/******* Обработчик ошибок SQL Server*/

$serverName = "CASH\RESTART";
$connectionOptionsNew = array(
    "Database" => "CAFE2019",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
$connectionOptionsOld = array(
    "Database" => "CAFE",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
//Establishes the connection
$conn1 = sqlsrv_connect($serverName, $connectionOptionsOld);
$conn2 = sqlsrv_connect($serverName, $connectionOptionsNew);
if(!$conn1 or !$conn2){
    echo "Нет подключения к серверу БД!";
} 

		$tsql= "SELECT 
            prod.[ObjID],
            prod.[Comment]
            FROM [dbo].[tb_Product] prod
			WHERE prod.[Comment] <>''
			";
 
//print ($tsql);

$getResults= sqlsrv_query($conn1, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $sqlrec="UPDATE [dbo].[tb_Product]
             SET [dbo].[tb_Product].[Comment]='".$row["Comment"]."'
             WHERE [dbo].[tb_Product].[ObjID]='".$row["ObjID"]."'";
    $queryResult= sqlsrv_query($conn2, $sqlrec);
    
    echo "Изменено ".$i." записей";
    $i++;
}
sqlsrv_free_stmt($getResults);
sqlsrv_free_stmt($queryResults);



?>