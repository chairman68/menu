<?php
$color_fon = '#c6c7f5';
$color_panel='#b7c4f0';
include ("functions.php");
if (isset ($_GET)) {
    $order_choice_visible=-1;} else {$order_choice_visible=10;}
$tsql= "SELECT 
			  [dbo].[tb_Order].[NameRsrv],
              [dbo].[tb_Order].[AvansSum],
			  [dbo].[tb_Order].[InfoRsrv],
			  [dbo].[tb_Order].[Seats],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[DateAdd],
			  [dbo].[tb_Order].[Num],
			  [dbo].[tb_User].[Name],
              [dbo].[tb_Area].[Name] as areaName
			FROM [dbo].[tb_Order], [dbo].[tb_User],[dbo].[tb_Object],[dbo].[tb_Area]
			WHERE [dbo].[tb_Order].[DateRsrv]>= GETDATE()
			AND [dbo].[tb_Order].[ObjectID]=[dbo].[tb_Object].[ObjID]
            AND [dbo].[tb_Object].[AreaID]=[dbo].[tb_Area].[ObjID]
            AND [dbo].[tb_Order].[UserAddID]=[dbo].[tb_User].[ObjID]
            ORDER BY [dbo].[tb_Order].[DateRsrv]";
			
$orders=queryRestArt($tsql);

$tsql= "SELECT 
			  [dbo].[tb_Order].[NameRsrv],
              [dbo].[tb_Order].[AvansSum],
			  [dbo].[tb_Order].[InfoRsrv],
			  [dbo].[tb_Order].[Seats],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[DateAdd],
			  [dbo].[tb_Order].[Num],
			  [dbo].[tb_User].[Name]
			FROM [dbo].[tb_Order], [dbo].[tb_User]
			WHERE [dbo].[tb_Order].[Num]= ".$_GET["order"]."
			AND [dbo].[tb_Order].[UserAddID]=[dbo].[tb_User].[ObjID]";
			
$order=queryRestArt($tsql);
$tsql= "SELECT 
              item.[Count],
              item.[Price],
              item.[TotalDiscSum],
              item.[TotalSum],
              item.[Status],
			  menu.[Name],
			  prod.[Output],
              prod.[Type],
			  prod.[Unit]
			FROM  [dbo].[tb_Order], [dbo].[tb_OrdItem] item
            LEFT OUTER JOIN [dbo].[tb_Product] prod ON prod.[ObjID]=item.[ProdID]
            LEFT OUTER JOIN [dbo].[tb_MenuItem] menu 
            ON (prod.[ObjID]=menu.[ProdID] AND menu.[LinkID]=item.[MenuID])
			WHERE item.[LinkID]=[dbo].[tb_Order].[ObjID]
            AND item.[Status]<>3
			AND [dbo].[tb_Order].[Num]=".$_GET["order"]."
            ORDER BY item.[MenuID], menu.[Pos]";
$order_item=queryRestArt($tsql);
			
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
<title>Редактирование заказа</title>
<style>
	@font-face {
		font-family: "Myriad Pro Light"; 
    	src: url(../fonts/MyriadPro-Light.otf);
	}
    html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
	font-family: "Myriad Pro Light";
    font-size: 16pt;
    }
    .flex_contaner {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    }
    #work_area {
     width: 100%;
    height: 100%;   
    display: flex;
    }
    #header {
    width: 100%;
    height: 70px;
    background-color: #51778e;
    }
    #date_time {
        color: yellow;
        position: absolute;
        right: 0;
    }
    #list {
    width:40%;
    height:100%;
    background-color: <?=$color_fon?>;
    display: flex;
    flex-direction: column;
    }
    #list_top {
    width: 100%;
    height: 160px;
    background-color: <?=$color_fon?>;    
    }
    #list_table {
    width: 100%;
    height: 100%;
    background-color: white; 
    overflow: scroll;    
    }
    #list_bottom {
    width: 100%;
    height: 160px;
    background-color: <?=$color_fon?>; 
    position: relative;
    bottom: 0;
    display: flex;
    flex-wrap: wrap;
    }
    #menu {
    width:60%;
    height:100%;
    background-color: <?=$color_fon?>;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    }
    #menu_button_area {
        width: 100%;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        align-content: flex-start;
    }
    #group_button_area {
        width: 220px;
        height: 100%;
        background-color: <?=$color_panel?>;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        
        
    }
    #menu_ctr_buttons {
        width: 100%;
        height: 100%;
        background-color: <?=$color_panel?>;
        display: flex;
        flex-wrap: wrap;
        
    }
    #menu_ctr_area {
        width: 100%;
        height: 1%;
        min-height: 130px;
        background-color: <?=$color_panel?>;
        display: flex;
        
        
    }
    .row {
        display: flex;
        height: 80%;
    }
    #menu_message {
        width: 100%;
        height: 70px;
    }
    .button {
        border-radius: 5px;
        border: solid grey 1px;
        margin: 3px;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        min-width: 70px;
    }
    .menu_ctr_button {
        max-width:  width: 180px;
        height: 40px;
        background-color: #f5e738;
        
        
    }
    .group_button {
        width: 180px;
        height: 40px;
        background-color: #2be2b1;
        
    }
    #send_order_button {
        width: 100px;
        height: 100px;
        background-color: cadetblue;
        
    }
    #group_up {
        
    }
    #group_down {
        
    }
	table {
		border-collapse: collapse;
        width: 100%;
	}
	#list_table td {
		border: 1px solid grey;
	}
    #order_choice {
        position: fixed;
        width: 50%;
        height: 80%;
        z-index: <?=$order_choice_visible?>;
        background-color: white;
        top:50%;
        left:50%;
        margin-left:-25%;
        margin-top:-25%;
        border: 2px red solid;
        display: flex;
        flex-direction: column;
        
        
        
    }
