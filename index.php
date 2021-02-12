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

# Redirect
Route::add("/", function () {
  session_start();
  if(isset($_SESSION['login'])) {
    header("Location: ./Anzeigen");
  } else {
    header("Location: ./Anmelden");
  }
}); 

# Landingpage
Route::add("/(Anzeigen|Angebote|Gesuche|Favoriten)", function ($slug) {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "offers.php";
  } else {
    header("Location: ./Anmelden");
  }
});

# Create offer
Route::add("/Erstellen", function () {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "create.php";
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
Route::add("(/(api/|api))", function() {
  echo '
    <style>
      html, body {
        padding: 20px;
        background: #222;
        color: #ddd;
        font-family: monospace;
        font-size: 1.1rem;
      }
      .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        flex-direction: column;
        width: 100%;
        height: 100%;
      }
      a.link {
        transition: 250ms;
        padding: 1rem 1.5rem;
        text-decoration: none;
        font-weight: bolder;
        font-size: 1.2rem;
        background-color: transparent;
        border: 2px solid #ddd;
        color: #ddd;
      }
      a.link:hover {
        background-color: #fff;
        border-color: #fff;
        color: #222;
      }
      pre {
        margin-bottom: 10px;
        padding: 10px;
        background: #333;
        border: 1px solid #333;
        color: #555;
        border-radius: 3px;
      }
      pre code {
        padding: 0;
        border: none;
        background: none;
        color: #fff;
        font-family: monospace;
        white-space: pre-wrap;
      }
      hr {
        height: 4px;
        margin: 15px 0;
        padding: 0;
        background: transparent url("data:image/gif;base64,R0lGODdhBgAEAJEAAAAAAP///wAAAAAAACH5BAkAAAIAIf8LSUNDUkdCRzEwMTL/AAAHqGFwcGwCIAAAbW50clJHQiBYWVogB9kAAgAZAAsAGgALYWNzcEFQUEwAAAAAYXBwbAAAAAAAAAAAAAAAAAAAAAAAAPbWAAEAAAAA0y1hcHBsAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALZGVzYwAAAQgAAABvZHNjbQAAAXgAAAVsY3BydAAABuQAAAA4d3RwdAAABxwAAAAUclhZWgAABzAAAAAUZ1hZWgAAB0QAAAAUYlhZWgAAB1gAAAAUclRSQwAAB2wAAAAOY2hhZAAAB3wAAAAsYlRSQwAAB2wAAAAOZ1RS/0MAAAdsAAAADmRlc2MAAAAAAAAAFEdlbmVyaWMgUkdCIFByb2ZpbGUAAAAAAAAAAAAAABRHZW5lcmljIFJHQiBQcm9maWxlAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABtbHVjAAAAAAAAAB4AAAAMc2tTSwAAACgAAAF4aHJIUgAAACgAAAGgY2FFUwAAACQAAAHIcHRCUgAAACYAAAHsdWtVQQAAACoAAAISZnJGVQAAACgAAAI8emhUVwAAABYAAAJkaXRJVAAAACgAAAJ6bmJOTwAAACYAAAKia29LUgAAABYAAP8CyGNzQ1oAAAAiAAAC3mhlSUwAAAAeAAADAGRlREUAAAAsAAADHmh1SFUAAAAoAAADSnN2U0UAAAAmAAAConpoQ04AAAAWAAADcmphSlAAAAAaAAADiHJvUk8AAAAkAAADomVsR1IAAAAiAAADxnB0UE8AAAAmAAAD6G5sTkwAAAAoAAAEDmVzRVMAAAAmAAAD6HRoVEgAAAAkAAAENnRyVFIAAAAiAAAEWmZpRkkAAAAoAAAEfHBsUEwAAAAsAAAEpHJ1UlUAAAAiAAAE0GFyRUcAAAAmAAAE8mVuVVMAAAAmAAAFGGRhREsAAAAuAAAFPgBWAWEAZQBvAGIAZQD/YwBuAP0AIABSAEcAQgAgAHAAcgBvAGYAaQBsAEcAZQBuAGUAcgBpAQ0AawBpACAAUgBHAEIAIABwAHIAbwBmAGkAbABQAGUAcgBmAGkAbAAgAFIARwBCACAAZwBlAG4A6AByAGkAYwBQAGUAcgBmAGkAbAAgAFIARwBCACAARwBlAG4A6QByAGkAYwBvBBcEMAQzBDAEOwRMBD0EOAQ5ACAEPwRABD4ERAQwBDkEOwAgAFIARwBCAFAAcgBvAGYAaQBsACAAZwDpAG4A6QByAGkAcQB1AGUAIABSAFYAQpAadSgAIABSAEcAQgAggnJfaWPPj/AAUAByAG8AZgBp/wBsAG8AIABSAEcAQgAgAGcAZQBuAGUAcgBpAGMAbwBHAGUAbgBlAHIAaQBzAGsAIABSAEcAQgAtAHAAcgBvAGYAaQBsx3y8GAAgAFIARwBCACDVBLhc0wzHfABPAGIAZQBjAG4A/QAgAFIARwBCACAAcAByAG8AZgBpAGwF5AXoBdUF5AXZBdwAIABSAEcAQgAgBdsF3AXcBdkAQQBsAGwAZwBlAG0AZQBpAG4AZQBzACAAUgBHAEIALQBQAHIAbwBmAGkAbADBAGwAdABhAGwA4QBuAG8AcwAgAFIARwBCACAAcAByAG8AZgBpAGxmbpAaACAAUgBHAEIAIGPPj//wZYdO9k4AgiwAIABSAEcAQgAgMNcw7TDVMKEwpDDrAFAAcgBvAGYAaQBsACAAUgBHAEIAIABnAGUAbgBlAHIAaQBjA5MDtQO9A7kDugPMACADwAPBA78DxgOvA7sAIABSAEcAQgBQAGUAcgBmAGkAbAAgAFIARwBCACAAZwBlAG4A6QByAGkAYwBvAEEAbABnAGUAbQBlAGUAbgAgAFIARwBCAC0AcAByAG8AZgBpAGUAbA5CDhsOIw5EDh8OJQ5MACAAUgBHAEIAIA4XDjEOSA4nDkQOGwBHAGUAbgBlAGwAIABSAEcAQgAgAFAAcgBvAGYAaQBsAGkAWQBsAGX/AGkAbgBlAG4AIABSAEcAQgAtAHAAcgBvAGYAaQBpAGwAaQBVAG4AaQB3AGUAcgBzAGEAbABuAHkAIABwAHIAbwBmAGkAbAAgAFIARwBCBB4EMQRJBDgEOQAgBD8EQAQ+BEQEOAQ7BEwAIABSAEcAQgZFBkQGQQAgBioGOQYxBkoGQQAgAFIARwBCACAGJwZEBjkGJwZFAEcAZQBuAGUAcgBpAGMAIABSAEcAQgAgAFAAcgBvAGYAaQBsAGUARwBlAG4AZQByAGUAbAAgAFIARwBCAC0AYgBlAHMAawByAGkAdgBlAGwAcwBldGV4dAAAAABDb3B5cmlnaHQgMjAwrzcgQXBwbGUgSW5jLiwgYWxsIHJpZ2h0cyByZXNlcnZlZC4AWFlaIAAAAAAAAPNSAAEAAAABFs9YWVogAAAAAAAAdE0AAD3uAAAD0FhZWiAAAAAAAABadQAArHMAABc0WFlaIAAAAAAAACgaAAAVnwAAuDZjdXJ2AAAAAAAAAAEBzQAAc2YzMgAAAAAAAQxCAAAF3v//8yYAAAeSAAD9kf//+6L///2jAAAD3AAAwGwALAAAAAAGAAQAAAIHlIOXgqFuCgA7") repeat-x 0 0;
        border: 0 none;
        color: #ccc;
      }
    </style>';
  $pd = new Parsedown();
  $md = file_get_contents("assets/doc/API.md");
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