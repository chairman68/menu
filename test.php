<?php
/* Скрипт для показа меню на экранах. Через $_GET["screen"] прнимается номер экрана */
include ("config.php");//Включаем параметры системы
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


//Установка соединения с БД
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
}
$tsql='';
if (isset($_GET['screen'])) { // Проверяем наличие идентификатора экрана

	switch ($_GET['screen']){
		case 1:
		$label='Салаты и холодные закуски';
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '".$config['ID_MENU_BUFET']."'
			AND [dbo].[tb_MenuItem].[ParentID]='3d4880a2-1fa0-11e9-bba7-00155d012807' 
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";
		break;
			case 2:
		$label='Десерты, выпечка и напитки';
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '".$config['ID_MENU_BUFET']."'
			AND ([dbo].[tb_MenuItem].[ParentID]='5de67b66-1fcc-11e9-bba7-00155d012807' OR [dbo].[tb_MenuItem].[ParentID]='5de67b83-1fcc-11e9-bba7-00155d012807')
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";
		break;
			case 3:
		$label='Первые блюда, каши и овощные блюда';
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '".$config['ID_MENU_BUFET']."'
			AND ([dbo].[tb_MenuItem].[ParentID]='70a63b0b-1fc2-11e9-bba7-00155d012807' OR [dbo].[tb_MenuItem].[ParentID]='70a63b0c-1fc2-11e9-bba7-00155d012807' OR [dbo].[tb_MenuItem].[ParentID]='240709b4-1fbf-11e9-bba7-00155d012807')
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";
		break;
			case 4:
		$label='Вторые блюда';
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '".$config['ID_MENU_BUFET']."'
			AND (	   [dbo].[tb_MenuItem].[ParentID]='70a63b0d-1fc2-11e9-bba7-00155d012807' 
					OR [dbo].[tb_MenuItem].[ParentID]='70a63b0e-1fc2-11e9-bba7-00155d012807' 
					OR [dbo].[tb_MenuItem].[ParentID]='70a63b0f-1fc2-11e9-bba7-00155d012807' 
					)
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";
		break;
			case 5:
			$label='Гарниры и прочие товары';
		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '".$config['ID_MENU_BUFET']."'
			AND (	   [dbo].[tb_MenuItem].[ParentID]='5de67b58-1fcc-11e9-bba7-00155d012807' 
					OR [dbo].[tb_MenuItem].[ParentID]='b78fed6e-1fd2-11e9-bba7-00155d012807' )
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";
		break;
	}
        

};





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

?>

<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="UTF-8">
    <meta http-equiv="Refresh" content="60" />
	<title>Меню Три Апельсина</title>
	<style>
@charset "UTF-8";
body {
  font-family: sans-serif;
  font-size: 40px;
  text-align: left;
  margin:0;
	padding: 0;
	overflow:hidden;
	}
.main {
	position: relative;			
	}
.groupname {
    background-color:  inherit;
    width:1300px;
    position: absolute;
    top: 0px;
    left: 200px;
    color: #ffffff;
    font-family: Arial;
    font-size: 1.3em;
    text-align: center;
    font-weight:bold;
}
.name {
	background-color:  inherit;
	width:1300px;
	position: absolute;
	top: 0px;
	padding-left: 20px;
	left: 200px;
	color: #008000;
	font-family: Arial;
	font-size: 1.1em;
	text-align: left;
}
.name1 {
	background-color:  inherit;
	width:1300px;
	padding-left: 20px;
	color: #008000;
	font-family: Arial;
	font-size: 1em;
	text-align: left;
	font-weight:bold;
}
.comment {
  background-color:  inherit;
  padding-left: 20px;
  color: #008000;
  font-family: Arial;
  font-size: 0.5em;
  text-align: left;
}
.weight {
  background-color:  inherit;
  width:200px;
  position: absolute;
  top: 0px;
  left: 1500px;
  font-family: Arial;
  color: inherit;
  font-size: 1em;
  text-align: center;
  /*font-weight:100;*/
}
.calories {
    background-color:  inherit;
    width:200px;
    position: absolute;
    top: 0px;
    left: 0px;
    font-family: Arial;
    color: inherit;
    font-size: 1.0em;
    text-align: center;
    font-weight:100;
}
.price {
  background-color:  inherit;
  width:200px;
  height:100%;
  position: absolute;
  top: 0px;
  left: 1700px;
  font-family: Arial;
  font-size: 1.4em;
  text-align: right;
  font-weight:bold;
}
.label {
	background-color: #008000;
	color: white;
	text-align: center;
	font-size: 2em;
	width: 100%;
	height: 100px;
	margin: 0 auto;
		}

	</style>
</head>

<body>

	<div width="100%" height="100%">
	<div class="label"><?=$label?></div>
<?php
	$pos=1;
	if (count($data)<>0) {
		$height=floor(980/count($data));
	} else {
		$height=980;}
		
	if ($height>300) $height=300;

        
	foreach ($data as $Item) {
		
		if ($pos&1) {
                $bcolor="#D1FFD1";
                $bcolor2="#FFFFFF";

            } else {
                $bcolor="#FFFFFF";
                $bcolor2="#D1FFD1";
            }
                if ($Item["Comment"]==null) $json = "{}"; else $json=$Item["Comment"];
                $prod_comment = json_decode($json);
            	$weight = $prod_comment->out;
                $calories = $prod_comment->cal;
              	if ($weight<>"") $weight=(string)$weight." г.";
				if ($calories<>"") $calories=(string)$calories." кКал";
		
                $color="#008000";
                $pricecolor="#C20E6A";
                $fontsize="1,6em";
                $align="right";
                $fontweight="bold";
            

            echo '<div style = "color:'.$color.'; background-color:'.$bcolor.'; width:1920px; height:'.$height.'px; max-height:300px;  position: absolute; top:'.(($pos-1)*$height+100).'px; left: 0px;"> ';
            echo '<div class="calories" style ="background-color:'.$bcolor2.';height:'.$height.'px;line-height:'.$height.'px;">'.$calories.'</div>';
            echo '<div class="name" ><div class="name1" style="height:'.round($height*0.7) .'px;line-height:'.round($height*0.7).'px;">'.$Item["Name"].'</div><div class="comment" style="height:'.round($height*0.3) .'px;">'.$prod_comment->comment.'</div></div>';
			//echo '<div class="comment">'.$prod_comment->comment.'</div>';
            echo '<div class="weight" style = "background-color:'.$bcolor2.';height:'.$height .'px;line-height:'.$height.'px;">'.$weight.'</div>';
            echo '<div class="price" style = "color: '.$pricecolor.';height:'.$height.'px;line-height:'.$height.'px; text-align: '.$align.'; font-weight:'.$fontweight.'; font-size: '.$fontsize.'; ">'.number_format($Item["Price"],0).' р.</div>	</div>';

		$pos++;
	}
	//line-height:'.$height.'px;
?>	
	</div>

</body>
</html>
