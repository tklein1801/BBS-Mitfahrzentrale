<?php
define('BASEPATH', __DIR__."/");
define('CON_PATH', __DIR__."/endpoints/sql.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "assets/php/Route.php";
require_once "assets/php/Parsedown.php";
require_once "assets/php/ApiLogger.php";
require_once "endpoints/user/user.php";
require_once "endpoints/ride/ride.php";
require_once "endpoints/plz/plz.php";

use DulliAG\API\ApiLogger;
use DulliAG\API\User;
use DulliAG\API\Ride;
use DulliAG\API\PLZ;

# Global Paths
$GLOBALS['apiPath'] = "/api/";
$GLOBALS['routesPath'] = __DIR__."/routes/";
$GLOBALS['defBASEPATH'] = get_defined_constants()['BASEPATH'];

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

# Offer
Route::add("/(Angebot|Anzeige)/([0-9]*)", function ($slug, $rideId) {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "offer.php";
  } else {
    header("Location: ./Anmelden");
  }
});

# Profile
Route::add("/Profil", function () {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "profile.php";
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

Route::add("/Datenschutz", function () {
  session_start();
  require_once "routes/data.php";
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
        background: transparent url("data:image/gif;base64,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") repeat-x 0 0;
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

Route::add($GLOBALS['apiPath']."user/get", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $logger = new ApiLogger();
  $user = new User();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_GET['apiKey']) ? $_GET['apiKey'] : null);
  $logger->create($GLOBALS['apiPath']."ride/user", $GLOBALS['clientIp'], $key);
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($key)) {
    $verifyResult = $user->verifyKey($key);
    // Check if the key is valid
    if($verifyResult) {
      $userId = $verifyResult['userId'];
      $allRides = $user->get($userId);
      echo(json_encode($allRides, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-found'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "GET");

Route::add($GLOBALS['apiPath']."user/update", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $user = new User();
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."user/update", $GLOBALS['clientIp'], $key);
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($key)) {
    $verifyResult = $user->verifyKey($key);
    // Check if the key is valid
    if($verifyResult) {
      $result = $user->update($verifyResult['userId'], /*$_POST['email'],*/ $_POST['phone'], $_POST['password']);
      echo(json_encode($result, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-found'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath']."plz/placesByPlz", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."plz/placesByPlz", $GLOBALS['clientIp'], $key);
  $place = new PLZ();
  $result = $place->getPlacesByPlz($_GET['plz']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
});

Route::add($GLOBALS['apiPath']."plz/placeByPlz", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."plz/placeByPlz", $GLOBALS['clientIp'], $key);
  $place = new PLZ();
  $result = $place->getPlaceByPlz($_GET['plz']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}); 	

Route::add($GLOBALS['apiPath']."plz/plzByName", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : null;
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."plz/plzByName", $GLOBALS['clientIp'], $key);
  $place = new PLZ();
  $result = $place->getPlzByName($_GET['cityName']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}); 	

Route::add($GLOBALS['apiPath']."ride/create", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $user = new User();
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."ride/create", $GLOBALS['clientIp'], $key);
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($key)) {
    $verifyResult = $user->verifyKey($key);
    if($verifyResult) {
      $ride = new Ride();
      $result = $ride->create($verifyResult['userId'], $_POST['driver'], $_POST['title'], $_POST['information'], $_POST['price'], $_POST['seats'], $_POST['startAt'], $_POST['startPlz'], $_POST['startCity'], $_POST['startAdress'], $_POST['destinationPlz'], $_POST['destinationCity'], $_POST['destinationAdress']);
      echo(json_encode($result, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/invalid-key'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath']."ride/delete", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $user = new User();
  $logger = new ApiLogger();
  $ride = new Ride();
  $logger->create($GLOBALS['apiPath']."ride/delete", $GLOBALS['clientIp'], $key);
  $rideId = $_POST['rideId'];
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($key)) {
    $verifyResult = $user->verifyKey($key);
    // Check if the key is valid
    if($verifyResult) {
      // After we have validated the key we're gonna check if the key is bound to the user who have created the offer
      $rideInformation = $ride->get($rideId);
      // If the $rideInformation['creatorId'] is equal to $verifyResult['userId'] the user(verified by key) is the same as the offer owner
      if($rideInformation['creatorId'] == $verifyResult['userId']) {
        $result = $ride->delete($_POST['rideId']);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else {
        echo(json_encode(array('authentificated' => false, 'error' => 'auth/invalid-key'), JSON_PRETTY_PRINT));
      }
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-found'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath']."ride/all", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."ride/all", $GLOBALS['clientIp'], $key);
  $ride = new Ride();
  $allRides = $ride->getAll();
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."ride/favorites", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $logger = new ApiLogger();
  $ride = new Ride();
  $user = new User();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_GET['apiKey']) ? $_GET['apiKey'] : null);
  $logger->create($GLOBALS['apiPath']."ride/favorites", $GLOBALS['clientIp'], $key);
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($key)) {
    $verifyResult = $user->verifyKey($key);
    // Check if the key is valid
    if($verifyResult) {
      $userId = $verifyResult['userId'];
      $allRides = $ride->getFavorites($userId);
      echo(json_encode($allRides, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-found'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "GET");

Route::add($GLOBALS['apiPath']."ride/user", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $logger = new ApiLogger();
  $ride = new Ride();
  $user = new User();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_GET['apiKey']) ? $_GET['apiKey'] : null);
  $logger->create($GLOBALS['apiPath']."ride/user", $GLOBALS['clientIp'], $key);
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($key)) {
    $verifyResult = $user->verifyKey($key);
    // Check if the key is valid
    if($verifyResult) {
      $userId = $verifyResult['userId'];
      $allRides = $ride->getUserOffers($userId);
      echo(json_encode($allRides, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-found'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "GET");

Route::add($GLOBALS['apiPath']."ride/offer", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."ride/offer", $GLOBALS['clientIp'], $key);
  $ride = new Ride();
  $allRides = $ride->get($_GET['rideId']);
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."ride/offers", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."ride/offers", $GLOBALS['clientIp'], $key);
  $ride = new Ride();
  $allRides = $ride->getOffers();
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath']."ride/requests", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  $key = isset($_SESSION['login']) ? $_SESSION['login']['apiKey'] : (isset($_POST['apiKey']) ? $_POST['apiKey'] : null);
  $logger = new ApiLogger();
  $logger->create($GLOBALS['apiPath']."ride/requests", $GLOBALS['clientIp'], $key);
  $ride = new Ride();
  $allRides = $ride->getRequests();
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

# Error routes
Route::add("/404", function () {
  require_once "routes/404.php";
});

Route::add("/405", function () {
  require_once "routes/405.php";
});

Route::run("/");