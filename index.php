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
  // require_once $GLOBALS['routesPath'] . "offers.php";
  // Check if the user is signed in
  if(isset($_SESSION['login'])) {
    // print_r($_SESSION['login']);
    require_once $GLOBALS['routesPath'] . "offers.php";
    // require_once "index.html";
  } else {
    header("Location: ./Anmelden");
  }
});

# Sign in
Route::add("/Anmelden", function () {
  require_once "routes/sign-in.php";
});

# Sign up
Route::add("/Registrieren", function () {
  require_once "routes/sign-up.php";
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
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/register", $GLOBALS['clientIp'], $key);
  $user = new User();
  $result = $user->register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'], $_POST['adress'], $_POST['plz'], $_POST['place'], $_POST['telNumber']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "POST");

Route::add($GLOBALS['apiPath']."user/checkCredentials", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/checkCredentials", $GLOBALS['clientIp'], $key);
  $user = new User();
  $result = $user->checkCredentials($_GET['email'], $_GET['password']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."user/exist", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/exist", $GLOBALS['clientIp'], $key);
  $user = new User();
  $result = $user->exist($_GET['email']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."user/destroySession", function () {
  header('Access-Control-Allow-Origin: *');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/destroySession", $GLOBALS['clientIp'], $key);
  $user = new User();
  $result = $user->destroySession($_GET['redirectTo']);
}, "GET"); // FIXME Maybe change it to POST

# Error routes

Route::run("/");