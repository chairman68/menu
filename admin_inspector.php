<?php
// Страница настройки модуля чек-листов
// версия 1.0 7.02.2019
?>


<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Документ без названия</title>
<script src="js/jquery-3.3.1.min.js"></script>
    <script src="chosen_v1/chosen.jquery.js"></script>
    <link rel="stylesheet" href="chosen_v1/chosen.css" type="text/css" />
	<style>
        html,body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            color:darkgrey;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        TD, TH {
            padding: 3px; /* Поля вокруг содержимого таблицы */
            border: 1px solid grey; /* Параметры рамки */
            height: 50px;            
        }
        th {
            background: lightgrey;
            color: white;
        }
        nav div {
            width: 80%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid white;
            margin: 10%;
            cursor: pointer;
        }
        textarea {
            border: none;
            border-bottom: 1px solid grey;
            width: 500px;
            font-size: 15px;
            font-family: sans-serif;
        }
        label {
            color:blue;
        }
        .input_edit {
           border: none;
            border-bottom: 1px solid black;
           background: #ffffff; 
           outline: none; 
           height: 40px; 
           width: 500px; 
           color:dimgray;
           font-size: 16px;
           font-family: sans-serif;
            padding: 5px;
        }
        
        .contaner {
            display: flex;
        }
        .contaner_r {
            padding: 1%;
            width: 98%;
            height: 100%;
            position: absolute;
        }
        .page_label {
            font-size: 20pt;
            margin-bottom: 20px;
            
        }
        .button {
            width: 150px;
            height: 50px;
            background-color: blue;
            color: white;
            margin-bottom: 30px;
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .checkbox input {
          position: absolute;
          z-index: -1;
          opacity: 0;
          margin: 10px 0 0 20px;
        }
        .checkbox__text {
          position: relative;
          padding: 0 0 0 60px;
          cursor: pointer;
        }
        .checkbox__text:before {
          content: '';
          position: absolute;
          top: -4px;
          left: 0;
          width: 50px;
          height: 26px;
          border-radius: 13px;
          background: #CDD1DA;
          box-shadow: inset 0 2px 3px rgba(0,0,0,.2);
          transition: .2s;
        }
        .checkbox__text:after {
          content: '';
          position: absolute;
          top: -2px;
          left: 2px;
          width: 22px;
          height: 22px;
          border-radius: 10px;
          background: #FFF;
          box-shadow: 0 2px 5px rgba(0,0,0,.3);
          transition: .2s;
        }
        .checkbox input:checked + .checkbox__text:before {
          background: #9FD468;
        }
        .checkbox input:checked + .checkbox__text:after {
          left: 26px;
        }
        .checkbox input:focus + .checkbox__text:before {
          box-shadow: inset 0 2px 3px rgba(0,0,0,.2), 0 0 0 3px rgba(255,255,0,.7);
        }
        
        
        #menu {
            position: absolute;
            width: 15%;
            height: 100%;
            background-color: darkgray;
            color: white;
        }
        #content {
            position: absolute;
            left: 15%;
            width: 85%;
            height: 100%;
            
        }
        #audit {
            display: none;
        }
        #edit_audit {
            display: none;
        }
	
	
	</style>
</head>

<body>
    <div class="contaner">
	<div id="menu">
        <nav>
            <div> Рассылки </div>
            <div onClick="ajax_audit()"> Аудиты </div>
            <div> История </div>
        
        </nav>
        
        </div>
	<div id="content">
        <section class="contaner_r" id="audit">
            <div class="label">Аудиты</div>
            <div class="button" id="add_audit">+Добавить</div>
            <table id="tb_audit">
                <tr>
                    <th style="width:5%;">№</th>
                    <th style="width:35%;">Наименование</th>
                    <th style="width:30%;">Проверяющие</th>
                    <th style="width:10%;">Чек-листов</th>
                    <th style="width:10%;">Активность</th>
                    <th style="width:10%;"></th>
                </tr>
                
            </table>
        </section>    
     <section class="contaner_r" id="edit_audit">
            <div class="page_label">Редактирование Аудита</div>
         `<form>
            <label for="input_audit_name"><div>Наименование</div></label>
             <input class="input_edit" id="input_audit_name" type="text" size="35" value="Aelbn1" name="Наименование" placeholder="Наименование">
             <div style="height:30px"></div>
         <label> <div>Описание</div>
                <textarea rows="5" cols="50" name="text" id="input_audit_descript" placeholder="Описание"> Привет от старых штиблет 
                </textarea>
            </label>
            <div style="height:30px"></div>
         <label for="choice_users"><div>Пользователи</div></label>
            <select placeholder="Наименование" data-placeholder="Если пользователи не выбраны, аудит доступен всем" multiple class="chosen-select" id="choice_users">
                <option value="Koterov">one</option>
                <option value="Wyke">two</option>
                <option value="Welling">threeqwerqwerqwr</option>
            </select>
         <div style="height:30px"></div>
            <label class="checkbox">
                <input type="checkbox" />
                <div class="checkbox__text">Активность</div>
            </label>
         </form>
         <div style="display:flex; justify-content:space-between;"> 
             <div style="display:flex;">   
                <div class="button" id="btn_cancel">Отменить</div>
                 <div style="width:20px;"></div>
                 <div class="button" id="btn_save">Сохранить</div>
                 <div style="width:20px;"></div>
                 <div class="button" id="btn_exit">Выйти</div>
             </div> 
             <div style="display:flex;">   
                <div class="button" id="btn_add_checklist">Добавить чек-лист</div>
                 <div style="width:20px;"></div>
                 <div class="button" id="btn_create_checklist">Создать чек-лист</div>
             </div> 
        </div>
             <table>
                <tr>
                    <th style="width:5%;">№</th>
                    <th style="width:35%;">Наименование</th>
                    <th style="width:30%;">Описание</th>
                    <th style="width:10%;">Активность</th>
                    <th style="width:10%;"></th>
                </tr>
                
            </table>
        </section>       
    </div>
    </div>
</body>
    <script>
$(".chosen-select").chosen({width: '500px'});
function ajax_audit(){
	$.ajax({
			type: "GET",
			url: "/ajax/ajax_audit.php?callback=?",
			dataType: 'json',
			success: function (data){
                var table = document.getElementById("tb_audit");
                while(table.rows[1]) table.deleteRow(1);
              $('#tb_audit').append('<tr><td align=center>1</td><td>'+data[1].Name+'</td><td></td><td align=center>'+data[1].item+'</td><td align=center><img src="images/activ'+data[1].Activ+'.png"></td>                    <td align=center><button class="btn_editAudit" ID="'+data[1].ObjID+'"><img src="images/Edit.png" alt="Изменить"          style="width:30px; vertical-align: middle"></button></td></tr>');  
                
            }
			
	});	
    $('.contaner_r').css('display','none');
    $('#audit').css('display','block');
}
        
function ajax_edit_audit(AuditID){
	$.ajax({
			type: "GET",
			url: "/ajax/ajax_edit_audit.php?callback=?",
            data: "AuditID:"+AuditID,
			dataType: 'json',
			success: function (data){
            }
			
	});	
    $('.contaner_r').css('display','none');  
    $('#edit_audit').css('display','block');
}	
$(document).ready(function(){
    $('#tb_audit').on('click','.btn_editAudit',function() {
        console.log("куку");
        ajax_edit_audit($(this).attr('id'));
    });
});	
</script>
</html>