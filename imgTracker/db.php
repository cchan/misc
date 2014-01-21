<?php
function error($err){
echo "Error: ".$err;
die();
}
$DB_DOMAIN="localhost";$DB_UNAME="root";$DB_PASSW="";$DB_DB="tracker";require "class.DB.php";$database=new DB;
?>