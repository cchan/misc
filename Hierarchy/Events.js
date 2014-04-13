function User(color){
	this.color = color;
	this.subords = new Array();
	this.select = function(unit){
		this.subords.push(unit);
	}
	this.move = function (x,y){
		for(var i=0;i<this.subords.length;i++)
			this.subords[i].move(x,y);
	}
}


var MouseX=0,MouseY=0,MouseDown=false;
window.onmousemove=function(e){
	if(!e)var e=window.event;var x=e.clientX;var y=e.clientY;
	MouseX=x;
	MouseY=y;
}
window.onmousedown=function(e){
	if(!e)var e=window.event;var x=e.clientX;var y=e.clientY;
	
}
window.onmouseup=function(e){
	if(!e)var e=window.event;var x=e.clientX;var y=e.clientY;
	
}
window.onclick=function(e){
	if(!e)var e=window.event;var x=e.clientX;var y=e.clientY;
	
}



function beginSelectionBox(){
	
}
function endSelectionBox(){
	
}
function moveTo(){
	
}
function selectUnits(){

}