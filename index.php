<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "assets/php/Route.php";
require_once "assets/php/Parsedown.php";
# Dashboard
Route::add("/", function () {
  echo "Willkommen!";
});
Route::run("/");