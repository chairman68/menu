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
	var interval = setInterval(autoCange, 10000);


	
});