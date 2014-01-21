<!DOCTYPE html>
<?php
//Simple. Beautiful. Fast. Mail. InBoxes.
//SMTP/IMAP online email client; use your email, but make it prettier!
?>
<html>
<head>
<title>inBoxes mail client</title>
<style>
body{
padding:0px;
margin:0px;
font-family:'Open Sans','Segoe UI',Segoe,Verdana,Arial,sans-serif;
}
#header-wrapper{
width:100%;
height:40px;
position:fixed;
top:0px;
left:0px;
right:0px;
z-index:1;
background-color:#339;
}
#boxes-wrapper{
position:fixed;
top:40px;
left:0px;
right:0px;
bottom:0px;
z-index:0;
background-color:#fff;
}
#header{
color:#fff;
height:30px;
line-height:30px;
text-align:center;
padding:5px 35px;
}
#logo{
float:left;
font-size:15pt;
padding:0px 20px 0px 20px;
}
#logo:hover{
background-color:#33c;
}
#nav{
width:200px;
margin-left:-100px;
position:absolute;
left:50%;
}
#login{
float:right;
}

#compose-link:hover,#close-link:hover{
text-decoration:underline;
cursor:pointer;
}

#email-writer{
position:fixed;
top:-1000px;
height:80%;
left:15%;
right:15%;
width:70%;
z-index:2;
border:solid 3px #339;
background-color:white;
transition:top 2s;
padding:0px 20px 20px 20px;
}
#email-writer table{
width:100%;
}
#email-writer th{
text-align:right;
vertical-align:top;
width:15%;
}
#email-writer td{
text-align:left;
vertical-align:top;
width:85%;
}
#email-writer td textarea{
width:100%;
height:10em;
}

.box{
width:200px;
height:200px;
margin:50px;
border:solid 3px #339;
display:inline-block;
transition:border 0.25s;
}
.box:hover{
border:solid 3px #993;
cursor:pointer;
}
</style>
</head>
<body>
<div id='header-wrapper'>
<div id='header'>
<span id='logo'><img src='logo_small.png' alt='logo' height='30' width='30' style='height:30;width:30;float:left;'/> inBoxes</span>
<span id='nav'><span id='compose-link'>compose</span></span>
<span id='login'>login</span>
<?php //log in with smtp server (with suggestions), email addr, password - we don't even need to do it ourselves! ?>
</div>
</div>
<div id='boxes-wrapper'></div>
<div id='email-writer'>
<div style="text-align:center;"><span id='close-link'>close</span></div>
<form>
<table>
<tr><th>to</th><td><input type='text' name='subj' placeholder="who it's for"/></td></tr>
<tr><th>subject</th><td><input type='text' name='subj' placeholder="what it's about"/></td></tr>
<tr><th>body</th><td><textarea name='body' placeholder='Hi, message content goes here'></textarea></td></tr>
</table>
</form>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="jquery-1.9.1.js"><\/script>')</script>
<script>
var maildata=[[1,"friends"],[17,"relatives"],[38,"business"]];
$("#compose-link").click(function(){
	$("#email-writer").css({top:'10px'});
});
$("#close-link").click(function(){
	$("#email-writer").css({top:'-1000px'});
});

for(var i=0;i<maildata.length;i++)
	$("#boxes-wrapper").append("<div class='box' bid='"+maildata[i][0]+"'>"+maildata[i][1]+"</div>");

$(".box").click(function(){
	xhrBoxContents(this.getAttribute("bid"));
});

function xhrBoxContents(id){
alert("getting contents for "+id);
}
</script>
</body>
</html>