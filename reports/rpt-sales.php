<?php
if (isset($_GET['date_begin']) and isset($_GET['date_end'])) {
    $date_begin = new DateTime($_GET['date_begin']);
    $date_begin->setTime(8,00,00);
    $date_end = new DateTime($_GET['date_end']);
    $date_end->setTime(23,59,59);
} else {
    $date_begin = new DateTime();
    $date_begin->setTime(8,00,00);
    $date_end = new DateTime();
    $date_end->setTime(23,59,59);
}

/******* Обработчик ошибок SQL Server*/
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
/******* Обработчик ошибок SQL Server*/

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

		$tsql= "SELECT 
			 SUM(chkBar.[Count]) as kolvo,
             prod.[Name] as name,
             menu.[Stopped],
			 prod.[ParentID]
             FROM [dbo].[tb_Check],  [dbo].[tb_ChkBar] chkBar
            LEFT OUTER JOIN [dbo].[tb_Product] prod ON prod.[ObjID]=chkBar.[RefId]
            LEFT OUTER JOIN [dbo].[tb_MenuItem] menu ON menu.[ProdID]=chkBar.[RefId]
			WHERE chkBar.[LinkID] = [dbo].[tb_Check].[ObjID]
			AND [dbo].[tb_Check].[Type]=0
            AND menu.[LinkID]='51A9B17D-8E30-11E3-93EF-00155D012805'
            AND [dbo].[tb_Check].[Date] BETWEEN '".$date_begin->format("Ymd H:i:s")."'
       		AND '".$date_end->format("Ymd H:i:s")."'
            Group by prod.[Name], prod.[ParentID], menu.[Stopped]
			Order by prod.[ParentID], prod.[Name]";
 
//print ($tsql);

 

    
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $Item[$i]=$row;
    $i++;
}
sqlsrv_free_stmt($getResults);


//var_dump($Item);
?>


<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <title>Продажи блюд за период</title>
    <style>
	
		.cellname{
			font-family: sans-serif;
            font-weight: bold;
            font-size: 12pt;
            width: 100%;
            text-align: left;
            border-bottom: dotted 1px grey;
		}
        .cellkolvo {
            font-family: sans-serif;
            font-size: 12pt;
            width: 20%;
            text-align: right;
            border-bottom: dotted 1px grey;
        }
        .cellitogo {
            background-color: bisque;    
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;
            width: 20%;
            text-align: right;   
        }
        .cellitogoname {
            background-color: bisque; 
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;
            width: 80%;
            text-align: right;   
        }
        .cell_group_name {
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;
            text-align: center;   
        }
	</style>
</head>

<body>
<div id="main">
	

 <table cellpadding="5px" align = "center"><tr>
    <th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Наименование</th>
	<th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Продано</th>
    
 </tr>
<?php	
		
		echo '<tr><td colspan="2" class="cell_group_name">Салаты и холодные закуски</td></tr>';	
	   $itogo=0;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='43775AB1-882A-11E3-93EE-00155D012805' or $value["ParentID"]=='92AE9A61-882D-11E3-93EE-00155D012805') {
            echo '<tr>';
                        echo '<td class ="cellname"'; if($value["Stopped"]==1) echo ' style="color:grey; font-weight:normal;"'; echo' >' . $value["name"]. '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["kolvo"],1). '</td>';
			 		echo '</tr>';
		        $itogo=$itogo+$value["kolvo"];
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogo.'</td>
            </tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Первые блюда</td></tr>';	
	   $itogo=0;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='92AE9986-882D-11E3-93EE-00155D012805') {
            echo '<tr>';
                        echo '<td class ="cellname"'; if($value["Stopped"]==1) echo ' style="color:grey; font-weight:normal;"'; echo' >' . $value["name"]. '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["kolvo"],1). '</td>';
			 		echo '</tr>';
                $itogo=$itogo+$value["kolvo"];
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogo.'</td>
            </tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Вторые блюда</td></tr>';	
	  $itogo=0;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='165F4CA5-8F41-11E3-93EF-00155D012805'      //Каши
                or $value["ParentID"]=='165F4CA6-8F41-11E3-93EF-00155D012805'   //Овощные
                or $value["ParentID"]=='165F4CA7-8F41-11E3-93EF-00155D012805'   //Рыбные
                or $value["ParentID"]=='165F4CA8-8F41-11E3-93EF-00155D012805'   //Птица
                or $value["ParentID"]=='165F4CAA-8F41-11E3-93EF-00155D012805'   //Мясные натуральные
                or $value["ParentID"]=='165F4CAB-8F41-11E3-93EF-00155D012805'   //Мясные рубленые
                or $value["ParentID"]=='165F4CAC-8F41-11E3-93EF-00155D012805'   //Мясные субпродукты
               ) {
            echo '<tr>';
                        echo '<td class ="cellname"'; if($value["Stopped"]==1) echo ' style="color:grey; font-weight:normal;"'; echo' >' . $value["name"]. '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["kolvo"],1). '</td>';
			 		echo '</tr>';
			     $itogo=$itogo+$value["kolvo"];
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogo.'</td>
            </tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Гарниры</td></tr>';	
	  $itogo=0;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='92AE9911-882D-11E3-93EE-00155D012805'      //Гарниры
               ) {
            echo '<tr>';
                        echo '<td class ="cellname"'; if($value["Stopped"]==1) echo ' style="color:grey; font-weight:normal;"'; echo' >' . $value["name"]. '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["kolvo"],1). '</td>';
			 		echo '</tr>';
			    $itogo=$itogo+$value["kolvo"];
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogo.'</td>
            </tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Десерты, выпечка</td></tr>';	
	  $itogo=0;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='92AE99FD-882D-11E3-93EE-00155D012805'      //Десерты
                or $value["ParentID"]=='43775AA6-882A-11E3-93EE-00155D012805'//Выпечка
               ) {
            echo '<tr>';
                        echo '<td class ="cellname"'; if($value["Stopped"]==1) echo ' style="color:grey; font-weight:normal;"'; echo' >' . $value["name"]. '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["kolvo"],1). '</td>';
			 		echo '</tr>';
                $itogo=$itogo+$value["kolvo"];
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogo.'</td>
            </tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Напитки</td></tr>';	
	  $itogo=0;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='92AE9AED-882D-11E3-93EE-00155D012805'//Напитки
               ) {
            echo '<tr>';
                        echo '<td class ="cellname"'; if($value["Stopped"]==1) echo ' style="color:grey; font-weight:normal;"'; echo' >' . $value["name"]. '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["kolvo"],1). '</td>';
			 		echo '</tr>';
			    $itogo=$itogo+$value["kolvo"];
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogo.'</td>
            </tr>';
    echo ' </table>';
?>
	
</html>