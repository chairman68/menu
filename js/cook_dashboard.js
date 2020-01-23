// JavaScript Document
function getOrders()
{
    // отослать и получит через AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/ajax/ajax_orders_for_cooking.php");
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState!=4) return
        if (xhr.status==200) 
        {
            
            let tasks = JSON.parse(xhr.responseText);
			tasks.forEach(function(item) {
  			createTask(item.prodID,item.prodName,item.kolvo,item.produced,item.readyTime,item.status);
});
     
        }
    }
    xhr.send();
} 
function diffTime (firstTime,secondTime) 
{
let firstDate = firstTime;
let secondDate = secondTime;
let getDate = (string) => new Date(0, 0,0, string.split(':')[0], string.split(':')[1]);
let different = (getDate(secondDate) - getDate(firstDate));
let differentRes, hours, minuts;
if(different > 0) {
  differentRes = different;
  hours = Math.floor((differentRes % 86400000) / 3600000);
  minuts = Math.round(((differentRes % 86400000) % 3600000) / 60000);
} else {
  differentRes = Math.abs((getDate(firstDate) - getDate(secondDate)));
  hours = Math.floor(24 - (differentRes % 86400000) / 3600000);
  minuts = Math.round(60 - ((differentRes % 86400000) % 3600000) / 60000);
}
let result = hours + ':' + minuts;
return result;
}

function createTask(prodID,prodName,kolvo,produced,readyTime,status)
{
	let dashboard = document.getElementById("dashboard");
	
	let task = document.createElement('div');
	task.className = 'task';
	task.id = prodID;
	dashboard.appendChild(task);
	
	let divKolvo = document.createElement('div');
	divKolvo.className='task-kolvo';
	divKolvo.innerHTML=kolvo;
	
	let divProduced = document.createElement('div');
	divProduced.className='task-produced';
	divProduced.innerHTML=produced;
	
	let divProdName = document.createElement('div');
	divProdName.className='task-prodname';
	divProdName.innerHTML=prodName;
	
	let divCookingTime = document.createElement('div');
	divCookingTime.className='task-cooking-time';
	//let timeNow=new Date();
	divCookingTime.innerHTML='12:00';//diffTime(readyTime,timeNow.getHours()+':'+timeNow.getMinutes());
	
	let divBalance = document.createElement('div');
	divBalance.className='task-balance';
	divBalance.innerHTML=kolvo-produced;
	
	
	let divBegin = document.createElement('div');
	divBegin.className='task-begin';
	divBegin.innerHTML='Начать приготовление';
	if (status==1) divBegin.style.visibility='hidden';
	
	task.appendChild(divKolvo);
	task.appendChild(divProduced);
	task.appendChild(divProdName);
	task.appendChild(divCookingTime);
	task.appendChild(divBalance);
	task.appendChild(divBegin);

}

	getOrders();


