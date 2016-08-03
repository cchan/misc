
//Precede with ping amazon.com (ctrl-c)
	//nmap [ip]
	//sendstream [ip] [port]
	//search "Noms"

function randInt(x){
	return Math.floor(Math.random()*x);
}
function randIP(){
	return randInt(256) + "." + randInt(256) + "." + randInt(256) + "." + randInt(256);
}
function randBytes(){
	return randInt(100000)+10000;
}

console.log("Exploit CVE-2014-0160"); //heartbleed </3
console.log("205.251.242.54 port "+process.argv[2]);
console.log("Processing data stream...");
setTimeout(function(){
console.log("Heartbeat 0: stream length "+randBytes()+" bytes");
for(var i = 1; Math.random() > 0.001; i++){
	console.log("No matches.");
	console.log("Heartbeat "+i+": stream length "+randBytes()+" bytes");
}
console.log("Match! Sending Amazon API request...");
setTimeout(function(){
console.log("ACCESS: Amazon User Database");

console.log("Enter search term:");
var done = false;
process.stdin.on('data',function(t){
	if(!done){
	t = t.slice(0,-2);
	console.log("Searching for purchasers...");
	setTimeout(function(){
		console.log("1 MATCHES:");
		console.log("10/7/15 ----- Solomon Wang (bought ACME LIGHTSABER)");
		done = true;
	},1000);
	}
	else{
		process.exit(0);
	}
});
},2000);
},2000);
