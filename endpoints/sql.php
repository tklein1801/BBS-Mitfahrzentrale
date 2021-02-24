<?php
$con = new mysqli("HOST", "USERNAME", "PASSWORD", "bbs-mitfahrzentrale");
$con->set_charset("utf8");
if($con->connect_error) {
	echo "Connection to database failed. Reason: <br>";
	echo $con->connect_error;
}
