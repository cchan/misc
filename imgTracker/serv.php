<?php
//This page needs speed. And secure all those random $_SERVER vars - it's GIVING THEM MY PATH VARIABLE.
if(@$_REQUEST['i']){
require 'db.php';
$qresult=$database->query('SELECT event FROM trackables WHERE eid=%0%',[$_REQUEST['i']]);
if($qresult->num_rows==0){
	echo "Not Found.";
	header('HTTP/1.0 404 Not Found');
	die();
}
$row=$qresult->fetch_assoc();

$database->query('INSERT INTO tracks (eid, event, servervars) VALUES (%0%,%1%,%2%)',
	[$_REQUEST['i'],$row['event'],JSON_encode($_SERVER)]);
header('Content-type: image/png');
readfile('pixel.png');
}
else{
echo "Page Not Found.";
header('HTTP/1.0 404 Not Found');
die();
}
?>