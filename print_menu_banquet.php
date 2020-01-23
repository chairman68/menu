<?php

// Форма Банкетного меню для печати
//
//		ver.	24.03.2019
/********************************************************************************/

$now = date("d.m.Y");
$menu_json=file_get_contents('http://192.168.1.56/ajax/menu.php?menu=2');
$menu=json_decode($menu_json);
//var_dump($menu);	

?>
        	
			<!-- Вывод HTML таблицы -->
            
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>Банкетное меню</title>
	<style>
body {
  font-family: sans-serif;
  font-size: 12px;
  margin-left:0px
	}
#fon{
	/* [disabled]background-image:url(../Images/fon_tea.jpg); */
}
#menu {
	margin:0 auto;
	width:810px;
	box-shadow: 0 0 30px rgba(0,0,0,0.5);
	background-color: rgba(249,77,11,0.80);
	}
#header_menu {
	width: 100%;
	height: 80px;
	padding-top: 10px;
	margin-top: 20px;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: auto;
	text-align: center;
	color: #ffffff;
	font-size: 25px;
	font-weight: bold;
	vertical-align: central;
	background-color: rgba(250,81,84,1.00);
	
}
#menu_date {
	font-size: 20px;
	
}
.table_part{
	margin: 0 auto;
	width: 800px;
	background-color: rgba(255,255,255,1.00);
	}
td {
	height:50px;
}
.td_group{
	text-align: center;
	color: #ffffff;
	font-size: 30px;
	font-weight: bold;
	vertical-align: central;
	background-color: rgba(249,77,11,0.70);
}

.td_name{
	width: 30%;
	text-align: left;
	font-size: 18px;
	vertical-align: central;
	border-bottom: 1px dotted #A5A5A5;
}

.td_comment{
	width:50%;
	text-align: left;
	font-size:16px;
	vertical-align:central;
	border-bottom: 1px dotted #A5A5A5;
}
.td_weight{
	text-align: center;
	font-size:16px;
	vertical-align:central;
	border-bottom: 1px dotted #A5A5A5;
}
.td_price{
	text-align: right;
	font-size:20px;
	vertical-align:central;
	border-bottom: 1px dotted #A5A5A5;
}

		
	</style>
</head>

<body>
	<div id="fon">
		<div id="menu">
			<div id="header_menu"> Банкетное меню <p id="menu_date">на <?=$now?></p></div>
			        
			<?php	
					echo' <div class="table_part"><table align="center" cellspacing="0" cellpadding="10" ">';	
							
					foreach ($menu as $value) {
						
								//var_dump($value);
									if ($value->IsGroup=="1" ) {
										echo '<tr>';
										echo '<td class="td_group" colspan="4">'.$value->Name.'</td>';
										echo '</tr>';
									}	 else {
										echo '<tr>';
										echo '<td class="td_name" >'.$value->Name.'</td>';
										echo '<td class="td_comment">';
										if ($value->obj_comment<>null) echo $value->obj_comment->comment;
										echo '</td>';
										echo '<td class="td_weight" >'.$value->Output;
										if ($value->Output=="") echo' </td>'; else echo' г</td>';
										echo '<td class="td_price">'.number_format($value->Price,0,',',' ').'</td>';
										echo '</tr>';
									}
					}
						
					echo' </table></div>';	
			?>

		</div>
	</div>
</body>
</html>
