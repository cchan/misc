<?php
//Site: fudgecounter.eu5.org

require 'secret.php';//assigns $con to sql connection

$profit_margin=6;//$ per box profit

if(isSet($_POST['seller'])&&isSet($_POST['buyer'])&&isSet($_POST['amount'])){
	$seller=strtolower(preg_replace('/[^a-zA-Z0-9]+/','_',$_POST['seller']));
	$buyer=preg_replace('/[^a-zA-Z0-9]+/','_',$_POST['buyer']);
	$amount=floatval($_POST['amount']);

	if(strlen($seller)<=1||strlen($buyer)<=1||$amount<=0||$amount>50)die('Invalid input');
	elseif($con->query("INSERT INTO transactions (seller,buyer,amount) VALUES ('$seller','$buyer',$amount)"))
		die("Success");
	else die("Error");
}

if(isSet($redalert))echo "<div class='alert_neg'>$redalert</div>";
elseif(isSet($greenalert))echo "<div class='alert_pos'>$greenalert</div>";

//Abusing the variable.
if($count=$con->query('SELECT SUM(amount) AS C FROM transactions')){
$count=$count->fetch_assoc();
$count=$count['C'];
}
else{
$count='error';
}

$prizes=[//plz no \n's
400=>'Xyla moustache to robotics',
500=>'Team pizza/ice cream',
550=>'Xyla moustache to school',
600=>'Lyle straightens hair',
650=>'Lyle adds pink bow',
700=>'Xyla poodle hair',
750=>'Lyle+Xyla, all above to school',
];

if(isSet($_POST['getcounts'])){
	$str=intval($count)."\n";
	foreach($prizes as $req=>$prize)$str.="<li style='color:".(($req<=$count)?'#0f0':'#ccc')."'><b>$req</b>: <small>$prize</small></li>";
	$str.="\n".intval($count*$profit_margin);
	die($str);
}

if(isSet($_POST['hist'])){
	$t=intval($_POST['hist']);
	if(!$t)die();
	$hist=$con->query('SELECT seller, buyer, amount FROM transactions WHERE UNIX_TIMESTAMP(timestamp) > '.$t.' ORDER BY timestamp ASC');
	$a=array();
	while($r=$hist->fetch_assoc()){
		$a[]="<tr class='hist'><td>{$r['seller']}<td>{$r['buyer']}<td>{$r['amount']}</tr>";
	}
	die(json_encode(['time'=>time(),'news'=>$a]));
}

$leaders=$con->query('SELECT seller,SUM(amount) AS total FROM transactions GROUP BY seller ORDER BY SUM(amount) DESC');

$quotes=[
	'Life is uncertain.  Eat dessert first.  ~Ernestine Ulmer',
	'Research tells us fourteen out of any ten individuals likes chocolate.  ~Sandra Boynton',
	'There are two kinds of people in the world: those who love chocolate, and communists. ~Leslie Moak Murray',
	'Forget love - I\'d rather fall in chocolate!  ~Sandra J. Dykes',
	'All you need is love. But a little chocolate now and then doesn\'t hurt. ~Charles M. Schulz',
	'Anything is good if it\'s made of chocolate. ~Jo Brand',
	'Chocolate is the first luxury. It has so many things wrapped up in it: Deliciousness in the moment, childhood memories, and that grin-inducing feeling of getting a reward for being good. ~Mariska Hargitay',
	'Chocolate is not cheating! After a salty meal, you need a little bit of sweet. This is living, not cheating. ~Ali Landry',
	'A new British survey has revealed that 9 out of 10 people like Chocolate. The tenth lies. - Robert Paul',
	'Anything is good and useful if it\'s made of chocolate.',
	'What is the meaning of life? All evidence to date suggests it\'s chocolate.',
	'Put “eat chocolate” at the top of your list of things to do today. That way, at least you\'ll get one thing done.',
	'Momma always said life is like a box of chocolates. You never know what you\'re gonna get. - Forrest Gump',
	'There\'s nothing better than a good friend, except a good friend with chocolate. - Linda Grayson, The Pickwick Papers',
	'After a bar of chocolate one can forgive anybody, even one\'s relatives.',
	'The bank of friendship cannot exist for long without deposits of chocolate.',
	'Other things are just food. But chocolate\'s chocolate. - Patrick Skene Catling',
	'Once you consume chocolate, chocolate will consume you.',
	'Chocolate makes everyone smile-even bankers. - Ben Strohecker, chocolatier',
	'Anything tastes better dipped in chocolate.',
	'Money talks. Chocolate sings!',
	'Chocolate is not a matter of life and death - it\'s more important than that!',
	'If chocolate is the answer, the question is irrelevant.',
	'Dip it in chocolate; it\'ll be fine.',
];
$quote=$quotes[array_rand($quotes)];
?>
<noscript><span style='font-weight:bold;color:red;'>u have javascript off, stahp just turn on javascript already</span></noscript>
<style>
body{
font-family:Ubuntu,Segoe UI,Frutiger,Open Sans,Arial,sans-serif;
}

