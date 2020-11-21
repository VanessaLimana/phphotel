function carrega_menu(menu){
var winW = $(window).width();
var atr = document.getElementById(menu);
if (atr.style.display != "block"){
atr.style.display = "block";
if((winW > 700)&&(winW <= 900)){
	$("#navegacao").height(340);
	$("#header").height(340);
}else if((winW>=200)&&(winW <=700)){
	$("#navegacao").height(340);
	$("#header").height(340);
}
}else{
if((winW > 700)&&(winW <= 900)){
atr.style.display = "none";
	$("#navegacao").height(180);
	$("#header").height(180);
}else{
	atr.style.display = "none";
	$("#navegacao").height(120);
	$("#header").height(120);
}
}
}