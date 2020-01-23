

function taskOn() {
	
	document.getElementById('panel-task').style.display='flex';
	document.getElementById('panel-recipe').style.display='none';
	document.getElementById('panel-production').style.display='none';
	document.getElementById('button-top-left').className="button-active";
	document.getElementById('button-top-center').className="button-passive";
	document.getElementById('button-top-right').className="button-passive";
	
}
function recipeOn() {
	
	document.getElementById('panel-task').style.display='none';
	document.getElementById('panel-recipe').style.display='block';
	document.getElementById('panel-production').style.display='none';
	document.getElementById('button-top-left').className="button-passive";
	document.getElementById('button-top-center').className="button-active";
	document.getElementById('button-top-right').className="button-passive";
	
	
}
function productionOn() {
	
	document.getElementById('panel-task').style.display='none';
	document.getElementById('panel-recipe').style.display='none';
	document.getElementById('panel-production').style.display='flex';
	document.getElementById('button-top-left').className="button-passive";
	document.getElementById('button-top-center').className="button-passive";
	document.getElementById('button-top-right').className="button-active";
	
	
}

function buttonRecipeActive(){
	document.getElementById("button-recipe").className="button-shadow button-shadow-active";
	document.getElementById("button-tecnology").className="button-shadow";
	document.getElementById("button-photo").className="button-shadow";
	
	document.getElementById("panel-recipe-ingridients").style.display="flex";
	document.getElementById("panel-recipe-tecnology").style.display="none";
	document.getElementById("panel-recipe-photo").style.display="none";
}
function buttonTecnologyActive(){
	document.getElementById("button-recipe").className="button-shadow";
	document.getElementById("button-tecnology").className="button-shadow button-shadow-active";
	document.getElementById("button-photo").className="button-shadow";
	
	document.getElementById("panel-recipe-ingridients").style.display="none";
	document.getElementById("panel-recipe-tecnology").style.display="flex";
	document.getElementById("panel-recipe-photo").style.display="none";
	
}
function buttonPhotoActive(){
	document.getElementById("button-recipe").className="button-shadow";
	document.getElementById("button-tecnology").className="button-shadow";
	document.getElementById("button-photo").className="button-shadow button-shadow-active";
	
	document.getElementById("panel-recipe-ingridients").style.display="none";
	document.getElementById("panel-recipe-tecnology").style.display="none";
	document.getElementById("panel-recipe-photo").style.display="flex";
}


document.getElementById('button-top-left').onclick=taskOn;
document.getElementById('button-top-center').onclick=recipeOn;
document.getElementById('button-top-right').onclick=productionOn;

document.getElementById('button-recipe').onclick=buttonRecipeActive;
document.getElementById('button-tecnology').onclick=buttonTecnologyActive;
document.getElementById('button-photo').onclick=buttonPhotoActive;