#title{
text-align:center;
font-size:22pt;
font-weight:bold;
opacity:0.7;
margin-bottom:20px;
}
.quote{
text-align:center;
font-family:Times New Roman,serif;
font-style:italic;
font-size:10pt;
line-height:1em;
opacity:0.8;
}
.quote span{
font-size:3em;position:relative;top:10px;
opacity:0.4;
}
#wrap{
font-weight:bold;
text-align:center;
margin-left:auto;
margin-right:auto;
}
#wrap td{
width:50%;
}
#display{
font-size:72pt;
color:#7f5217;
}
#money{
font-size:72pt;
color:#fdd017;
}
.subtitle td{
text-align:center;
font-size:12pt;
font-weight:normal;
font-family:Impact,Verdana,sans-serif;
width:100%;
}
#prizes,#leaders{
font-size:12pt;
}

#form{
text-align:center;
display:block;
width:100%;
}
#form table{
display:inline;
}
#form *{
text-align:center;
}
#form input{
width:200px;
}
.subbtn{
background-color:white;
border:solid 1px #999;
}
.hist td{
border:solid 1px #ccc;
color:#666;
}
</style>
<img src='http://www.lexrobotics.com/wordpress/wp-content/uploads/2013/03/2012_Logo.png' style='position:fixed;right:20px;top:0px;width:200px;' />
<div id='title' style='display:none'>fudgecounter</div>
<div class='subtitle' style='color:#999;text-align:center;'>a <a href='http://www.lexrobotics.com' style='color:#999;' target='_blank'>Two Bits and a Byte</a> fundraiser</div>
<div class='quote'><span>&#8220;</span><?=$quote?><span>&#8221;</span></div>
<table id='wrap' style='margin-top:20px;'>
<tr class='subtitle'><td>boxes of delicious fudge sold<td>money raised for the team</tr>
<tr>
<td><div id='display'><?=intval($count)?></div>
<td><div id='money'>$<?=intval($count*$profit_margin)?></div>
</td>
<tr class='subtitle'><td>fabulous team prizes/captain abuse<td>leaderboard</tr>
<tr>
	<td><div id='prizes'><ul style='list-style:none;margin-left:-25px;'>
		<?php foreach($prizes as $req=>$prize){
				echo "<li style='color:".(($req<=$count)?'#0f0':'#ccc')."'><b>$req</b>: <small>$prize</small></li>";
			}
		?>
		</ul></div>
	<td><div id='leaders'><ul style='list-style:none;margin-left:-25px;'>
		<?php while($l=$leaders->fetch_assoc()){
				if($l['total']>=30)$color='gold';//gold
				elseif($l['total']>=20)$color='silver';//silver
				elseif($l['total']>=10)$color='#A67D3D';//bronze
				elseif($l['total']>=5)$color='black';
				else $color='gray';
				echo "<li style='color:$color'><b>{$l['seller']}</b>: <small>{$l['total']}</small></li>";
			}
		?>
		</ul></div>
</tr>
</table>
<div id='form'>
<form method='POST' id='fudgeform'>
	<table>
		<tr><td>Seller<td>Buyer<td>Pounds of Fudge</tr>
		<tr>
			<td><input type='text' name='seller' placeholder='Lyla Foxham' /><?php/*Be sure to enter your name the same way every time*/?>
			<td><input type='text' name='buyer' placeholder='Robotic Fudge Eater v0.4' />
			<td><input type='text' name='amount' placeholder='796.5' />
		</tr>
		<tr><td colspan=3><input type='submit' value='Add' class='subbtn' /></tr>
		<tr><td colspan=3><div style='border-top:solid 1px #ccc;width:50%;margin:10px;margin-left:auto;margin-right:auto;font-size:0.7em;font-weight:bold;opacity:0.5'>recent sales</div></tr>
		<?php
		$hist=$con->query('SELECT seller, buyer, amount FROM transactions ORDER BY timestamp DESC');
		while($r=$hist->fetch_assoc()){
			echo "<tr class='hist'><td>{$r['seller']}<td>{$r['buyer']}<td>{$r['amount']}</tr>";
		}
		?>
		<tr><td colspan='3'><input type='submit' id='histtogglebtn' value='+' style='width:20px;height:20px;padding:0px;border-radius:10px;text-align:center;vertical-align:middle;font-size:10pt;' /></tr>
	</table>
