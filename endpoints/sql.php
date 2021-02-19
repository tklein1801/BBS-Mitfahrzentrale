<?php
$con = new mysqli("185.223.31.112", "db_thorben", "Litza123", "bbs-mitfahrzentrale-v2");
$con->set_charset("utf8");
if($con->connect_error) {
	echo "Connection to database failed. Reason: <br>";
	echo $con->connect_error;
}