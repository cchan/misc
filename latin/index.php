<body style="font-family:Arial,sans-serif;">
<div style="width:60%;margin-left:auto;margin-right:auto;margin-top:100px;border:solid 1px black;padding:0px 20px;">

<style type="text/css">
button:disabled{
background-color:#ccc !important;
color:#999;
}
.autocomplete-suggestions{
background-color:#FFF;
border:solid 1px #000;
}
.autocomplete-selected{
text-decoration:underline;
}
</style>
<h1>Latin Forms version 0.1</h1>
<div><a href="?w=latin_declensions">latin_declensions</a> <a href="?w=latin_conjugations">latin_conjugations</a></div>
<?php
	$settings_file="index.php";
	
	$where="latin_declensions";
	if(@$_GET["w"])$where=preg_replace("/[^A-Za-z_]/",'',$_GET["w"]);
	if(!is_dir($where)||!file_exists($where.'/'.$settings_file))die("<br>Error.");
	
	
	$availablewords=array();
	if(opendir($where)){
		while (false !== ($entry = readdir()))
			if($entry!=$settings_file&&$entry!='.'&&$entry!='..')$availablewords[]=["value"=>$entry,"data"=>$entry];
		closedir();
	}
	
	
	
	$a=JSON_decode(file_get_contents("$where/$settings_file"),true);
	$settingsName=$where;
	
	$b=null;
	@$basename=$_REQUEST["basename"];
?>
<h2><?=$where;?></h2>
<div><small>There are currently <?=count($availablewords);?> words in this database. <a href="#" onclick="alert('<?php $s='';for($n=0;$n<count($availablewords);$n++)$s.=$availablewords[$n]["value"].', ';echo substr($s,0,-2);?>');return false;">List</a> <a href="?w=<?=$where;?>&basename=<?=count($availablewords)>0?$availablewords[mt_rand(0,count($availablewords)-1)]["value"]:"";?>">Random</a></small></div>
<br>
<form action='?w=<?=$where;?>' id="wordform" method='POST' autocomplete="off">
<div style="font-weight:bold;color:red;"><?php
	if($basename){
		$actioned=false;
		if(@$_POST["v"]&&@$_POST["sub"]){
			$actioned=true;
			file_put_contents("$settingsName/".preg_replace("/[^A-Za-z]/",'',$basename),JSON_encode($_POST["v"]));
			echo "Successfully submitted new forms for word '$basename'. ";
		}
		if(file_exists("$settingsName/$basename")&&$basename!=$settings_file){
			$actioned=true;
			echo "Using word '<a href='?w=$where&basename=$basename'>$basename</a>'. ";
			$b=JSON_decode(file_get_contents("$settingsName/$basename"),true);
		}
		if(!$actioned)
			echo "The word '$basename' does not exist in our database. Fill out the form and press the Submit Forms button.";
	}
	else{
		echo "Enter the word you want to study.";
	}
?></div>
<div style='display:inline-block;border:solid 1px #000000;'>
	Word [all alphabetic characters]: <input type="text" name="basename" id="wordentry" value="<?=$basename;?>" onkeypress="return checkWordsKeys();"/>
	<button onclick="return confirm('Get Forms\nAre you sure you want to get new forms and not submit forms? All currently displayed form entries will be lost.');" id="getbtn" name="get" value>Get Forms</button>
</div>
<div id="btnwrap" style="font-weight:bold;">
<button onclick='study();return false;' id="studybtn" style="background-color:yellow;">Study</button><br>
<button onclick='quiz();return false;' id="quizbtn" style="background-color:cyan;">Quiz</button><br>
<button onclick='clrinputs();return false;' id="clrbtn" style="background-color:white;">Clear Inputs</button>
<button onclick='fill();return false;' id="filbtn" style="background-color:#0f0;">Fill Inputs</button><br>
<button onclick='check();return false;' id="chkbtn" style="background-color:red;">Check Answers</button>
<button onclick='hidechk();return false;' id="hidbtn" style="background-color:orange;">Hide Answers</button>
</div>
<button name="sub" value="sub" id="subbtn" style="background-color:#f0f" onclick="return confirm('Are you sure you want to submit these new forms (overwriting previous versions)?');">Submit New Forms</button>
<div id="w"></div>
</form>
</div>
<br><div style="color:white;background-color:black;font-weight:bold;width:50%;margin-left:auto;margin-right:auto;text-align:center;border-radius:5px;padding:2px;">Copyright &copy;Clive Chan 2013-present</div><br><br><br><br><br><br><br>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.autocomplete.js"></script>
<script>
function checkWordsKeys(e){
	if(!e)var e=window.event;
	if(e.keyCode==13){$('#getbtn').click();return false;}
	return true;
}

function study(){
	$("#chkbtn,#clrbtn,#hidbtn,#filbtn,#subbtn").attr({disabled:true});
	$("#w .ans").css("color","black").show();
	$("#w .quiz").hide();
}

function fill(){
	$("#w .quiz").each(function(){
		$(this).val($(this).attr("ans"));
	}).show();
}

function quiz(){
	$("#chkbtn,#clrbtn,#hidbtn,#filbtn,#subbtn").attr({disabled:false});
	$("#w .ans").hide();
	$("#w .quiz").show();
}

function check(){
	quiz();
	$("#w .quiz").each(function(){
		$(this).siblings(".ans").css("color",$(this).attr("ans")==$(this).val()?'green':'red').show();
	}).show();
}

function hidechk(){
	$("#w .ans").hide();
}

function clrinputs(){
	$("#w .quiz").val("");
}


<?php if($basename){?>
var a=<?=JSON_encode($a);?>;
var b=<?=JSON_encode($b);?>;
var i=Array(a.length),id,text;

var tmp="<table border='1' style='width:100%;margin:10px;'><tr><th>%0%</th>";for(var x=0;x<a[2].length;x++)tmp+="<th>"+a[2][x]+"</th>";tmp+="</tr>"
var bounds=[[tmp,"</table>"],["<tr><th>%1%</th>","</tr>"],["<td style='width:50%'>","</td>"]];//What wraps each level
var toAppend="";
<?php //This is total douchebaggery
	if(count($a)>0){
	for($i=0;$i<count($a);$i++)
		echo "for(i[$i]=0;i[$i]<a[$i].length;i[$i]++){toAppend+=bounds[$i][0].replace('%$i%',a[$i][i[$i]]);";
?>
id=text='';
for(var n=0;n<a.length;n++){id+="["+i[n]+"]";text+=a[n][i[n]]+' ';}
if(b!=null)var ans=b[i[0]][i[1]][i[2]];else var ans="";
toAppend+="<input type='text' name='v"+id+"' value='' class='quiz' ans='"+ans+"' style='display:none;'><span class='ans' style='display:inline;color:black;'>"+ans+"</span>";
<?php for($i=count($a)-1;$i>=0;$i--)echo "toAppend+=bounds[$i][1];}";}?>
$("#w").append(toAppend);

if(b==null){
	quiz();
	$("#btnwrap button").attr({disabled:true});
}
else study();
<?php }else{?>
$("#btnwrap button,#subbtn").attr({disabled:true});
<?php }?>

var autodata=<?=JSON_encode($availablewords);?>;

$('#wordentry').autocomplete({
    lookup: autodata,
	beforeRender: function(){
		$(".autocomplete-suggestion:even").css({"background-color":"#CCC"});
	},
	lookupFilter:function (suggestion, query, queryLowerCase) {
		return (suggestion.value.indexOf(queryLowerCase)===0);
	}
});

</script>
</body>