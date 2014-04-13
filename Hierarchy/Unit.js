function Unit(commander,x,y,width,height,maxSpeed){
	MoveableObject.call(this,x,y,width,height,maxSpeed,commander.color);
	this.subords = new Array();
	this.addSubord = function(unit){
		this.subords.push(unit);
	}
	commander.addSubord(this);
	
	//lowest unit just has empty subords; highest has empty commander (?) or has 'Player' as commander (?)
	//needs commander at all?
}
Unit.prototype = new MoveableObject();//Just gives methods
Unit.prototype.constructor = Unit;
