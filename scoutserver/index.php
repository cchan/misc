<h2>ScoutServer Test</h2>
<h4>Test application: chat, essentially</h4>
<?php
require "meekrodb.2.3.class.php";
DB::$user = 'php';
DB::$password = 'bgit3grnvfeirjo3ir_mjolnir';
DB::$dbName = 'scoutserver';
DB::$throw_exception_on_error = true;

session_start();

//https://stackoverflow.com/questions/4356289/php-random-string-generator
function xsrf_gen() {
	$length = 10;
	static $code = "";
	if($code == ""){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		for ($i = 0; $i < $length; $i++)
			$code .= $characters[rand(0, $charactersLength - 1)];
	}
    return $_SESSION['xsrf']=$code;
}
function xsrf_ver(){
	return array_key_exists('xsrf',$_SESSION)
		&& array_key_exists('xsrf',$_POST)
		&& hash_equals($_POST['xsrf'],$_SESSION['xsrf']);
}

if(array_key_exists('x',$_POST) && is_string($_POST['x']) && $_POST['x'] !== ''){
	if(!xsrf_ver() || DB::queryFirstField('SELECT COUNT(*) FROM test WHERE ip=%s AND timestamp > (NOW() - INTERVAL 1 MINUTE)',$_SERVER['REMOTE_ADDR']) > 10000)
		die("<div><b>Something went wrong. Try reloading.</b></div>");
	
	DB::insert('test',['ip'=>$_SERVER['REMOTE_ADDR'],'data'=>$_POST['x']]);
	echo "<div><b>Submitted.</b></div>";
}
?>
<form method="POST">
	<input id="x" name="x" aria-required="true" required>
	<input type="hidden" name="xsrf" value="<?=xsrf_gen()?>">
	<input type="submit" value="Submit">
</form>
<table border=1 cellspacing=1>
<tr><th>Timestamp<th>Data
<?php
$rows = DB::query('SELECT timestamp, ip, data FROM test ORDER BY timestamp DESC LIMIT 10');
foreach($rows as $row)
	echo "<tr><td>".$row['timestamp']."<td>".$row['data'];
?>
</table>
<script>document.getElementById('x').focus();</script>
