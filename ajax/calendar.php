<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 18.10.14
 * Time: 7:44
 * Календарь банкетов
 */

// Функция вытаскивания даты и времени из строковой Time Stamp
function explodeDateTime ($DT){
    $datetime["date"]= $DT->format("Y.m.d");
	$datetime["time"]= $DT->format("H:i:s.000");
    return $datetime;
}

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
    "Database" => "BANKET",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 
// Выбрать заказы со статусом БРОНЬ в зале Банкеты
		$tsql= "SELECT 
			  [dbo].[tb_Order].[ObjID],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[Seats],
			  [dbo].[tb_Order].[Num]
			FROM [dbo].[tb_Order],[dbo].[tb_Object]
			WHERE [dbo].[tb_Order].[Status] = 4
			AND	[dbo].[tb_Order].[ObjectID]=[dbo].[tb_Object].[ObjID]
			AND [dbo].[tb_Object].[AreaID]='75dd17fe-920f-42e5-8b88-3cfca4a82661'
			ORDER BY [dbo].[tb_Order].[Num]";
        


$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data[$i]=$row;
    $i++;
}

//var_dump($data);

sqlsrv_free_stmt($getResults);




$mounth=array(
    1=>"Январь",
    2=>"Февраль",
    3=>"Март",
    4=>"Апрель",
    5=>"Май",
    6=>"Июнь",
    7=>"Июль",
    8=>"Август",
    9=>"Сентябрь",
    10=>"Октябрь",
    11=>"Ноябрь",
    12=>"Декабрь");

if (isset($_GET['month']) ) {
    $calendar_month = (int)$_GET['month'];
    $calendar_year = (int)$_GET['year'];
} else {
    $calendar_month = (int)date("m");
    $calendar_year = (int)date("Y");
}

// Рассчитываем дату первой ячейки календаря и заполняем даты

$weekdayfirst=(int)date("w",mktime(0,0,0,$calendar_month,1,$calendar_year));
if ($weekdayfirst==0) {
    $weekdayfirst=7;
}

for ($i=0;$i<42;$i++) {
    if($i==0){
        $cell[0]["day"]=(int)date("t",mktime(0,0,0,$calendar_month-1,1,$calendar_year))-$weekdayfirst+2;
        $cell[0]["month"]=$calendar_month-1;
        $cell[0]["year"]=$calendar_year;
		$cell[0]["seats"] = "";
        $cell[0]["time"] = "";
    } else {
        $cell[$i]["day"] = $cell[$i - 1]["day"] + 1;
        $cell[$i]["month"] = $cell[$i - 1]["month"];
        $cell[$i]["year"] = $cell[$i - 1]["year"];
        $cell[$i]["seats"] = "";
        $cell[$i]["time"] = "";
    }
    // Переход на следующий месяц
    if ($cell[$i]["day"]>(int)date("t",mktime(0,0,0,$cell[$i]["month"],1,$cell[$i]["year"]))) {
        $cell[$i]["day"] = 1;
        if($cell[$i]["month"]==12){
            $cell[$i]["month"]=1;
            $cell[$i]["year"]++;
        } else  $cell[$i]["month"]++;
    }
    // Заполняем статусы ячеек
    // 0-недоступно
    // 1-свободно для заказа
    // 2-забронировано без меню
    // 3-забронировано с меню
    // 4- заказ закрыт

    // Если дата ячейки меньше текущей, то статус - 0
    if (mktime(23,59,0,$cell[$i]["month"],$cell[$i]["day"],$cell[$i]["year"])<=time() or $cell[$i]["month"]<> $calendar_month) {
        $cell[$i]["status"]=0;
    // Сюда вставит обработку чеков
	
	
	
	
	} else {
        $cell[$i]["status"] = 1;
		
        foreach ($data as $Order) {

            
                $datetime = explodeDateTime($Order["DateRsrv"]);
			
                // Проверяем есть ли  бронь
                if ($cell[$i]["month"] < 10) $string_month = '0' . (string)$cell[$i]["month"]; else $string_month = (string)$cell[$i]["month"];
                if ($cell[$i]["day"] < 10) $string_day = '0' . (string)$cell[$i]["day"]; else $string_day = (string)$cell[$i]["day"];

                $string_cell_date = (string)$cell[$i]["year"] . "." . $string_month . "." . $string_day;

                if ($datetime["date"] == $string_cell_date) {
					
                    $cell[$i]["seats"] = $cell[$i]["seats"]+$Order["Seats"];// Указываем количесево гостей
                    $cell[$i]["order"] = $Order["Num"];// Указываем количесево гостей
					$cell[$i]["DateRsrv"] = $Order["DateRsrv"]->format("Y.m.d H:i:s.000");
		            
					$cell[$i]["time"] = strtok($datetime["time"], ":") . ":" . strtok(":");
                    // Бронь есть, проверяем наличия заказа
                    
					$cell[$i]["status"] = 2;
                    
					
					$tsql= "SELECT 
						[dbo].[tb_OrdItem].[Count]
						FROM [dbo].[tb_OrdItem]
						WHERE [dbo].[tb_OrdItem].[LinkID]='".$Order["ObjID"]."'";
        
					$getResults= sqlsrv_query($conn, $tsql);
                    
                    if ($getResults == FALSE)
						die(FormatErrors(sqlsrv_errors()));
					$OrdItem=null;
                    $i_2=1;
					while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
						$OrdItem[$i_2]=$row;
                    	$i_2++;
					}
                    
					sqlsrv_free_stmt($getResults);
					
					if ($OrdItem[1]) $cell[$i]["status"] = 3;	
					
             	}
        } 	
	}
}
    $next_year=$calendar_year+1;
    $previous_year=$calendar_year-1;

 // Выдаем JSON ответ 
$json_data= json_encode($cell);
echo $json_data;
//header("Content-type: application/json; charset=utf-8");
//echo $_GET['callback'] . ' (' . $json_data . ');';
?>