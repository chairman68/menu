<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Монитор повара</title>
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<style>
	body,html {
		width: 100%;
		height: 100%;
		/*overflow: hidden;*/
		margin: 0;
		padding: 0;
		font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
	}
	a {
		text-decoration: none;
		color: inherit;
	}
	#main {
		width: 100%;
		height: 100%;
		
		background-color: aliceblue;
		
	}
	#menu {
		width: 100%;
		height: 10%;
		position: fixed;
		bottom: 0;
		background-color: navajowhite;
	}
    .prep_place {
        width: 100%;
		height: 90%;
		text-align: center;
        
    }
	.orders {
        width: 50%;
        min-height: 90%;
		
	}
    .order{
    width: 100%;
	min-width: 400px;
	display: flex;
    background-color: #F7F1E2;
    }
    .order_name {
      width: 100px;  
    }
	.item {
    width: 90%;
	display: block;
	text-decoration: none;
    color: brown;
	margin-left: auto;
    margin-right: auto;
    margin-bottom: 5px;
    padding: 5px;
    border-radius: 5px;
    background-color: #fff;
	}
	.item:focus 
	.popup:hover {
		display: block;
	}
	.popup {
		position: fixed;
		margin: auto;
		width: 60%;
		height: 200px;
		display: none;
		background-color: aqua;
	}
	
</style>
</head>
	
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
" г.&nbsp;&nbsp;&nbsp;Текущее время - "+ hours + ":" + minutes + ":" + seconds;
if (document.layers) {
 document.layers.doc_time.document.write(date_time);
 document.layers.doc_time.document.close();
}
else document.getElementById("doc_time").innerHTML = date_time;
 setTimeout("clock()", 1000);
}
</script>
<!------------------------------------------------------------->
    
<div id="main">
    <div class="prep_place"> 
        <div class="orders"> 
        <div class="order">
            <div class="order_name">
                <table class="item">
                    <tr>
                        <td style="width:300px;">
                        <a  href="javascript:void(0);" tabindex="1" >'
                        Наименование
                        </a>
                        </td>
                        <td style="width:100px;">'
                        Количество
                        </td>
                        <td style="width:100px;">'
                        Едизм
                        </td>
                        <td style="width:100px;">'
                        Выход
                        </td>
                        <td style="width:100px;">'
                        Статус
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
			<div class ="ingridients">
			
		</div>
		</div>
	

	</div>
	<div id="menu">
		<span id="doc_time">
 		Дата и время
		</span>
	</div>
	
	<div class="popup"></div>
</body>
</html>
<script type="text/javascript">
 clock();
</script>
