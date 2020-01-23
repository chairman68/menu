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
            convert(datetime, substring(convert(binary(8), [tb_Check].[Date]), 1, 4)+0x00000000) as date,
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
            Group by prod.[Name], prod.[ParentID], menu.[Stopped], date 
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

foreach ($Item as $value){
    $data[$value["name"]][$value["date"]->format("dmY")]+=$value["kolvo"];
	$data[$value["name"]]["itogo"]+=$value["kolvo"];
    $data[$value["name"]]["ParentID"]=$value["ParentID"];
}
function myCmp($a, $b)
{
   if ($a['itogo'] == $b['itogo']) return 0;
   return $a['itogo'] > $b['itogo'] ? -1 : 1;
}
uasort($data, "myCmp");
$name=array_unique(array_keys($data));

//var_dump($data);
//var_dump($name);
?>


<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <title>Продажи блюд за неделю</title>
    <style>
	
		.cellname{
			font-family: sans-serif;
            font-weight: normal;
            font-size: 12pt;
            width: 100%;
            text-align: left;
            border-bottom: dotted 1px grey;
		}
        .cellkolvo {
            font-family: sans-serif;
            font-size: 12pt;
            width: 20%;
            text-align: center;
            border-bottom: dotted 1px grey;
            border-left: dotted 1px grey;
        }
        .cellitogo {
            background-color: bisque;    
            color: crimson;
            font-family: sans-serif;
            font-size: 12pt;
            width: 20%;
            text-align: center;   
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
        thread {
            position: fixed;
        }
        th {
            background-color: bisque;
            color: black;
            font-family: sans-serif;
            font-weight: normal;
            font-size: 12pt;
            position: sticky;
            top: 0;
            
        }
		body, html {
			width: 100%;
			height: 100%;
		}
		#main {
			margin:5%;
		}
	</style>
</head>

<body>
<div id="main">
	

 <table cellpadding="5px" align = "center">
     <tread>
        <th >Наименование</th>
<?php 
         $date=clone $date_begin;
         while ($date<$date_end){
             echo'<th >'.$date->format("d M D").'</th>';
             $date=$date->add(new DateInterval('P1D'));
         }
         

?>  
		<th>Всего</th> 
    </tread>
