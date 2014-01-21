<h1>View Tracking Results</h1>
<?php
if(@$_REQUEST['i']){
?>

<table border=1 style='width:100%;table-layout:fixed;'>
<col width="100px" />
<col width="100px" />
<col width="100%" />

<tr><th colspan=3>Tracking Data for Tracking ID <div><?=$_REQUEST['i'];?></div></th></tr>
<tr><th>Event Name</th><th>Timestamp</th><th>Tracking Info</th></tr>
<?php
require 'db.php';
$qresult=$database->query('SELECT event, timestamp, servervars FROM tracks WHERE eid=%0%',[$_REQUEST['i']]);
if($qresult->num_rows==0)echo '<tr><td colspan=3 style="text-align:center;">No tracks yet.</td></tr>';
while($row=$qresult->fetch_assoc())
	echo "<tr><td>{$row['event']}</td><td>{$row['timestamp']}</td><td>{$row['servervars']}</td></tr>";
?>
</table>
<?php }else{ ?>
<form action='view.php' method='post'>
Enter tracking ID: <input type='text' name='i'/>
</form>
<?php }?>