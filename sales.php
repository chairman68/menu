<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 18.10.14
 * Time: 7:44
 * Календарь банкетов
 */
?>
<?php
// Функция вытаскивания даты и времени из строковой Time Stamp
function explodeTimeStamp ($str){
    list ($datetime["date"],$datetime["time"] ) = sscanf($str,"%s %s");
    return $datetime;
}

// Создание SOAP-клиента по WSDL-документу
$client = new SoapClient("http://192.168.1.55:29121/wsdl/IRestWebServ", array('exceptions' => 0));

// Поcылка SOAP-запроса и получение результата

$request = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food">
	<Unloads>
		<Object name="Check" cond="((KKMID='{5FDF7207-0C89-4F0B-BDCD-2AE4FAD84DA5}') OR (KKMID='{CFE53949-774C-4037-9B6B-532836EF5C4C}')) AND (Date >= '2016-03-03 10:00:00.000') AND (Date <= '2016-03-03 11:00:00.000') " />
	</Unloads>
</Request>
XML;
?>
<?
$resultSOAP = $client->ExecRequest($request);
$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);
$checkSXML = simplexml_load_string($resultSOAP);
print_r($checkSXML);

/*
$url="88.86.82.7";

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

$weekdayfirst=(int)date(w,mktime(0,0,0,$calendar_month,1,$calendar_year));
if ($weekdayfirst==0) {
    $weekdayfirst=7;
}


for ($i=0;$i<42;$i++) {
    if($i==0){
        $cell[0]["day"]=(int)date(t,mktime(0,0,0,$calendar_month-1,1,$calendar_year))-$weekdayfirst+2;
        $cell[0]["month"]=$calendar_month-1;
        $cell[0]["year"]=$calendar_year;
    } else {
        $cell[$i]["day"] = $cell[$i - 1]["day"] + 1;
        $cell[$i]["month"] = $cell[$i - 1]["month"];
        $cell[$i]["year"] = $cell[$i - 1]["year"];
        $cell[$i]["seats"] = "";
        $cell[$i]["time"] = "";
    }

    // Переход на следующий месяц
    if ($cell[$i]["day"]>(int)date(t,mktime(0,0,0,$cell[$i]["month"]))) {
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

    // Если дата ячейки меньше текущей, то статус - 0
    if (mktime(23,59,0,$cell[$i]["month"],$cell[$i]["day"],$cell[$i]["year"])<=time() or $cell[$i]["month"]<> $calendar_month) {
        $cell[$i]["status"]=0;
    }else {
        $cell[$i]["status"] = 1;


        foreach ($Response->Unloads->Object as $Object) {

            if ((string)$Object["name"] == "Order") {
                $OrderProperties = $Object->Properties;
                $datetime = explodeTimeStamp($OrderProperties["DateRsrv"]);
                //print_r($datetime);
                // Проверяем есть ли  бронь
                if ($cell[$i]["month"] < 10) $string_month = '0' . (string)$cell[$i]["month"]; else $string_month = (string)$cell[$i]["month"];
                if ($cell[$i]["day"] < 10) $string_day = '0' . (string)$cell[$i]["day"]; else $string_day = (string)$cell[$i]["day"];

                $string_cell_date = (string)$cell[$i]["year"] . "." . $string_month . "." . $string_day;

                if ($datetime["date"] == $string_cell_date) {
                    $cell[$i]["seats"] = $OrderProperties["Seats"];// Указываем количесево гостей
                    $cell[$i]["order"] = $OrderProperties["Num"];// Указываем количесево гостей

                    $cell[$i]["time"] = strtok($datetime["time"], ":") . ":" . strtok(":");
                    // Бронь есть, проверяем наличия заказа
                    $cell[$i]["status"] = 2;
                    foreach ($Object->Link->Item as $OrdItem) {
                        $cell[$i]["status"] = 3;
                    }
                }


            }

        }
    }
}
if ($calendar_month==12) {
    $nextmonth=1;
    $nextyear=$calendar_year+1;
} else {
    $nextmonth=$calendar_month+1;
    $nextyear=$calendar_year;
}

if ($calendar_month==1) {
    $previousmonth=12;
    $previousyear=$calendar_year-1;
} else {
    $previousmonth=$calendar_month-1;
    $previousyear=$calendar_year;
}


?>
<!-- Выдаем HTML страницу -->

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/calendar.css" type="text/css" />
    <!--
    <meta http-equiv="Refresh" content="300" />
    -->
    <title>Календарь банкетов</title>
</head>

<body>

<div class="main">
   <div style="position: absolute;
                left: 310px;
                top:50px;
                width: 500px;
                height: 100px;
                color: grey;
                text-align:center;
                font-size: 32pt;">
       <?=$mounth[$calendar_month]?> </br> <?=$calendar_year?>
   </div>

    <div style="position: absolute;  left: 210px; top:200px; width: 714px; height: 50px; ">
        <div class="calheader">ПН</div>
        <div class="calheader">ВТ</div>
        <div class="calheader">СР</div>
        <div class="calheader">ЧТ</div>
        <div class="calheader">ПТ</div>
        <div class="calheader">СБ</div>
        <div class="calheader">ВС</div>

    </div>

   <div style=" position:absolute;
                width: 150px;
                height: 150px;
                left: 25px;
                top: 25px;
                background-image: url(Images/logo.png);">

   </div>
   <div style=" position:absolute;
                width: 100px;
                height: 100px;
                right: 100px;
                top: 50px;
                border: solid grey 1px;
                border-radius:10px;
                background-image: url('Images/row_right.png');
                cursor: pointer;"
       onclick="location.href='http://<?=$url?>/calendar.php?month=<?=$nextmonth?>&year=<?=$nextyear?>'">
   </div>
   <div style=" position:absolute;
                width: 100px;
                height: 100px;
                left: 210px;
                top: 50px;
                border: solid grey 1px;
                border-radius:5px;
                background-image: url('Images/row_left.png');
                cursor: pointer;"
         onclick="location.href='http://<?=$url?>/calendar.php?month=<?=$previousmonth?>&year=<?=$previousyear?>'">

   </div>


    <div class="cal">





        <?
        for ($i=0;$i<=41;$i++) {

            // Красный цвет рамки для сегодняшней даты
            if($cell[$i]["day"]==(int)date("d") and $cell[$i]["month"]==(int)date("m") and $cell[$i]["year"]==(int)date("Y")) {
                $cell[$i]["border_color"] = "#FF4500";
            } else $cell[$i]["border_color"]="#aeaeb0";

            switch ($cell[$i]["status"]) {
                case "1":
                    $background = "#ffffff";
                    $styledate="position: absolute; //Вывод Даты
                                        font-size:24pt;
                                        color:#707071;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";
                    $style_reserved="   position: absolute; // Индикатор занято
                                        width: 90px;
                                        height: 30px;
                                        background-color: #ffffff;
                                        padding: 5px;";
                    $iconmenu="";
                    $click_to_order='';
                    $cursor="";
                    break;
                case "2":
                    $background = "#ffffff";

                    $styledate="        position: absolute; //Вывод Даты
                                        font-size:24pt;
                                        color:yellow;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";

                    $style_reserved="   position: absolute; // Индикатор занято
                                        width: 90px;
                                        height: 30px;
                                        background-color: #FF4500;
                                        padding: 5px;";
                    $iconmenu="";
                    $click_to_order='onclick="location.href='."'http://".$url."/order.php?order=".$cell[$i]["order"]."'".';"';
                    $cursor="cursor: pointer;";
                    break;
                case "3":
                    $background = "#ffffff";
                    $styledate="position: absolute; //Вывод Даты
                                        font-size:24pt;
                                        color:yellow;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";

                    $style_reserved="   position: absolute; // Индикатор занято
                                        width: 90px;
                                        height: 30px;
                                        background-color: #FF4500;
                                        padding: 5px;";

                    $iconmenu='<img src="images/iconmenu.png">';
                    $click_to_order='onclick="location.href='."'http://".$url."/order.php?order=".$cell[$i]["order"]."'".';"';
                    $cursor="cursor: pointer;";
                    break;

                default:
                    $background = "#d6d6d8";
                    $styledate="position: absolute; //Вывод Даты
                                        font-size:24pt;
                                        color:#C2C2C2;
                                        width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;";

                    $style_reserved="   position: absolute; //Индикатор занято
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
                                style= " width: 100px; // Ячейка календаря
                                '.$cursor.'
                                height: 100px;
                                background: '.$background.';
                                border: solid 1px;
                                border-color: '.$cell[$i]["border_color"].';
                                padding: 0px;
                                float:left;">


                <div style="'.$style_reserved.'">

                            <div style="position: absolute; //Вывод времени начала банкета
                                        line-height: 40px;
                                        color: #ffffff"> '.$cell[$i]["time"].'
                            </div>

                            <div style="'.$styledate.'"> '.$cell[$i]["day"].'
                            </div>
                </div>

                <div style="position:absolute;">
                    <div style="position:absolute; // Ячейка иконка меню
                            width:50px;
                            height:60px;
                            top:40px;">
                            '.$iconmenu.'
                    </div>

                    <div style="position:absolute; //Ячейка число гостей
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
</html> */ ?>