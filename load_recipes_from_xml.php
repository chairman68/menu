
<?php  
session_start();  
?>

<!DOCTYPE html>  
<head>  
<script type="text/javascript" src="jquery-1.6.2.min.js"></script>  
<script type="text/javascript" src="jquery-ui-1.8.14.custom.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i" crossorigin="anonymous"></script> 
<script type="text/javascript" src="jquery.form.js"></script>  
<link href="jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />  
<style type="text/css">  
.ui-progressbar-value { 
    background-image: 
    url(images/pbar-ani.gif);
    padding-left:10px;
    font-weight:normal;
}

#upload_form {
    display:block;
}
#progress {
    display: none;
}

#progress #bar {
    height: 22px;
    width: 300px;
}
</style>  
<script type="text/javascript">  
var t;  
/* Функция получения информации о процессе загрузки по AJAX */
progress = function(){  
    $.ajax({
        url: 'upload_progress.php',
        dataType: 'json',
        success: function(data){
            if(data.percent) {
                $("#bar").progressbar({
                    value: Math.ceil(data.percent), // Заполняем прогресс бар
                });
                $('.ui-progressbar-value').text(data.percent+'%'); // Отображаем на прогресс баре процент загрузки
            }
        }
    });
}
$(document).ready(function() {
    /* Отправка формы загрузки по AJAX */    
    $('#form').ajaxForm({
        type: 'POST',
        success: function() { 
            clearTimeout(t);
            $('#progress').html('<b>Файл был загружен!</b>');
        },
        beforeSubmit: function() {
            /*  Перед отправкой данных на сервер прячем форму, показываем прогресс бар и запускаем таймер */
            $('#upload_form').hide();
            $('#progress').show();
            t = setInterval("progress()", 10);
        }
   });
   /* Отправка запроса на отмену загрузки */
   $('#cancel-form').ajaxForm({
       success: function() { 
           clearTimeout(t);
           $('#progress').html('<b>Загрузка была отменена!</b>');
        }
   });
});
</script>  
</head>  
<body>  
<div id="upload">  
    <div id="upload_form">
        <!-- Форма загрузки файлов на сервер -->
        <form id="form" action="upload_xml_recipe_to_restart.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
            <label for="file1">Файл для загрузки 1:&nbsp;</label><input type="file" name="file1" /><br /><br />
            <input type="submit" value="Загрузить" />
        </form>
    </div>
    <div id="progress">
        Загрузка файлf<br /><br />
        <!-- Прогресс бар -->
        <div id="bar"></div><br />
        <!-- Форма отмены загрузки файлов -->
        <form id="cancel-form" action="cancel.php" method="POST" enctype="multipart/form-data">
            <input type="submit" value="Отмена" />
        </form>
    </div>
</div>  
</body>  
</html>  






<?php
/*
<form method="post" action="upload_xml_recipe_to_restart.php" enctype="multipart/form-data">
<label for="inputfile">Загрузка файла</label>
<input type="file" id="inputfile" name="inputfile"></br>
<input type="submit" value="Загрузить">
</form>	



</body>
</html>
*/
?>