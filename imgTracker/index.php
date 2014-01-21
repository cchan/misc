<h1>Tracker Creator</h1>
<?php
echo '<pre>';var_dump($_SERVER,getallheaders());echo '</pre>';//plus $_SERVER: REMOTE_ADDR REMOTE_PORT REQUEST_METHOD REQUEST_URI REQUEST_TIME_FLOAT REQUEST_TIME
if(@$_POST['event']){
	require 'db.php';
	$id=hash('SHA256',$_SERVER['SERVER_ADDR'].$_SERVER['REMOTE_ADDR'].uniqid(mt_rand(),true));
	
	$database->query("INSERT INTO trackables (eid,event) VALUES (%0%,%1%)",[$id,$_POST["event"]]);
	
	$path='http://'.$_SERVER['HTTP_HOST'];
	$path.=substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1);
	$servlink=$path.'serv.php?i='.$id;
	$viewlink=$path.'view.php?i='.$id;
?>
Created.<br>
Tracking-Image Link: <a href='<?=$servlink;?>'><?=$servlink;?></a><br>
View Tracking Results: <a href='<?=$viewlink;?>'><?=$viewlink;?></a><br>
Tracking ID: <?=$id;?>
<?php
}
else{
?>
<form action='index.php' method='post'>
	Event Name <input type='text' name='event'/><br>
	<button>Get tracking link</button>
</form>
<?php }?>