<?php	
		
		echo '<tr><td colspan="2" class="cell_group_name">Салаты и холодные закуски</td></tr>';	
	   $itogo=array();
     
        
     foreach ($name as $value){
            if ($data[$value]["ParentID"]=='43775AB1-882A-11E3-93EE-00155D012805' or $data[$value]["ParentID"]=='92AE9A61-882D-11E3-93EE-00155D012805') {
               
            echo '<tr>';
                        echo '<td class ="cellname">' . $value. '</td>';
                        $date=clone $date_begin;
                        $i=1;
                        while ($date<$date_end){
                            echo'<td class ="cellkolvo">';
                            if ($data[$value][$date->format("dmY")]<>0) { 
                                echo number_format($data[$value][$date->format("dmY")],0);
                            }
                            echo '</td>';
				
                            
                            $itogo[$i]+=$data[$value][$date->format("dmY")];
                            $i++;
                            $date=$date->add(new DateInterval('P1D'));
                        }
                    	echo '<td class="cellitogo">';
							if ($data[$value]["itogo"]<>0) { 
                                echo number_format($data[$value]["itogo"],0);
                            }
							echo '</td>';
			 		echo '</tr>';
		        
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>';
     
     
            foreach ($itogo as $vsego) {
                echo '<td class="cellitogo">';
				if ($vsego<>0) {
					echo number_format($vsego,0);
				}
				echo '</td>';
            }
            echo '<td class="cellitogo"></td></tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Первые блюда</td></tr>';	
	   $itogo=array();	
     foreach ($name as $value){
            if ($data[$value]["ParentID"]=='92AE9986-882D-11E3-93EE-00155D012805') {
            echo '<tr>';
                        echo '<td class ="cellname">' . $value. '</td>';
                        $date=clone $date_begin;
                        $i=1;
                        while ($date<$date_end){
                            echo'<td class ="cellkolvo">';
                            if ($data[$value][$date->format("dmY")]<>0) { 
                                echo number_format($data[$value][$date->format("dmY")],0);
                            }
                            echo '</td>';
							
                            
                            $itogo[$i]+=$data[$value][$date->format("dmY")];
                            $i++;
                            $date=$date->add(new DateInterval('P1D'));
                        }
                    	echo '<td class="cellitogo">';
							if ($data[$value]["itogo"]<>0) { 
                                echo number_format($data[$value]["itogo"],0);
                            }
							echo '</td>';
			 		echo '</tr>';
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>';
     
     
            foreach ($itogo as $vsego) {
                echo '<td class="cellitogo">';
				if ($vsego<>0) {
					echo number_format($vsego,0);
				}
				echo '</td>';
            }
            echo '<td class="cellitogo"></td></tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Вторые блюда</td></tr>';	
	  $itogo=array();
     foreach ($name as $value){
            if ($data[$value]["ParentID"]=='165F4CA5-8F41-11E3-93EF-00155D012805'      //Каши
                or $data[$value]["ParentID"]=='165F4CA6-8F41-11E3-93EF-00155D012805'   //Овощные
                or $data[$value]["ParentID"]=='165F4CA7-8F41-11E3-93EF-00155D012805'   //Рыбные
                or $data[$value]["ParentID"]=='165F4CA8-8F41-11E3-93EF-00155D012805'   //Птица
                or $data[$value]["ParentID"]=='165F4CAA-8F41-11E3-93EF-00155D012805'   //Мясные натуральные
                or $data[$value]["ParentID"]=='165F4CAB-8F41-11E3-93EF-00155D012805'   //Мясные рубленые
                or $data[$value]["ParentID"]=='165F4CAC-8F41-11E3-93EF-00155D012805'   //Мясные субпродукты
               ) {
            echo '<tr>';
                        echo '<td class ="cellname">' . $value. '</td>';
                        $date=clone $date_begin;
                        $i=1;
                        while ($date<$date_end){
                            echo'<td class ="cellkolvo">';
                            if ($data[$value][$date->format("dmY")]<>0) { 
                                echo number_format($data[$value][$date->format("dmY")],0);
                            }
                            echo '</td>';
							
                            
                            $itogo[$i]+=$data[$value][$date->format("dmY")];
                            $i++;
                            $date=$date->add(new DateInterval('P1D'));
                        }
                    	echo '<td class="cellitogo">';
							if ($data[$value]["itogo"]<>0) { 
                                echo number_format($data[$value]["itogo"],0);
                            }
						echo '</td>';
			 		echo '</tr>';
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>';
     
     
            foreach ($itogo as $vsego) {
                echo '<td class="cellitogo">';
				if ($vsego<>0) {
					echo number_format($vsego,0);
				}
				echo '</td>';
            }
            echo '<td class="cellitogo"></td></tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Гарниры</td></tr>';	
	 $itogo=array();	
     foreach ($name as $value){
            if ($data[$value]["ParentID"]=='92AE9911-882D-11E3-93EE-00155D012805'      //Гарниры
               ) {
            echo '<tr>';
                        echo '<td class ="cellname">' . $value. '</td>';
                        $date=clone $date_begin;
                        $i=1;
                        while ($date<$date_end){
                            echo'<td class ="cellkolvo">';
                            if ($data[$value][$date->format("dmY")]<>0) { 
                                echo number_format($data[$value][$date->format("dmY")],0);
                            }
                            echo '</td>';
							
                            
                            $itogo[$i]+=$data[$value][$date->format("dmY")];
                            $i++;
                            $date=$date->add(new DateInterval('P1D'));
                        }
                    	echo '<td class="cellitogo">';
							if ($data[$value]["itogo"]<>0) { 
                                echo number_format($data[$value]["itogo"],0);
                            }
						echo '</td>';
			 		echo '</tr>';
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>';
     
     
            foreach ($itogo as $vsego) {
                echo '<td class="cellitogo">';
				if ($vsego<>0) {
					echo number_format($vsego,0);
				}
				echo '</td>';
            }
            echo '<td class="cellitogo"></td></tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Десерты, выпечка</td></tr>';	
	  $itogo=array();
     foreach ($name as $value){
            if ($data[$value]["ParentID"]=='92AE99FD-882D-11E3-93EE-00155D012805'      //Десерты
                or $data[$value]["ParentID"]=='43775AA6-882A-11E3-93EE-00155D012805'//Выпечка
               ) {
            echo '<tr>';
                        echo '<td class ="cellname">' . $value. '</td>';
                        $date=clone $date_begin;
                        $i=1;
                        while ($date<$date_end){
                            echo'<td class ="cellkolvo">';
                            if ($data[$value][$date->format("dmY")]<>0) { 
                                echo number_format($data[$value][$date->format("dmY")],0);
                            }
                            echo '</td>';
							
                            
                            $itogo[$i]+=$data[$value][$date->format("dmY")];
                            $i++;
                            $date=$date->add(new DateInterval('P1D'));
                        }
                    	echo '<td class="cellitogo">';
							if ($data[$value]["itogo"]<>0) { 
                                echo number_format($data[$value]["itogo"],0);
                            }
						echo '</td>';
			 		echo '</tr>';
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>';
     
     
            foreach ($itogo as $vsego) {
                echo '<td class="cellitogo">';
				if ($vsego<>0) {
					echo number_format($vsego,0);
				}
				echo '</td>';
            }
            echo '<td class="cellitogo"></td></tr>';
     //*************************************************************************
     echo '<tr><td colspan="2" class="cell_group_name">Напитки</td></tr>';	
	  $itogo=array();	
     foreach ($name as $value){
            if ($data[$value]["ParentID"]=='92AE9AED-882D-11E3-93EE-00155D012805'//Напитки
               ) {
            echo '<tr>';
                        echo '<td class ="cellname">' . $value. '</td>';
                        $date=clone $date_begin;
                        $i=1;
                        while ($date<$date_end){
                            echo'<td class ="cellkolvo">';
                            if ($data[$value][$date->format("dmY")]<>0) { 
                                echo number_format($data[$value][$date->format("dmY")],0);
                            }
                            echo '</td>';
							
                            
                            $itogo[$i]+=$data[$value][$date->format("dmY")];
                            $i++;
                            $date=$date->add(new DateInterval('P1D'));
                        }
                    	echo '<td class="cellitogo">';
							if ($data[$value]["itogo"]<>0) { 
                                echo number_format($data[$value]["itogo"],0);
                            }
						echo '</td>';
			 		echo '</tr>';
            }
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>';
     
     
            foreach ($itogo as $vsego) {
                echo '<td class="cellitogo">';
				if ($vsego<>0) {
					echo number_format($vsego,0);
				}
				echo '</td>';
            }
            echo '<td class="cellitogo"></td></tr>';
    echo ' </table>';
?>
	
</html>