<?php

if(!array_key_exists('sitename',$_POST) || !ctype_alnum($_POST['sitename'])){
	
	if(array_key_exists('sitename',$_POST))$error = "Error: Site name must be alphanumeric.";
?>
<b><?=$error?></b>
<form method="POST">
	Site Name (alphanumeric): <input type="text" name="sitename" />
	<input type="submit" />
</form>
<?php
}







if (!is_dir('upload/promotions/' . $month)) {
  // dir doesn't exist, make it
  mkdir('upload/promotions/' . $month);
}

file_put_contents('upload/promotions/' . $month . '/' . $image, $contents_data);

?>

