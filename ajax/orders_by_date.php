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
               [dbo].[tb_Print].[ProdID],
               [dbo].[tb_Print].[PrnGrpID],
               [dbo].[tb_PrnGrp].[Name]
               FROM [dbo].[tb_Print],[dbo].[tb_PrnGrp]
               WHERE [dbo].[tb_Print].[PrnGrpID]=[dbo].[tb_PrnGrp].[ObjID]
               AND [dbo].[tb_Print].[PrnGrpID]<>'00000000-0000-0000-0000-000000000000'";

$Prn=queryRestArt($tsql);
    

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
    
    // Определение места печати позиции заказа
    foreach ($Ord[$i]["Items"] as $item) {   
        $tsql1= "SELECT 
                                a.[ObjID] as level0,
                                b.[ObjID] as level1,
                                c.[ObjID] as level2,
                                d.[ObjID] as level3,
                                e.[ObjID] as level4
                                FROM [dbo].[tb_Product] a
                                LEFT JOIN [dbo].[tb_Product] b ON a.[ParentID]=b.[ObjId]
                                LEFT JOIN [dbo].[tb_Product] c ON b.[ParentID]=c.[ObjId]
                                LEFT JOIN [dbo].[tb_Product] d ON c.[ParentID]=d.[ObjId]
                                LEFT JOIN [dbo].[tb_Product] e ON d.[ParentID]=e.[ObjId]
                                WHERE a.[ObjID] ='".$item["ProdID"]."'"; 

                    
                        $itemlevel=queryRestArt($tsql1);
                     
        foreach ($itemlevel as $level){
            foreach ($Prn as $Prn_prod){
                   if ($Prn_prod["ProdID"]==$level){
                       $item["PrepPlace"]=$Prn_prod["Name"];
                       
                        break 2 ;
                   }
            }
        }
    }
//--------Конец Определение места печати позиции заказа---------------------------
        $i++;   
}

//var_dump ($Ord);
// Выдаем JSON ответ 
$json_data= json_encode($Ord);

header("Content-type: application/json; charset=utf-8");
echo $_GET['callback'] . ' (' . $json_data . ');';