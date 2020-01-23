<?php?>
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/template.css" type="text/css" />
	<title>Настройка меню</title>
</head>

<body>
<form method='post'>	
<?php 
include("ini.php");
$menu="1";
$checkscr = array ('','','','','','','');


$form_file=<<<HTML
  <input type="file" name="photo" multiple accept="image/*,image/jpeg">
HTML;
 //Выбираем из таблицы меню все группы заданного меню
echo "<TABLE>";

$query = "SELECT * FROM `MenuItem` WHERE `IsGroup` ='1' AND `IdMenu` = '".$menu."'AND `ParentID`= '' ORDER BY `Pos`";
		
		if ($result = $mysqli -> query($query)) {
			
			for ($k=1; $row0 = $result -> fetch_assoc(); $k++) { //  Перебираем все группы у которых нет родителя				
			
			// Ищем дочерние группы
			$query = "SELECT * FROM `MenuItem` WHERE `IsGroup` ='1' AND `IdMenu` = '".$menu."' AND `ParentID`='".$row0['ID']."' ORDER BY `Pos`";
		
				if ($subgroup = $mysqli -> query($query)) {
					$a = mysqli_num_rows($subgroup);	
					
					if ($a==0) { // если в группе нет подгрупп
//*****************************************************************************************************						
			//Получаем текущее значение флажков для текущей группыу
			$query_scr = "SELECT * FROM `screens` WHERE `IDGroup` ='".$row0['ID']."'";
			if ($result_scr = $mysqli -> query($query_scr)) {
			
				for ($b=1; $screen = $result_scr -> fetch_assoc(); $b++) { //  Перебираем все группы меню
					echo $screen['IDGroup'];
					if ($screen['screen1']<>0) { $checkscr[1]='checked'; } else { $checkscr[1]=''; }
					if ($screen['screen2']<>0) { $checkscr[2]='checked'; } else { $checkscr[2]=''; }
					if ($screen['screen3']<>0) { $checkscr[3]='checked'; } else { $checkscr[3]=''; }
					if ($screen['screen4']<>0) { $checkscr[4]='checked'; } else { $checkscr[4]=''; }
					if ($screen['screen5']<>0) { $checkscr[5]='checked'; } else { $checkscr[5]=''; }
					if ($screen['screen6']<>0) { $checkscr[6]='checked'; } else { $checkscr[6]=''; }
				}
			}
//*****************************************************************************************************						
			
					// Выводим строку с именем группы	
						echo "<tr><td><img src = 'images/icon1.jpg'>".$row0['Name']."</td><td>";
					// Выводим в цикле шесть чекбоксов с предустановленными значениями считанными из БД	
						for ($check=1;$check<7;$check++) {
							echo "<input type='checkbox' name='".$row0['ID']."[".$check."]' value='".$check."' ".$checkscr[$check]." >".$check."  ";
						}
						echo"</td><td>".$form_file."</td></tr>";
					}
					else { // Если у группы есть подгруппы,то выводим только наименование
						
						echo "<tr><td><img src = 'images/icon1.jpg'>".$row0['Name']."</td><td></td><td></td></tr>";				
					}	
				
					// 
					for ($n=1; $row1 = $subgroup -> fetch_assoc(); $n++) { //  Перебираем  подгруппы	
						$query = "SELECT * FROM `MenuItem` WHERE `IsGroup` ='1' AND `IdMenu` = '".$menu."' AND `ParentID`='".$row1['ID']."' ORDER BY `Pos`";
		
						if ($subsubgroup = $mysqli -> query($query)) {
							$a = mysqli_num_rows($subsubgroup);	
							if ($a==0) {
							echo "<tr><td><img src = 'images/icon2.jpg'>".$row1['Name']."</td><td>";
						for ($check=1;$check<7;$check++) {
							echo "<input type='checkbox' name='".$row1['ID']."[".$check."]' value='".$check."'>".$check."  ";
						}
						echo"</td><td>".$form_file."</td></tr>";
							}
							else {
							echo "<tr><td><img src = 'images/icon2.jpg'>".$row1['Name']."</td><td></td><td></td></tr>";				
							}
							
								
							for ($m=1; $row2 = $subsubgroup -> fetch_assoc(); $m++) { //  Перебираем  подгруппы	
							
							echo "<tr><td><img src = 'images/icon3.jpg'>".$row2['Name']."</td><td>";
						for ($check=1;$check<7;$check++) {
							echo "<input type='checkbox' name='".$row2['ID']."[".$check."]' value='".$check."'>".$check."  ";
						}
						echo"</td><td>".$form_file."</td></tr>";					
							}
						}
					}				
				} 
			}
		} 
echo "</TABLE>";
			
?>

	 <input type=submit name="save" value="Сохранить">
</form>


<?php
 var_dump($_POST);
 
 if (!empty($_POST['chb'])) {
 	  $chb = $_POST['chb'];
	  foreach($chb as $index => $go)   {
	  	echo $index." - > ".$go."<br>";
	  };
 };
?>


</body>



