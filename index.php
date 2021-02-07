<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "assets/php/Route.php";
require_once "assets/php/Parsedown.php";
require_once "assets/php/ApiLogger.php";
require_once "endpoints/user/user.php";

use DulliAG\API\ApiLogger;
use DulliAG\API\User;

# Global Paths
$GLOBALS['apiPath'] = "/api/";
$GLOBALS['routesPath'] = "C:/xampp/htdocs/routes/";


# Client variables
$GLOBALS['clientIp'] = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

# Dashboard
Route::add("/", function () {
  session_start();
  echo "Willkommen!";
  if(isset($_SESSION['login'])) {
    print_r($_SESSION['login']);
  } else {
    echo "<br /> You have to sign in first";
  }

  echo '<a href="./Anmelden">Anmelden</a> <a href="./Registrieren">Registrieren</a>';
});

# Sign in
Route::add("/Anmelden", function () {
  require_once "anmelden.html";
});

# Sign up
Route::add("/Registrieren", function () {
  require_once "registrieren.html";
});

# Official api documentation
Route::add($GLOBALS['apiPath'], function() {
  $pd = new Parsedown();
  $md = file_get_contents("assets/doc/API.md");
  echo $GLOBALS['style'];
  echo $pd->text($md);
});

# Endpoints
Route::add($GLOBALS['apiPath']."user/register", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  $user = new User();
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/register", $GLOBALS['clientIp'], null);
  $result = $user->register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'], $_POST['adress'], $_POST['plz'], $_POST['place'], $_POST['telNumber']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "POST");

Route::add($GLOBALS['apiPath']."user/checkCredentials", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  $user = new User();
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/checkCredentials", $GLOBALS['clientIp'], null);
  $result = $user->checkCredentials($_GET['email'], $_GET['password']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."user/exist", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  $user = new User();
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/exist", $GLOBALS['clientIp'], null);
  $result = $user->exist($_GET['email']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."user/destroySession", function () {
  header('Access-Control-Allow-Origin: *');
  $user = new User();
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/destroySession", $GLOBALS['clientIp'], null);
  $result = $user->destroySession($_GET['redirectTo']);
}, "GET"); // FIXME Maybe change it to POST

# Error routes

Route::run("/");