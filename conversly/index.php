<html>
<head>
<title>Conversly</title>
<style>
#dwrap{
font-family:Segoe UI,Segoe,Open Sans,Arial,sans-serif;
font-size:20pt;
font-weight:normal;
text-align:center;
height:60%;
width:100%;
position:fixed;
}
#dwrap2{
position:absolute;bottom:0px;
width:100%;
}
#d{
transition:color 0.5s;
}
</style>
</head>
<body>
<div id="dwrap">
	<div style="font-size:40pt;color:#999">Conversly</div>
	<div id="dwrap2">
		<div>
			<br>
			<div id="d"></div>
		</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js">\x3C/script>')</script>
<script>
//power of jquery is in its lists... do more with that
var queue=new Array();
function q(h){
	queue.push(h);
}
function d(h,time){
	clearInterval(window.queueInterval);
	setTimeout(function(){
		window.queueInterval=setInterval(function(){
			if(queue.length>0)
				d(queue.shift());
		},1500);
	},1500);
	$('#d').css('color','#fff');
	setTimeout(function(){$('#d').text(h).css('color','#000');},500);
}
d('Hello');
</script>
</body>
</html>