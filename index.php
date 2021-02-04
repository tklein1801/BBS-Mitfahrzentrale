<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "assets/php/Route.php";
require_once "assets/php/Parsedown.php";
require_once "endpoints/user/user.php";

use DulliAG\API\User;

$apiPath = "/api/";
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
Route::add("/api", function() {
  $pd = new Parsedown();
  $md = file_get_contents("assets/doc/API.md");
  echo $GLOBALS['style'];
  echo $pd->text($md);
});

# Endpoints
Route::add($apiPath."user/register", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  $user = new User();
  $result = $user->register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'], $_POST['adress'], $_POST['plz'], $_POST['place'], $_POST['telNumber']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "POST");

Route::add($apiPath."user/checkCredentials", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  $user = new User();
  $result = $user->checkCredentials($_GET['email'], $_GET['password']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($apiPath."user/exist", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  $user = new User();
  $result = $user->exist($_GET['email']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($apiPath."user/destroySession", function () {
  header('Access-Control-Allow-Origin: *');
  $user = new User();
  $result = $user->destroySession($_GET['redirectTo']);
}, "GET"); // FIXME Maybe change it to POST

# Error routes

Route::run("/");