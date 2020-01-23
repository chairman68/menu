// JavaScript Document
$(function () {
	var el =  $('#slider img'),
		indexImg = 1,
		indexMax = el.length;
	
	function change () {
		el.fadeOut(0);
		el.filter(':nth-child('+indexImg+')').fadeIn(0);
	}	
		
	function autoCange () {	
		indexImg++;
		if(indexImg > indexMax) {
			indexImg = 1;
		}			
		change ();
	}
	
	function createCashbackAlert(discount, card) {
				
						var container = document.createElement('div');
						container.setAttribute("id","cashback")
						container.innerHTML = 	'<p>Поздравляем Вас с успешным участием в акции </br> "Деньги взад" </br> на Вашу карту начислены бонусы в размере</p><div class="discount">'+discount+' % </div><div class="card">'+card+'</div>	</div>';
						document.body.appendChild(container)
						return container;
	}
	
	function CloseCashbackAlert(messageElem) {
    	messageElem.parentNode.removeChild(messageElem);
  	}
 
	function cashback() {
		$.ajax({
					url: 'ajax/cashback.php',
					type: 'POST',
					success: function(msg){
					var dds = JSON.parse(msg, function(key, value) {
						if (key == 'TransactionDateTime') return new Date(value);
						return value;
						});
					var	cashback = createCashbackAlert(dds.discount,dds.card);
						//alert("Вызов прошел "+dds.discount+dds.card);
						setTimeout(function() {CloseCashbackAlert(cashback)} ,5000);	
					}
				}

		);
	}
	
	var changer = setInterval(function() {cashback(); setTimeout(autoCange,5000);}, 10000);
	

	
});