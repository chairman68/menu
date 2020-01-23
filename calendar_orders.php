<?php
/**
 * Календарь продаж
 */

include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db = new orange\db_Restart ($config,2);

/*function count_orders_period($date1,$date2){

    $query= "SELECT COUNT(*)
            FROM [dbo].[tb_Order]
            WHERE [dbo].[tb_Order].[DateDel] BETWEEN '". $date1."' and '".$date2."'
            AND Status=2";
    $data = $db->query($query);
    return $data;
}

/*****************  НАЧАЛО ПРОГРАММЫ **********************************/





$tsql='';
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
        } else {
            $cell[$i]["day"] = $cell[$i - 1]["day"] + 1;
            $cell[$i]["month"] = $cell[$i - 1]["month"];
            $cell[$i]["year"] = $cell[$i - 1]["year"];
            
            
        }
        //echo $cell[$i]["month"] , $cell[$i]["year"] ;
        // Переход на следующий месяц
       
        if ($cell[$i]["day"]>cal_days_in_month ( CAL_GREGORIAN , $cell[$i]["month"] , $cell[$i]["year"] )) {
            $cell[$i]["day"] = 1;
            if($cell[$i]["month"]==12){
                $cell[$i]["month"]=1;
                $cell[$i]["year"]++;
            } else  $cell[$i]["month"]++;
        }
    }


    $next_year=$calendar_year+1;
    $previous_year=$calendar_year-1;


?>



<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/calendar.css" type="text/css" />
    
    <title>Календарь продаж</title>
</head>

<body>

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
            if ($cell[$i]["month"]<10) $month="0".$cell[$i]["month"]; else $month=$cell[$i]["month"];
            if ($cell[$i]["day"]<10) $day="0".$cell[$i]["day"]; else $day=$cell[$i]["day"];

            $date1=$cell[$i]["year"].$month.$day.' 00:00:00';
            $date2=$cell[$i]["year"].$month.$day.' 23:59:59';


            $query= "SELECT COUNT(*)
            FROM [dbo].[tb_Order]
            WHERE [dbo].[tb_Order].[DateDel] BETWEEN '". $date1."' and '".$date2."'
            AND Status=2";
            $orders_quantity = $db->query($query);
            
            // Красный цвет рамки для сегодняшней даты
            if($cell[$i]["day"]==(int)date("d") and $cell[$i]["month"]==(int)date("m") and $cell[$i]["year"]==(int)date("Y")) {
                $cell[$i]["border_color"] = "#FF4500";
            } else $cell[$i]["border_color"]="#aeaeb0";

            
            // Блок ячейки календаря

            echo '<div  onclick="location.href=location.protocol+\'//\'+location.host+\'/monitor.php?date='.$cell[$i]["year"].$month.$day.'\'" 
                        style= " width: 100px; /* Ячейка календаря */
                                cursor: pointer;
                                height: 100px;
                                background: white;
                                border: solid 1px;
                                border-color: '.$cell[$i]["border_color"].';
                                padding: 0px;
                                float:left;">


                        <div style="position: absolute; /* Индикатор занято */
                                        width: 90px;
                                        height: 30px;
                                        background-color: white;
                                        padding: 5px;">

                            

                            <div style="position: absolute; /*Вывод Даты*/
                                        font-size:24pt;';
            if($cell[$i]["month"]==$calendar_month) echo 'color:#717171;'; else echo 'color:#cecece;';
                                    echo'width: 35px;
                                        left:60px;
                                        line-height:30px;
                                        text-align: right;"> '.$cell[$i]["day"].'
                            </div>
                                                        
                        <div style="position:absolute; /* число заказов */
                            width:100px;
                            height:40px;
                            left:0px;
                            top:50px;
                            padding-top:10px;
                            text-align:center;
                            background-color: #ededed;
                            color:red;
                            font-size:18pt;">';
                if ($orders_quantity[1][""]<>0) echo $orders_quantity[1][""];
                echo '

                        </div>
                        </div>
               </div>';
        }

$db->close_connection();
?>
    </div>
</div>


</body>
</html>