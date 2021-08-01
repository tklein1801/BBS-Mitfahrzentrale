<?php
$con = new mysqli("dulliag.de", "db_thorben", "Pizza123", "bbs-mitfahrzentrale-v2");
$con->set_charset("utf8");
if($con->connect_error) {
	echo "Connection to database failed. Reason: <br>";
	echo $con->connect_error;
}
