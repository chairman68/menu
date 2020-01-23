<?php
// Параметры - дата начальная дата data-beg & конечная дата data_end
// Принимаем дату в качестве параметра
if (isset($_GET['date_beg']) ) {
    $date_beg = $_GET['date_beg'];
} else {
    $date_beg = date("Ymd")." ";
}
if (isset($_GET['date_end']) ) {
    $date_end = $_GET['date_end'];
} else {
    if (isset($_GET['date_beg']) ) {
        $date_end = $date_beg;
    } else {
    $date_end = date("Ymd")." ";
    }
}

//-----------------------------------

// Форматирование вывода ошибок SQL сервера
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
//------------------------------------


// Функция исполнения запроса в базе РестАрт. Возвращает массив строк результата.
function queryRestArt ($tsql){
    
    //Параметры подключения к БД
    $serverName = "CASH\RESTART";
    $connectionOptions = array(
        "Database" => "CAFE",
        "Uid" => "sa",
        "PWD" => "rarus12",
        "CharacterSet" => "UTF-8"
    );
    //Подключение к БД
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if(!$conn){
        echo "Нет подключения к серверу БД!";
    }
    
    $getResults= sqlsrv_query($conn, $tsql);

    if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
    $i=1;
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $out[$i]=$row;
        $i++;
    }

    sqlsrv_free_stmt($getResults);

    return $out;
}
//------------------------------------

$tsql= "SELECT 
	  
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[DateAdd],
			  [dbo].[tb_Order].[Num],
			  [dbo].[tb_User].[Name]
			FROM [dbo].[tb_Order], [dbo].[tb_User]
			WHERE [dbo].[tb_Order].[DateRsrv] between '".$date_beg." 00:00:00.000' AND '".$date_end." 23:59:59.999'
			AND [dbo].[tb_Order].[UserAddID]=[dbo].[tb_User].[ObjID]";

$Ord=queryRestArt($tsql);
$i=1;
foreach ($Ord as $value){
        $tsql= "SELECT 
				  item.[ProdID],
                  item.[ParentID],
                  item.[Count],
				  item.[Status],
				  menu.[Name],
				  prod.[Output],
				  prod.[Unit]
				FROM  [dbo].[tb_Order], [dbo].[tb_OrdItem] item
				LEFT OUTER JOIN [dbo].[tb_Product] prod ON prod.[ObjID]=item.[ProdID]
				LEFT OUTER JOIN [dbo].[tb_MenuItem] menu 
				ON (prod.[ObjID]=menu.[ProdID] AND menu.[LinkID]=item.[MenuID])
				WHERE item.[LinkID]=[dbo].[tb_Order].[ObjID]
				AND [dbo].[tb_Order].[Num]=".$value["Num"]."
				AND prod.[Type]=3
				ORDER BY item.[MenuID], menu.[Pos]";
        $Ord[$i]["Items"]=queryRestArt($tsql);
        $i++;   
}

//var_dump ($Ord);
// Выдаем JSON ответ 
$json_data= json_encode($Ord);

header("Content-type: application/json; charset=utf-8");
echo $_GET['callback'] . ' (' . $json_data . ');';