</form>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
//color plugin
(function(d){d.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(f,e){d.fx.step[e]=function(g){if(!g.colorInit){g.start=c(g.elem,e);g.end=b(g.end);g.colorInit=true}g.elem.style[e]="rgb("+[Math.max(Math.min(parseInt((g.pos*(g.end[0]-g.start[0]))+g.start[0]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[1]-g.start[1]))+g.start[1]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[2]-g.start[2]))+g.start[2]),255),0)].join(",")+")"}});function b(f){var e;if(f&&f.constructor==Array&&f.length==3){return f}if(e=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(f)){return[parseInt(e[1]),parseInt(e[2]),parseInt(e[3])]}if(e=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(f)){return[parseFloat(e[1])*2.55,parseFloat(e[2])*2.55,parseFloat(e[3])*2.55]}if(e=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(f)){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}if(e=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(f)){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}if(e=/rgba\(0, 0, 0, 0\)/.exec(f)){return a.transparent}return a[d.trim(f).toLowerCase()]}function c(g,e){var f;do{f=d.css(g,e);if(f!=""&&f!="transparent"||d.nodeName(g,"body")){break}e="backgroundColor"}while(g=g.parentNode);return b(f)}var a={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]}})(jQuery);

$('#fudgeform .subbtn').click(function(e){
	$(this).val('loading.....').prop('disabled',true);
	window.loadingInterval=setInterval(function(){var x=$('#fudgeform .subbtn');x.val(x.val().replace('.....','.    ').replace('. ','..'));},300);
	$.post('index.php',$('#fudgeform').serialize()).success(function(data){
		clearInterval(window.loadingInterval);
		$('#fudgeform .subbtn').val(data);
		if(data=='Success'){
			$('#fudgeform .subbtn').css('background-color','#6f6').animate({'background-color':'#fff'},2000);
			$('#fudgeform')[0].reset();
		}
		else{
			$('#fudgeform .subbtn').css('background-color','#f66').animate({'background-color':'#fff'},2000);
		}
		setTimeout(function(){$('#fudgeform .subbtn').val('Add').prop('disabled',false);},2000);
		refreshValues();
		refreshHistory();
	});
	e.preventDefault();
	return false;
});
function refreshValues(){
	$.post('index.php',{getcounts:1}).success(function(data){
		var x=data.split('\n');
		$('#display').html(x[0]);
		$('#prizes').html("<ul style='list-style:none;margin-left:-25px;'>"+x[1]+"</ul>");
		$('#money').html('$'+x[2]);
	});
}
setTimeout('refreshValues',10000);
setTimeout('refreshHistory',10000);

var historyLastUpdated=<?=time()?>;
function refreshHistory(){
	$.post('index.php',{hist:historyLastUpdated}).success(function(data){
		var x=JSON.parse(data);
		historyLastUpdated=parseInt(x['time']);
		
		for(var i=0;i<x['news'].length;i++){
			$('.hist').eq(0).before(x['news'][i]);
			$('.hist').eq(0).css('background-color','#6f6').animate({'background-color':'#fff'},2000);
		}
		styleHistory();
	});
}

var showFullHistory=false;
function styleHistory(){
	if(showFullHistory){
		$('.hist').show().css('opacity','1');
	}
	else{
		$('.hist').eq(0).css('opacity','1');
		$('.hist').eq(1).css('opacity','0.7');
		$('.hist').eq(2).css('opacity','0.5');
		$('.hist').eq(3).css('opacity','0.3');
		$('.hist').eq(4).css('opacity','0.1');
		$('.hist').slice(5).hide();
	}
}
styleHistory();


$(function(){
	if(window.self === window.top)$('#title').show();
	
	$('#histtogglebtn').click(function(){
		if(this.value=='-'){
			this.value='+';
			showFullHistory=false;
			styleHistory();
		}
		else{
			this.value='-';
			showFullHistory=true;
			styleHistory();
		}
		return false;
	});
});
</script>