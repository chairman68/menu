<?php?>
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/template.css" type="text/css" />
    <meta http-equiv="Refresh" content="60" />
	<title>Меню Три Апельсина</title>
</head>

<body bgcolor="#000000">

	<div width="100%" height="100%" ">
<?php
if ($_GET['screen']==1 or $_GET['screen']==3 or $_GET['screen']==5) {
	 echo '<img src="Images/1.jpg">';
}
if ($_GET['screen']==2 or $_GET['screen']==4) {
	echo '<img src="Images/2.jpg">';
	}
?>

<?php 
/*
		


	if (isset($_GET['screen'])) { // Проверяем наличие идентификатора экрана


        // Получаем в массив  $GroupID идентификаторы выводимых на данный экран групп ".$_GET['screen']."

		$query = "SELECT * FROM `Menu`.`Groups` WHERE `Screen` ='".$_GET['screen']."' AND `IdMenu` = '1' ORDER BY `Pos`";
		$pos = 1;	//Установка счетчика позиции вывода

		if ($result = $mysqli -> query($query)) {
			for ($k=1; $row = $result -> fetch_assoc(); $k++) { //  Перебираем все группы

                if ($row['Group_Image'] <> Null ) {
					//  Получаем наименование группы
					$name[$pos]=$row['Group_Image'];
                    $IsGroupName[$pos]=1;
                    $pos++; // Переход на следующую позицию

				};
				

                //
		        $query1 = "SELECT * FROM `Menu`.`MenuItem` WHERE `Stopped` = '0' AND `IdMenu` = '1' AND `IsGroup` = '0' AND `ParentID`='" . $row['Group'] . "' ORDER BY `Pos`";

                if ($item = $mysqli -> query($query1)) {

			        for (; $row_item = $item -> fetch_assoc() and $pos < 16; $pos++) {
                        $name[$pos]=$row_item["Name"];
                        $price[$pos]=(string)$row_item["Price"]." р.";
                        $prodID[$pos]=$row_item["ProdID"];
                        $IsGroupName[$pos]=0;

                        $query2="SELECT * FROM `menu`.`product` WHERE `idProduct`='".$prodID[$pos]."'";
                        if ($product = $mysqli -> query($query2)) {
                            for ($i = 1; $product_item = $product -> fetch_assoc(); $i++) {

                                $weight[$pos] = strtok($product_item["Comment"], ",");
                                $calories[$pos] = strtok(" %");
                                //$weight[$pos].=" г.";
                                //$calories[$pos].=" кКал";
                            }
                        }
                    }
                }
            }
        }
		    $numrow=$pos;
		    $height=floor(1180/$pos)-5;
		// Выводим позиции
		for ($pos=1; $pos < $numrow; $pos++) {
            if ($pos&1) {
                $bcolor="#F0FFF0";
                $bcolor2="#FFFFFF";

            } else {
                $bcolor="#FFFFFF";
                $bcolor2="#F0FFF0";
            }

            if ($IsGroupName[$pos]==1) {
                $classname="groupname";
                $calories[$pos] = "кКал";
                $weight[$pos] = "Выход,г";
                $price[$pos] = "Цена";
                $color="#ffffff";
                $bcolor="#008000";
                $bcolor2="#009300";
                $pricecolor="#ffffff";
                $fontsize="1em";
                $align="center";
                $fontweight="normal";
            } else {
                $classname="name";
                $color="#008000";
                $pricecolor="#C20E6A";
                $fontsize="1,6em";
                $align="right";
                $fontweight="bold";
            }

            echo '<div style = "color:'.$color.'; background-color:'.$bcolor.'; width:1920px; height:'.$height.'px; line-height:'.$height.'px; position: absolute; top:'.($pos-1)*$height.'px; left: 0px;">';
            echo '<div class="calories" style = "background-color:'.$bcolor2.';">'.$calories[$pos].'</div>';
            echo '<div class="'.$classname.'" >'.$name[$pos].'</div>';
            echo '<div class="weight" style = "background-color:'.$bcolor2.';">'.$weight[$pos].'</div>';
            echo '<div class="price" style = "color: '.$pricecolor.'; text-align: '.$align.'; font-weight:'.$fontweight.'; font-size: '.$fontsize.'; ">'.$price[$pos].'</div>	</div>';

		}


	    // Закрываем соединение
	    $mysqli -> close();
	} else {
		echo 'Нет номера экрана';}


*/
?>
	</div>

</body>
</html>
