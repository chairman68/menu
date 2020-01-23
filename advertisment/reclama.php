
<!doctype html>
<?php?>
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="css/template.css" type="text/css" />
<!--    <meta http-equiv="Refresh" content="10;URL=http://192.168.1.55/advertisment/reclama3.php" /> -->
	<title>Реклама</title>
</head>

<body bgcolor="#000000">

	<div width="100%" height="100%" ">
    
	 <?php
  $dir = 'imgreclama/'; // Папка с изображениями
  $cols = 3; // Количество столбцов в будущей таблице с картинками
  $files = scandir($dir); // Берём всё содержимое директории
  
  
  $k = 0; // Вспомогательный счётчик для перехода на новые строки
  
  for ($i = 0; $i < count($files); $i++) { // Перебираем все файлы
    if (($files[$i] != ".") && ($files[$i] != "..")) { // Текущий каталог и родительский пропускаем
      $path = $dir.$files[$i]; // Получаем путь к картинке
      echo "<img src='$path' alt='' width='100%' />"; // Вывод превью картинки
      /* Закрываем строку, если необходимое количество было выведено, либо данная итерация последняя */
      //if ((($k + 1) % $cols == 0) || (($i + 1) == count($files))) echo "</tr>";
      //$k++; // Увеличиваем вспомогательный счётчик
    }
  }
  ?>

 
	</div>

</body>
</html>