</style>
</head>
<html>
<body>
<script type="text/javascript">// Часы -------------------------------------
function clock() {
var d = new Date();
var month_num = d.getMonth()
var day = d.getDate();
var hours = d.getHours();
var minutes = d.getMinutes();
var seconds = d.getSeconds();

month=new Array("января", "февраля", "марта", "апреля", "мая", "июня",
"июля", "августа", "сентября", "октября", "ноября", "декабря");

if (day <= 9) day = "0" + day;
if (hours <= 9) hours = "0" + hours;
if (minutes <= 9) minutes = "0" + minutes;
if (seconds <= 9) seconds = "0" + seconds;

date_time = "Сегодня - " + day + " " + month[month_num] + " " + d.getFullYear() +
" г.&nbsp;&nbsp;&nbsp;"+ hours + ":" + minutes + ":" + seconds;
if (document.layers) {
 document.layers.doc_time.document.write(date_time);
 document.layers.doc_time.document.close();
}
else document.getElementById("doc_time").innerHTML = date_time;
 setTimeout("clock()", 1000);
}
</script>
<!------------------------------------------------------------->

<div class="flex_contaner">
    <div id="header">
    <div id="date_time">
		<span id="doc_time">
 		Дата и время
		</span>
	</div>
    </div>
    <div id="work_area">
        <div id="list">
            <div id="list_top">
            <div>Гость</div>
            <div>Карта</div>
            </div>
            <div id="list_table">
                <table>
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Выход</th>
                    <th>Общий вес</th>
                </tr>
    <?php
    for ($i=1;$i<=count($order_item);$i++) {
        echo'        <tr>
                    <td>'.$i.'</td>
                    <td>'.$order_item[$i]["Name"].'</td>
                    <td>'.$order_item[$i]["Count"].'</td>
                    <td>'.$order_item[$i]["Output"].'</td>
                    <td>'.$order_item[$i]["Count"]*$order_item[$i]["Output"].'</td>
                </tr>';
    }
    ?>    
                </table>
            </div>
            <div id="list_bottom">
            
                <div class="button menu_ctr_button">Кол-во</div>
                <div class="button menu_ctr_button">+1</div>
                <div class="button menu_ctr_button">-1</div>
                <div class="button menu_ctr_button">Отмена блюда</div>
                <div class="button menu_ctr_button">Курс</div>
            
            </div>
        </div>
        <div id="menu">
            <div id="menu_message"></div>
            <div class="row">
                <div id="menu_button_area">
                    <div class="button group_button">Винегрет овощной</div>
                    <div class="button group_button">Сельдь под шубой</div>
                    <div class="button group_button">Салат Греческий</div>
                    <div class="button group_button">Салат Оливье</div>
                    <div class="button group_button">Салат Маринка</div>
                </div>
                <div id="group_button_area">
                    <div class="button group_button" id="group_up"></div>
                    <div>
                        <div class="button group_button">1.Холодные закуски</div>
                        <div class="button group_button">2.Салаты</div>
                        <div class="button group_button">3.Первые блюда</div>
                        <div class="button group_button">4.Вторые блюда</div>
                        <div class="button group_button">5.Гарниры</div>
                        <div class="button group_button">6.Напитки</div>
                    </div>    
                    <div class="button group_button" id="group_down"></div>    
                </div>
            </div>
            <div id="menu_ctr_area">
                <div id="menu_ctr_buttons">
                        <div class="button menu_ctr_button">Вид меню</div>
                        <div class="button menu_ctr_button">Отменить заказ</div>
                        <div class="button menu_ctr_button" onClick="changeOrder()">Выбор заказа</div>
                        <div class="button menu_ctr_button">Кнопка</div>
                        <div class="button menu_ctr_button">Кнопка</div>
                </div>
                <div class="button" id="send_order_button">Отправить на кухню</div>
            </div>
        </div>
    </div>    
</div>
    <div id="order_choice">
        <div style="background-color:white; width:100%;height:100px;box-shadow:0px 0px 3px 0px grey;"></div>
        <div style="margin:5%;height;90%; overflow:scroll;">
            <div>
            <table id="ord_table" onclick="orderChoice()">
                <tr>
                    <th>Дата</th>
                    <th>Номер</th>
                    <th>Заказчик</th>
                    <th>Зал</th>
                </tr>
<?php
        foreach ($orders as $ord) {
         echo '       <tr>
                    <td>'.$ord["DateRsrv"]->format("d-m-Y").'</td>
                    <td>'.$ord["Num"].'</td>
                    <td>'.$ord["NameRsrv"].'</td>
                    <td>'.$ord["areaName"].'</td>
                </tr>';
        }
?>
            </table></div>
        </div>
        <div style="background-color:white; width:100%;height:100px;box-shadow:0px 0px 3px 0px grey;">
        
            <div class="button menu_ctr_button" onClick="changeOrderOK(orderNum)">OK</div>
        </div>
        
    </div>
</body>
</html>
<script type="text/javascript">
 clock();
</script>
<script type="text/javascript">
    
function changeOrder(){
    document.getElementById("order_choice").style.zIndex=10;
}    
 function orderChoice(){
   
    var table = document.getElementById('ord_table');
    var trList= table.getElementsByTagName('tr');
    for (var i=0;i<trList.length;i++){
        trList[i].style.background="white";
    }
     var el = event.target;
     el.parentElement.style.background="red";
     orderNum=el.parentElement.cells[1].innerHTML;
     
 }
    function changeOrderOK(orderNum) {
        
      document.location.href = "http://192.168.1.56/order_editor.php?order="+orderNum;  
    }
</script>