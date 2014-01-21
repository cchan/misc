<?php
/*
 * LMT/Backstage/Upgrade_Year.php
 * LHS Math Club Website
 *
 * Super-secret page. Upgrades everything across the LMT thing to the next year.
 * Presents a fun code-reading challenge to the webmaster, from my (the website's) point of view,
 * proving that programming can actually be fun.
 *
 * NOT TO BE MODIFIED except with full knowledge of what the code *does*.
 */

 
 
 

/*
Hello, welcome to the LMT Year Upgrader! I'm the LHSMATH.org website, and I'm here to solve your problems with this page!

This is a utility meant to make everything in the process of upgrading the LMT year as easy and consistent as pie!
However, I can't make it *too* easy for you. Continue reading.
Since the year-upgrade is such a complicated business, and quite undoable once done,
I've decided that you'll go on a short, fun adventure to make it work.

Note that *modifying* code in this file is not allowed. Why not? The code self-verifies. :)
[It shouldn't ever need editing unless you overhaul the LMT website,
but deep apologies to anyone who needs to if it does. Contact an old webmaster if necessary.]

Don't worry, you'll have fun doing it! If all else fails, ask a former webmaster, who's probably had to do it themselves.

With love,
The LHSMATH.org website
*/








//Standard stuff.
$path_to_lmt_root = '../';
require_once $path_to_lmt_root . '../lib/lmt-functions.php';
restrict_access('A');


if(@$_GET['step1']=='asdf')step1();
else landing();


//Page: landing
function landing(){
lmt_page_header('Upgrade Year');?>
<button onclick="alert('Hi there, webmaster! For security reasons, you will have to look at the code for this page to make it work.');this.disabled=true;">Upgrade Year</button>
<?php lmt_backstage_footer('Upgrade Year');
}

//Page: DB LOGIN
function step1(){
?>
Unfortunately, the upgrade requires some database renaming,
which means you need to enter your database username and password
(same as in PHPMyAdmin).
<form method="step2.php" action="POST">
Username: <input type="text"/><br>
Password: <input text="type"/><br>
Oops, I don't know my HTML... fix up this form for me in your browser code-editing window.
It's F12 on most browsers. Or right click and "Inspect HTML" or something.
</form>
<?php
file_put_contents('step2.php',<<<'NOWDOC'
<?php
//If you see this file, delete it immediately. It's supposed to be temporary.

$path_to_lmt_root = '../';
require_once $path_to_lmt_root . '../lib/lmt-functions.php';
restrict_access('A');

var_dump($_POST);
if(@$_POST['uname']&&@$_POST['passw']){
$_SESSION['upgrade_uname']=$_POST['uname'];
$_SESSION['upgrade_passw']=$_POST['passw'];
?>
Excellent, you fixed my code! Oh, and by the way, what years are you upgrading from and to?
<?php
file_put_contents('step3.php',<<<'NOWDOC2'
<?php
//If you see this file, delete it immediately. It's supposed to be temporary.

$path_to_lmt_root = '../';
require_once $path_to_lmt_root . '../lib/lmt-functions.php';
restrict_access('A');
if(file_exists('upgrade_from')&&file_exists('upgrade_to')){
$DB_USERNAME=htmlentities($_SESSION['upgrade_uname']);
$DB_PASSWORD=htmlentities($_SESSION['upgrade_passw']);
connect_to_lmt_database();
$yearfrom=int(file_get_contents('upgrade_from'));
$yearto=int(file_get_contents('upgrade_to'));
echo "Okay tada you've done it! $DB_USERNAME $DB_PASSWORD $yearfrom $yearto";
}
?>
NOWDOC2
);
}
else{
die('Nope, that did not work.');
}
?>

NOWDOC
);
}




//A list of encrypted things.
$e1='long_encypted_goes_here_yah_mhm';
$e2='long_encrypted_goes_here_yah_mhm';
$e3='long_encrypted_goes_here_yah_mhm';


//Page: DO IT
function archive_lmt_db($db1){
	$thenfile='auth_archive_past_year';//Contains the past year we want to upgrade from.
	$nowfile='auth_archive_current_year';//Contains the current year we want to upgrade to.
	
	//Decrypts queries and interface info with hashes of certain substrs of file_get_contents :P
	//Constructs it step by step in a temporary file.
	$h=hash('SHA256',substr(file_get_contents('Upgrade_Year.php'),-1000));
	
	if(file_exists('auth_upgrade_year.lmt'))
		$s=file_get_contents("auth_upgrade_year.lmt");

	lmt_query("CREATE DATABASE  `lmt-".$year."` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci");
	//errors when stuff doesn't exist.

	foreach($tables as $table)
	query("RENAME TABLE  `lmt-2014`.`table` TO  `db-copy-test`.`table`");

	//DROP DATABASE  `lmt-2014` ;
}



?>
