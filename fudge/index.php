<?php
//Site: fudgecounter.eu5.org
//Plz note this is crap code, just wanted it functioning. Not really extensible. Could make a Long_Term_Fundraiser object someday.

require_once 'secret.php';//assigns $con to sql connection
require_once 'data.php';//all the non-database data stuff like prizes and quotes

if(!isSet($HAZ_FORM))$HAZ_FORM=true;

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

if($q=$con->query('SELECT SUM(amount) AS TOTAL FROM transactions')){
	$c=$q->fetch_assoc();
	$count=$c['TOTAL'];
}
else{
	$count='error';
}

function getwrap(){
	global $con,$prizes,$count,$profit_margin;
	$str="
<tr class='subtitle'>
	<td>boxes of delicious fudge sold</td>
	<td>money raised for the team</td>
</tr>
<tr>
	<td><div id='display'>".intval($count)."</div></td>
	<td><div id='money'>$".intval($count*$profit_margin)."</div></td>
</tr>
<tr class='subtitle'>
	<td>fabulous team prizes/captain abuse</td>
	<td>leaderboard</td>
</tr>
<tr>
	<td>
		<div id='prizes'>
			<ul style='list-style:none;margin-left:-25px;'>";
			foreach($prizes as $req=>$prize)
				$str.= "<li style='color:".(($req<=$count)?'#0f0':'#ccc')."'><b>$req</b>: <small>$prize</small></li>";
			$str.="
			</ul>
		</div>
	</td>
	<td>
		<div id='leaders'>
			<ul style='list-style:none;margin-left:-25px;'>";
			$leaders=$con->query('SELECT seller,SUM(amount) AS total FROM transactions GROUP BY seller ORDER BY SUM(amount) DESC');
			while($l=$leaders->fetch_assoc()){
				$r=intval($l['total']);
				$str.="<li style='color:".
									(($r>=30)?'gold':
									(($r>=20)?'silver':
									(($r>=10)?'#A67D3D':
									(($r>=5)?'black':'gray'
									))))
					."'><b>{$l['seller']}</b>: <small>{$l['total']}</small></li>";
			}
			$str.="
			</ul>
		</div>
	</td>
</tr>";
	return $str;
}
	
function gethist(){
	global $con;
	
	$t=intval($_POST['hist']);
	if(!$t)$t=0;
	
	$a=array();
	
	$hist=$con->query('SELECT seller, buyer, amount FROM transactions WHERE UNIX_TIMESTAMP(timestamp) > '.$t.' ORDER BY timestamp DESC');
	while($r=$hist->fetch_assoc())
		$a[]="<tr class='hist'><td>{$r['seller']}<td>{$r['buyer']}<td>{$r['amount']}</tr>";
	return $a;
}

if(isSet($_POST['refreshwrap']))
	die(getwrap());
if(isSet($_POST['hist']))
	die(json_encode(array('time'=>time(),'news'=>gethist())));
?>
<noscript><span style='font-weight:bold;color:red;'>u have javascript off, stahp just turn on javascript already</span></noscript>
<link rel='stylesheet' href='style.css' />
<img src='http://www.lexrobotics.com/wordpress/wp-content/uploads/2013/03/2012_Logo.png' style='position:fixed;right:20px;top:0px;width:200px;' />
<div id='title' style='display:none'>fudgecounter<?php if($HAZ_FORM)echo ' [members only page]';?></div>
<div class='subtitle' style='color:#666;text-align:center;'>
	a <a href='http://www.lexrobotics.com' style='color:#999;' target='_blank'>Two Bits and a Byte</a> fundraiser
	<br>
	Find any Two Bits and a Byte member and buy some fudge today! Sales close Tuesday, March 18th.
	<br>
	Contact us at <a href="mailto:team@lexrobotics.com">team@lexrobotics.com</a>
</div>
<br>
<div class='quote'><span>&#8220;</span><?=$quotes[array_rand($quotes)]?><span>&#8221;</span></div>
<br>
<table id='wrap' style='margin-top:20px;'><?=getwrap()?></table>
<div id='form'>
<form method='POST' id='fudgeform'>
	<table>
		<tr><td colspan='3'><div style='border-top:solid 1px #ccc;width:100%;margin:10px;margin-left:auto;margin-right:auto;font-size:0.7em;font-weight:bold;opacity:0.5'></div></tr>
		<tr><td>Seller<td>Buyer<td>Pounds of Fudge</tr>
		
		<?php if($HAZ_FORM){?>
		<tr>
			<td><input type='text' name='seller' placeholder='Lyla Foxham' /><?php/*Be sure to enter your name the same way every time*/?>
			<td><input type='text' name='buyer' placeholder='Robotic Fudge Eater v0.4' />
			<td><input type='text' name='amount' placeholder='796.5' />
		</tr>
		<tr><td colspan=3><input type='submit' value='Add' class='subbtn' /></tr>
		<?php }?>
		<tr><td colspan=3><div style='border-top:solid 1px #ccc;width:50%;margin:10px;margin-left:auto;margin-right:auto;font-size:0.7em;font-weight:bold;opacity:0.5'>recent sales</div></tr>
		<?=implode('',gethist())?>
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
		refreshWrap();
		appendNewHistory();
	});
	e.preventDefault();
	return false;
});
function refreshWrap(){
	$.post('index.php',{getcounts:1}).success(function(data){
		$('#wrap').html(data);
	});
}
setTimeout('refreshWrap',10000);
setTimeout('appendNewHistory',10000);

var historyLastUpdated=<?=time()?>;
function appendNewHistory(){
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
		$('.hist').eq(1).css('opacity','0.8');
		$('.hist').eq(2).css('opacity','0.6');
		$('.hist').eq(3).css('opacity','0.4');
		$('.hist').eq(4).css('opacity','0.2');
		$('.hist').slice(5).hide();
	}
}
styleHistory();

//Determining iframe-ness and whether to put a title
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
