<?php
/*
Live-updated checklist editor. This could eventually turn into an any-html-code collaborative editor.

Each checklist:
CID uniquely identifying
Name




edits[] with complete edit history (serialized in database)
checks[], items[] to make it easier on the client - don't have to rerender the whole thing all over again

*/
$con=new MySQLi(
$CID="31";
$Name="asdf";
$checks=array(true,false,true,true,false);
$items=array("asdf","moo","your face","foop","boing");
?>
<html>
<body>

Editing checklist <b><?php echo $Name;?></b>:
<div id="checklist-wrapper"></div>

<script type="text/javascript">//Make the client do all the work :)
var checks=new Array(<?php foreach($checks as $i=>$val){if($i>0)echo ',';if($val)echo 'true';else echo 'false';}?>);//true/false bools
var items=new Array(<?php echo '"'.implode('","',$items).'"';?>);//strings
if(checks.length!=items.length)alert("problem");
var checklistWrapper=document.getElementById("checklist-wrapper");
for(var i=0;i<checks.length;i++){
	checklistWrapper.innerHTML+='<input type="checkbox" name="checklist[]"'+((checks[i])?' checked':'')+'/><input type="text" name="items[]" value="'+items[i]+'"/><br>';
}
checklistWrapper.innerHTML+='<button>Add another item</button>';

if (window.XMLHttpRequest)var xmlhttp=new XMLHttpRequest();else var xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

var editqueue=new Array();
function sendEdit(){
	xmlhttp.open("POST","editChecklist.php",true);
	xmlhttp.send("CID=<?php echo $CID;?>");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			sendEdit();
		}
	}
}

</script>
</body>
</html>