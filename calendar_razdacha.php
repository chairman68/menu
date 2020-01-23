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
// Выбрать заказы со статусом БРОНЬ в зале Банкеты
		$tsql= "SELECT 
			  [dbo].[tb_Order].[ObjID],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[Seats],
			  [dbo].[tb_Order].[Num]
			FROM [dbo].[tb_Order],[dbo].[tb_Object]
			WHERE [dbo].[tb_Order].[Status] = 4
			AND	[dbo].[tb_Order].[ObjectID]=[dbo].[tb_Object].[ObjID]
			AND [dbo].[tb_Object].[AreaID]='165f4c97-8f41-11e3-93ef-00155d012805'
			ORDER BY [dbo].[tb_Order].[Num]";
        

$data=array();
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

$weekdayfirst=(int)date('w',mktime(0,0,0,$calendar_month,1,$calendar_year));
if ($weekdayfirst==0) {
    $weekdayfirst=7;
}

for ($i=0;$i<42;$i++) {
    if($i==0){
        $cell[0]["day"]=(int)date('t',mktime(0,0,0,$calendar_month-1,1,$calendar_year))-$weekdayfirst+2;
        $cell[0]["month"]=$calendar_month-1;
        $cell[0]["year"]=$calendar_year;
		$cell[$i]["seats"] = "";
        $cell[$i]["time"] = "";
    } else {
        $cell[$i]["day"] = $cell[$i - 1]["day"] + 1;
        $cell[$i]["month"] = $cell[$i - 1]["month"];
        $cell[$i]["year"] = $cell[$i - 1]["year"];
        $cell[$i]["seats"] = "";
        $cell[$i]["time"] = "";
    }
    // Переход на следующий месяц
    if ($cell[$i]["day"]>(int)date('t',mktime(0,0,0,$cell[$i]["month"],1,$cell[$i]["year"]))) {
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
					if ($OrdItem<>null) {
						if($OrdItem[1])$cell[$i]["status"] = 3;	
					}
             	}
        } 
	
	}
}
    $next_year=$calendar_year+1;
    $previous_year=$calendar_year-1;


?>

<?php // Выдаем HTML страницу ?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/calendar.css" type="text/css" />
    
    <title>Календарь банкетов</title>
</head>

<body>
<div class="navi" onClick="history.back()"
     style="
                background-image: url('Images/x.png');
				background-size: contain;
                top: 10px;">

</div>
<div class="main">
 	
   <div id = "nav_panel">
   			<div>
                    <div class ="button"
                            style=" background-image: url('Images/row_left.png');"
                           onclick="location.search='month=<?=$calendar_month?>&year=<?=$previous_year?>'">
                   </div>
                   <div id="m_yyyy">	
   		
       						<?php//=$mounth[$calendar_month]?> <?=$calendar_year?> год
  				 	</div>
                   <div class ="button"
                            style=" background-image: url('Images/row_right.png');
                            float:right;"
                           onclick="location.search='month=<?=$calendar_month?>&year=<?=$next_year?>'">
                   </div>
                   <div style="clear:both;"></div>
           </div>
           <div class ="button"
           			onclick="location.search='month=1&year=<?=$calendar_year?>'"
                    <?php if ($calendar_month==1) echo 'style = "background-color: #ffffff; color:red;"'; ?> >
                   ЯНВ
           </div>
           <div class ="button"
                   onclick="location.search='month=2&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==2) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   ФЕВ
           </div>
           <div class ="button"
                   onclick="location.search='month=3&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==3) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   МАР
           </div>
           <div class ="button"
                   onclick="location.search='month=4&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==4) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   АПР
           </div>
           <div class ="button"
                   onclick="location.search='month=5&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==5) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   МАЙ
           </div>
           <div class ="button"
                   onclick="location.search='month=6&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==6) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   ИЮН
           </div>
           <div class ="button"
                   onclick="location.search='month=7&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==7) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   ИЮЛ
           </div>
           <div class ="button"
                   onclick="location.search='month=8&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==8) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   АВГ
           </div>
           <div class ="button"
                   onclick="location.search='month=9&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==9) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   СЕН
           </div>
           <div class ="button"
                   onclick="location.search='month=10&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==10) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   ОКТ
           </div>
           <div class ="button"
                   onclick="location.search='month=11&year=<?=$calendar_year?>'"
				   <?php if ($calendar_month==11) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   НОЯ
           </div>
           <div class ="button"
                   onclick="location.search='month=12&year=<?=$calendar_year?>'"
                   <?php if ($calendar_month==12) echo 'style = "background-color: #ffffff;color:red;"'; ?> >
                   ДЕК
           </div>   
   			 <div style="clear:both;"></div>
   </div>
   
  

    
  
  


    <div class="cal">

