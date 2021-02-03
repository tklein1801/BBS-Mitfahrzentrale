<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Client.php";

use Hidehalo\Nanoid\Client;

$nano = new Client();
$alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
$size = 16;

echo $nano->formattedId($alphabet , $size);