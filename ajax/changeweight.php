<?php
// Скрипт перезаписывает поле Weight в базе Рестарта
// Получает новое значение поля и GUID продукта

function FormatErrors( $errors )
{
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."<br/>";
        echo "Code: ".$error['code']."<br/>";
        echo "Message: ".$error['message']."<br/>";
    }
}
$json=json_decode($_POST);

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

		$tsql= "UPDATE  [dbo].[tb_Product]
				SET
				[dbo].[tb_Product].[Weight]=".$json["weight"]."
				WHERE [dbo].[tb_Product].[ObjID]= ".$json["id"];
			

//print($tsql);
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
echo "Принято";