<div style="width: 714px; height: 50px; ">
        <div class="calheader">ПН</div>
        <div class="calheader">ВТ</div>
        <div class="calheader">СР</div>
        <div class="calheader">ЧТ</div>
        <div class="calheader">ПТ</div>
        <div class="calheader">СБ</div>
        <div class="calheader">ВС</div>

    </div>




        <?php
        for ($i=0;$i<=41;$i++) {
		
            // Красный цвет рамки для сегодняшней даты
            if($cell[$i]["day"]==(int)date("d") and $cell[$i]["month"]==(int)date("m") and $cell[$i]["year"]==(int)date("Y")) {
                $cell[$i]["border_color"] = "#FF4500";
            } else $cell[$i]["border_color"]="#aeaeb0";
			
            switch ($cell[$i]["status"]) {
               
			  		    
				case 1:
                    $background = "#ffffff";
                    $styledate="position: absolute; /*Вывод Даты*/
                                        font-size:24pt;
                                        color:#707071;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";
                    $style_reserved="   position: absolute; /* Индикатор занято */
                                        width: 90px;
                                        height: 30px;
                                        background-color: #ffffff;
                                        padding: 5px;";
                    $iconmenu="";
                    $click_to_order='';
                    $cursor="";
                    break;
                case 2:
                    $background = "#ffffff";

                    $styledate="        position: absolute; /*Вывод Даты*/
                                        font-size:24pt;
                                        color:yellow;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";

                    $style_reserved="   position: absolute; /* Индикатор занято */
                                        width: 90px;
                                        height: 30px;
                                        background-color: #FF4500;
                                        padding: 5px;";
                    $iconmenu="";
					
                    $click_to_order='onclick="location.href=location.protocol+\'//\'+location.host+\'/pre_orders.php?DateRsrv='.$cell[$i]["DateRsrv"].'\'"';
					
                    $cursor="cursor: 	pointer;";
					break;
                case 3:
                    $background = "#ffffff";
                    $styledate="position: absolute; /*Вывод Даты*/
                                        font-size:24pt;
                                        color:yellow;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";

                    $style_reserved="   position: absolute; /* Индикатор занято */
                                        width: 90px;
                                        height: 30px;
                                        background-color: #FF4500;
                                        padding: 5px;";

                    $iconmenu='<img src="images/iconmenu.png">';
                    $click_to_order='onclick="location.href=location.protocol+\'//\'+location.host+\'/pre_orders_razdacha.php?DateRsrv='.$cell[$i]["DateRsrv"].'\'"';
                    $cursor="cursor: pointer;";
                    break;

                default:
                    $background = "#d6d6d8";
                    $styledate="position: absolute; /*Вывод Даты*/
                                        font-size:24pt;
                                        color:#C2C2C2;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";

                    $style_reserved="   position: absolute; /* Индикатор занято */
                                        width: 90px;
                                        height: 30px;
                                        background-color: #d6d6d8;
                                        padding: 5px;";

                    $iconmenu='';
                    $click_to_order='';
                    $cursor="";
                    break;

            }

            // Блок ячейки календаря

            echo '<div '.$click_to_order.'
                                style= " width: 100px; /* Ячейка календаря */
                                '.$cursor.'
                                height: 100px;
                                background: '.$background.';
                                border: solid 1px;
                                border-color: '.$cell[$i]["border_color"].';
                                padding: 0px;
                                float:left;">


                <div style="'.$style_reserved.'">

                            <div style="position: absolute; /*Вывод времени начала банкета*/
                                        line-height: 40px;
                                        color: #ffffff"> '.$cell[$i]["time"].'
                            </div>

                            <div style="'.$styledate.'"> '.$cell[$i]["day"].'
                            </div>
                </div>

                <div style="position:absolute;">
                    <div style="position:absolute; /* Ячейка иконка меню */
                            width:50px;
                            height:60px;
                            top:40px;">
                            '.$iconmenu.'
                    </div>

                    <div style="position:absolute; /* Ячейка число гостей */
                            width:45px;
                            height:60px;
                            left:50px;
                            top:40px;
                            text-align:right;
                            color:red;
                            font-size:24pt;">
                            '.$cell[$i]["seats"].'

                    </div>
                </div>
            </div>';
		}
  

        ?>
    </div>
</div>

</body>
</html>