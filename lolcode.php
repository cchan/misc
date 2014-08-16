I am planning on developing a website in LOLCODE.

<?php
//Is there some way to direct Apache to this script whenever it finds a *.lol file?
//(more generally how do I do this for any nonstandard language?)

$_SERVER["LOLCODE_STRING"];

//some interpreting goes on here

?>


<?php
//Or, probably something more useful:
$P=new Page();
$P->useTemplate("template.html")
$F=new Form();
$F->add("email","email")->add("pass","password")->add("confpass","password");//will auto-validate email and presence of password.
$F->submitFunc(function($items,$valid){//Given this callback, it checks if "submitted" is in $_POST and also checks CSRF, then calls callback if so.
	if(!$valid)return false;//prechecked items like "email", and for blankness.
	if($items["password"]==$items["confpass"]){
		$U=new User();
		$U->create($items["email"],$items["password"]);
		return true;//um
	}
});
$P->add($F);
$P->display();

$D=new Data();
$D->getRowById("questions","");


//ew. At some point I should just get an outside library.
?>

