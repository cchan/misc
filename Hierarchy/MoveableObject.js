









//Check for dividing by zero, there's a lot - eg if xVal is zero theta weirds out
//this is horribly messy; since I have functions l and t can I just compute those each time and not keep lVal and tVal? eh will still be messy
function Vector(x,y){
	this.xVal=x;
	this.yVal=y;
	this.tVal=Math.atan(y/x);//degrees
	this.lVal=Math.sqrt(x*x+y*y);

	this.x = function(value){
		if(value === undefined)return this.xVal;
		this.xVal=value;
		this.tVal=Math.atan(this.yVal/this.xVal);
		this.lVal=Math.sqrt(this.xVal*this.xVal+this.yVal*this.yVal);
		return this;//for chaining
	};
	this.y = function(value){
		if(value === undefined)return this.yVal;
		this.yVal=value;
		this.tVal=Math.atan(this.yVal/this.xVal);
		this.lVal=Math.sqrt(this.xVal*this.xVal+this.yVal*this.yVal);
		return this;//for chaining
	};
	this.t = function(value){
		if(value === undefined)return this.tVal;
		this.tVal=value;
		this.xVal=this.lVal*cos(tVal);
		this.yVal=this.lVal*sin(tVal);
		return this;//for chaining
	};
	this.l = function(value){
		if(value === undefined)return this.lVal;
		this.lVal=value;
		this.xVal=this.lVal*cos(tVal);
		this.yVal=this.lVal*sin(tVal);
		return this;//for chaining
	};
	this.diffTo = function(vector){//the vector from this vector TO that vector.
		return new Vector(vector.x()-this.x(),vector.y()-this.y());
	}
	this.add = function(vector){//the vector resulting from the addition of these two vectors.
		return new Vector(vector.x()+this.x(),vector.y()+this.y());
	}
	this.maxL = function(len){
		if(this.lVal > len)this.l(len);
		return this;
	}
}


function MoveableObject(x,y,width,height,maxSpeed,color){
	this.divElem = document.createElement('div');
		this.divElem.class = 'Unit';
		this.divElem.style.width = width;
		this.divElem.style.height = height;
		this.divElem.style.top = x;
		this.divElem.style.left = y;
		this.divElem.style.backgroundColor = color;
		document.body.appendChild(this.divElem);
	this.dim = new Vector(width,height);//for collision
	this.current = new Vector(x,y);
	this.target = new Vector(x,y);
	this.vel = new Vector(0,0);
	this.maxSpeed = maxSpeed;
	this.move = function(x,y){
		this.target.x(x).y(y);
	}
	this.tick = function(){
		this.current = this.current.add(this.vel);//Add difference in position due to velocity
		if(this.reachedTarget()) this.target = this.current;//If we've reached it, get rid of "target"
		this.vel = this.current.diffTo(this.target).maxL(this.maxSpeed);//Get the difference vector, and set the max length to maxSpeed to normalize
		
		//Actually move the div.
		this.divElem.style.left=this.current.x();
		this.divElem.style.top=window.innerHeight-this.current.y();//the negation is taken care of here.
		this.divElem.style.transform='rotate('+this.vel.t()+'deg)';
	}
	this.reachedTarget = function(){
		return this.currentX.diffTo(targetX).l()<3;//if within 3 of target
	}
}


