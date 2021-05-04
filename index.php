<?php
define('BASEPATH', __DIR__."/");
define('CON_PATH', __DIR__."/endpoints/sql.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Europe/Berlin");

// Application information
define('CURRENT_APP_VERSION', 'v0.4-pre');
define('GITHUB', array('author' => 'Thorben Klein', 'user' => 'tklein1801', 'repo' => 'BBS-Mitfahrzentrale'));

require_once "assets/php/Route.php";
require_once "assets/php/Parsedown.php";
require_once "endpoints/user/user.php";
require_once "endpoints/ride/ride.php";
// require_once "endpoints/plz/plz.php";

use DulliAG\API\User;
use DulliAG\API\Ride;
// use DulliAG\API\PLZ;

if (isset($_SERVER['HTTPS_HOST'])) {
  $host = "https://" . $_SERVER['HTTPS_HOST'] . "/";
} else {
  $host = "http://" . $_SERVER['HTTP_HOST'] . "/";
}

// Global variables
$GLOBALS['apiPath'] = "/api/";
$GLOBALS['routesPath'] = __DIR__."/routes/";
$GLOBALS['defBASEPATH'] = get_defined_constants()['BASEPATH'];
$GLOBALS['settings'] = array(
  'host' => $host,
  'logo' => $host . 'assets/img/BBS-Soltau-Logo.svg'
);

// Client variables
if (isset($_SERVER['HTTP_CLIENT_IP'])) {
  $GLOBALS['clientIp'] = $_SERVER['HTTP_CLIENT_IP'];
} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $GLOBALS['clientIp'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $GLOBALS['clientIp'] = $_SERVER['REMOTE_ADDR'];
}

// TODO Create own class for the key and the key authentification
function getApiKey() {
  $apiKey = null;

  if (isset($_SESSION['login'])) {
    $apiKey = $_SESSION['login']['apiKey'];
  } else {    
    $RequestMethod = $_SERVER['REQUEST_METHOD'];
    if ($RequestMethod === "POST") {
      if (isset($_POST['apiKey'])) {
        $apiKey = $_POST['apiKey'];
      } else {
        $apiKey = null;
      }
    } else if($RequestMethod === "GET") {
      if (isset($_GET['apiKey'])) {
        $apiKey = $_GET['apiKey'];
      } else {
        $apiKey = null;
      }
    }
  }

  return $apiKey;
}

// Redirect
Route::add("/", function () {
  session_start();
  if(isset($_SESSION['login'])) {
    header("Location: ./Anzeigen");
  } else {
    header("Location: ./Anmelden");
  }
}); 

// HTTP 404 - Path not found
Route::pathNotFound(function () {
  require_once "routes/404.php";
});

// HTTP 405 - Method now allowed
Route::methodNotAllowed(function () {
  require_once "routes/405.php";
});

// Landingpage
Route::add("/(Anzeigen|Angebote|Gesuche|Favoriten)", function ($slug) {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "offers.php";
  } else {
    header("Location: ./Anmelden");
  }
});

// Create offer
Route::add("/Erstellen", function () {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "create.php";
  } else {
    header("Location: ./Anmelden");
  }
});

// Offer
Route::add("/(Angebot|Anzeige)/([0-9]*)", function ($slug, $rideId) {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "offer.php";
  } else {
    header("Location: ./Anmelden");
  }
});

// Profile
Route::add("/Profil", function () {
  session_start();
  if(isset($_SESSION['login'])) {
    require_once $GLOBALS['routesPath'] . "profile.php";
  } else {
    header("Location: ./Anmelden");
  }
});

// Secured admin space
Route::add("/(Admin|ACP)", function () {
  session_start();
  if (isset($_SESSION['login'])) {
    $user = new User();
    $userId = $_SESSION['login']['userId'];
    $isAdmin = $user->isAdmin($userId);
    if ($isAdmin) {
      require_once $GLOBALS['routesPath'] . "admin/dashboard.php";
    } else {
      header("Location: ./Anzeigen");
    }
  } else {
    header("Location: ./Anzeigen");
  }
});

Route::add("/(Admin|ACP)/Dashboard", function () {
  session_start();
  if (isset($_SESSION['login'])) {
    $user = new User();
    $userId = $_SESSION['login']['userId'];
    $isAdmin = $user->isAdmin($userId);
    if ($isAdmin) {
      require_once $GLOBALS['routesPath'] . "admin/dashboard.php";
    } else {
      header("Location: ./Anzeigen");
    }
  } else {
    header("Location: ./Anzeigen");
  }
});

Route::add("/(Admin|ACP)/Benutzer", function () {
  session_start();
  if (isset($_SESSION['login'])) {
    $user = new User();
    $userId = $_SESSION['login']['userId'];
    $isAdmin = $user->isAdmin($userId);
    if ($isAdmin) {
      require_once $GLOBALS['routesPath'] . "admin/user.php";
    } else {
      header("Location: ./Anzeigen");
    }
  } else {
    header("Location: ./Anzeigen");
  }
});

Route::add("/(Admin|ACP)/Anzeigen", function () {
  session_start();
  if (isset($_SESSION['login'])) {
    $user = new User();
    $userId = $_SESSION['login']['userId'];
    $isAdmin = $user->isAdmin($userId);
    if ($isAdmin) {
      require_once $GLOBALS['routesPath'] . "admin/offer.php";
    } else {
      header("Location: ./Anzeigen");
    }
  } else {
    header("Location: ./Anzeigen");
  }
});

Route::add("/(Admin|ACP)/Logs", function () {
  session_start();
  if (isset($_SESSION['login'])) {
    $user = new User();
    $userId = $_SESSION['login']['userId'];
    $isAdmin = $user->isAdmin($userId);
    if ($isAdmin) {
      require_once $GLOBALS['routesPath'] . "admin/logs.php";
    } else {
      header("Location: ./Anzeigen");
    }
  } else {
    header("Location: ./Anzeigen");
  }
});

// Sign in
Route::add("/Anmelden", function () {
  require_once "routes/sign-in.php";
});

// Sign up
Route::add("/Registrieren", function () {
  require_once "routes/sign-up.php";
});

Route::add("/Datenschutz", function () {
  session_start();
  require_once "routes/data.php";
});

// Official api documentation
Route::add("(/(api/|api))", function() {
  echo '<link rel="stylesheet" href="'.$GLOBALS['host'].'assets/css/markdown.css" />';
  $pd = new Parsedown();
  $md = file_get_contents("assets/doc/API.md");
  echo $pd->text($md);
});

// Avaiable endpoints
/**
 * User
 */
Route::add($GLOBALS['apiPath'] . "user/register", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $apiKey = getApiKey();
  $user = new User();
  $result = $user->register($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password'], $_POST['telNumber']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "POST");

// Route::add($GLOBALS['apiPath'] . "user/verify/([a-zA-Z0-9]{0,16}$)", function ($apiKey) {
//   header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json; charset=utf-8');
//   $logger = new ApiLogger();
//   $logger->create($GLOBALS['apiPath'] . "user/verify/".$apiKey, $GLOBALS['clientIp'], $apiKey);
  
//   $user = new User();
//   $verifyResult = $user->verifyKey($apiKey);
//   if($verifyResult['authentificated'] == true) {
//     $userData = $user->get($verifyResult['userId']);
//     echo "Deine E-Mail <strong>".$userData['email']."</strong> wurde bestätigt!";
//     echo(json_encode($user->verify($verifyResult['userId'], JSON_PRETTY_PRINT)));
//   } else {
//     echo "<h1>Der Link ist ungültig!</h1>";
//   }
// }, "GET");

Route::add($GLOBALS['apiPath'] . "user/checkCredentials", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $result = $user->checkCredentials($_GET['email'], $_GET['password']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath'] . "user/exist", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $result = $user->exist($_GET['email']);
  echo(json_encode($result, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath'] . "user/destroySession", function () {
  header('Access-Control-Allow-Origin: *');
  session_start();

  $user = new User();
  $user->destroySession($_GET['redirectTo']);
}, "GET"); // FIXME Maybe change it to POST

Route::add($GLOBALS['apiPath'] . "user/get", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $apiKey = getApiKey();

  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    // Check if the key is valid
    if($verifyResult['authentificated'] == true) {
      $userId = $verifyResult['userId'];
      $allRides = $user->get($userId);
      echo(json_encode($allRides, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "user/update", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $apiKey = getApiKey();
  $user = new User();

  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    $verifiedUserId = $verifyResult['userId'];
    // Check if the key is valid
    if($verifyResult['authentificated']) {
      $currentUserData = $user->get($verifiedUserId);
      $result = $user->update($verifiedUserId, $currentUserData['verified'], $currentUserData['isAdmin'], $currentUserData['name'], $currentUserData['surname'], $currentUserData['email'], $_POST['phone'], $_POST['password']);
      echo(json_encode($result, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

/**
 * Admin
 */
Route::add($GLOBALS['apiPath'] . "admin/user/get", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $apiKey = getApiKey();  

  if (!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    if ($verifyResult['authentificated']) {
      $verifiedUserId = $verifyResult['userId'];
      $userIsAdmin = $user->isAdmin($verifiedUserId);
      if ($userIsAdmin) {
        $userData = $user->get($_POST['userId']);
        echo(json_encode($userData, JSON_PRETTY_PRINT));
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'auth/not-an-admin'), JSON_PRETTY_PRINT));
      }
    } else {  
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "admin/user/update", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $apiKey = getApiKey();

  if (!is_null($apiKey)) {
    $verifyResult= $user->verifyKey($apiKey);
    if ($verifyResult['authentificated']) {
      $verifiedUserId = $verifyResult['userId'];
      if ($user->isAdmin($verifiedUserId)) {
        $result = $user->update($_POST['userId'], $_POST['admin'], $_POST['verified'], $_POST['name'], $_POST['surname'], $_POST['email'], $_POST['phone'], $_POST['password']);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'auth/not-an-admin'), JSON_PRETTY_PRINT));
      }
    } else {  
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "admin/ride/user", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $ride = new Ride();
  $apiKey = getApiKey();

  if (!is_null($apiKey)) {
    $verifyResult= $user->verifyKey($apiKey);
    if ($verifyResult['authentificated']) {
      $verifiedUserId = $verifyResult['userId'];
      if ($user->isAdmin($verifiedUserId)) {
        $result = $ride->getUserOffers($_POST['userId']);
        echo(json_encode($result, JSON_PRETTY_PRINT));        
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'auth/not-an-admin'), JSON_PRETTY_PRINT));
      }
    } else {  
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "admin/ride/all", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $ride = new Ride();
  $apiKey = getApiKey();

  if (!is_null($apiKey)) {
    $verifyResult= $user->verifyKey($apiKey);
    if ($verifyResult['authentificated']) {
      $verifiedUserId = $verifyResult['userId'];
      if ($user->isAdmin($verifiedUserId)) {
        $result = $ride->getAllStored();
        echo(json_encode($result, JSON_PRETTY_PRINT));        
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'auth/not-an-admin'), JSON_PRETTY_PRINT));
      }
    } else {  
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "admin/ride/offer", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $ride = new Ride();
  $apiKey = getApiKey();  

  if (!is_null($apiKey)) {
    $verifyResult= $user->verifyKey($apiKey);
    if ($verifyResult['authentificated']) {
      $verifiedUserId = $verifyResult['userId'];
      if ($user->isAdmin($verifiedUserId)) {
        $result = $ride->get($_POST['rideId']);
        echo(json_encode($result, JSON_PRETTY_PRINT));        
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'auth/not-an-admin'), JSON_PRETTY_PRINT));
      }
    } else {  
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "admin/ride/update", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $ride = new Ride();
  $apiKey = getApiKey();

  if (!is_null($apiKey)) {
    $verifyResult= $user->verifyKey($apiKey);
    if ($verifyResult['authentificated']) {
      $verifiedUserId = $verifyResult['userId'];
      if ($user->isAdmin($verifiedUserId)) {
        $result = $ride->update($_POST['rideId'], $_POST['title'], $_POST['information'], $_POST['price'], $_POST['seats'], $_POST['startAt'], $_POST['startPlz'], $_POST['startCity'], $_POST['startAdress'], $_POST['destinationPlz'], $_POST['destinationCity'], $_POST['destinationAdress']);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'auth/not-an-admin'), JSON_PRETTY_PRINT));
      }
    } else {  
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

/**
 * Places
 */
// Route::add($GLOBALS['apiPath'] . "plz/placesByPlz", function () {
//   header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json; charset=utf-8');
//   session_start();
  
//   $apiKey = getApiKey();
//   $place = new PLZ();
//   $result = $place->getPlacesByPlz($_GET['plz']);
//   echo(json_encode($result, JSON_PRETTY_PRINT));
// });

// Route::add($GLOBALS['apiPath'] . "plz/placeByPlz", function () {
//   header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json; charset=utf-8');
//   session_start();
  
//   $apiKey = getApiKey();
//   $place = new PLZ();
//   $result = $place->getPlaceByPlz($_GET['plz']);
//   echo(json_encode($result, JSON_PRETTY_PRINT));
// });

// Route::add($GLOBALS['apiPath'] . "plz/plzByName", function () {
//   header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json; charset=utf-8');
//   session_start();

//   $apiKey = getApiKey();
//   $place = new PLZ();
//   $result = $place->getPlzByName($_GET['cityName']);
//   echo(json_encode($result, JSON_PRETTY_PRINT));
// });

/**
 * Ride
 */
Route::add($GLOBALS['apiPath'] . "ride/create", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();
  
  $user = new User();
  $ride = new Ride();
  $apiKey = getApiKey();

  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    if($verifyResult) {
      $result = $ride->create($verifyResult['userId'], $_POST['driver'], $_POST['title'], $_POST['information'], $_POST['price'], $_POST['seats'], $_POST['startAt'], $_POST['startPlz'], $_POST['startCity'], $_POST['startAdress'], $_POST['destinationPlz'], $_POST['destinationCity'], $_POST['destinationAdress']);
      echo(json_encode($result, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "ride/update", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $apiKey = getApiKey();
  $user = new User();
  $ride = new Ride();

  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    $verifiedUserId = $verifyResult['userId'];
    $userIsAdmin = $user->isAdmin($verifiedUserId);
    if($verifyResult['authentificated']) {
      $ride = new Ride();
      $requestedRide = $_POST['rideId'];
      $rideData = $ride->get($requestedRide);

      if ($user->isAdmin($verifiedUserId)) {
        $currentOfferData = $ride->get($_POST['rideId']);
        $result = $ride->update($_POST['rideId'], $currentOfferData['title'], $_POST['information'], $_POST['price'], $_POST['seats'], $_POST['startAt'], $_POST['startPlz'], $_POST['startCity'], $_POST['startAdress'], $_POST['destinationPlz'], $_POST['destinationCity'], $_POST['destinationAdress']);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else if ($rideData['creatorId'] == $verifiedUserId) {
        $currentOfferData = $ride->get($_POST['rideId']);
        $result = $ride->update($_POST['rideId'], $currentOfferData['title'], $_POST['information'], $_POST['price'], $_POST['seats'], $_POST['startAt'], $_POST['startPlz'], $_POST['startCity'], $_POST['startAdress'], $_POST['destinationPlz'], $_POST['destinationCity'], $_POST['destinationAdress']);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else {
        echo(json_encode(array('authentificated' => true, 'error' => 'ride/not-the-creator'), JSON_PRETTY_PRINT));
      }
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "ride/delete", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $user = new User();
  $ride = new Ride();
  $apiKey = getApiKey();
  
  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    $verifiedUserId = $verifyResult['userId'];
    $userIsAdmin = $user->isAdmin($verifiedUserId);
    // Check if the key is valid
    if($verifyResult) {
      // After we have validated the key we're gonna check if the key is bound to the user who have created the offer
      $rideId = $_POST['rideId'];
      $rideInformation = $ride->get($rideId);
      // If the $rideInformation['creatorId'] is equal to $verifiedUserId the user(verified by key) is the same as the offer owner
      // If the user isn't the creator we're gonna check if the user is an admin which is capable to delete rides
      if ($userIsAdmin) {
        $result = $ride->delete($rideId);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else if ($rideInformation['creatorId'] == $verifiedUserId) {
        $result = $ride->delete($rideId);
        echo(json_encode($result, JSON_PRETTY_PRINT));
      } else {
        echo(json_encode(array('authentificated' => false, 'error' => 'ride/not-the-creator'), JSON_PRETTY_PRINT));
      }
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "POST");

Route::add($GLOBALS['apiPath'] . "ride/all", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $ride = new Ride();
  $allRides = $ride->getAll();
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

// Route::add($GLOBALS['apiPath'] . "ride/favorites", function () {
//   header('Access-Control-Allow-Origin: *');
//   header('Content-Type: application/json; charset=utf-8');
//   session_start();

//   $ride = new Ride();
//   $user = new User();
//   $apiKey = getApiKey();

//   // Check if the key is set
//   // If no key was set the value equals null
//   if(!is_null($apiKey)) {
//     $verifyResult = $user->verifyKey($apiKey);
//     // Check if the key is valid
//     if($verifyResult) {
//       $userId = $verifyResult['userId'];
//       $allRides = $ride->getFavorites($userId);
//       echo(json_encode($allRides, JSON_PRETTY_PRINT));
//     } else {
//       echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
//     }
//   } else {
//     echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
//   }
// }, "GET");

Route::add($GLOBALS['apiPath'] . "ride/user", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $ride = new Ride();
  $user = new User();
  $apiKey = getApiKey();

  // Check if the key is set
  // If no key was set the value equals null
  if(!is_null($apiKey)) {
    $verifyResult = $user->verifyKey($apiKey);
    // Check if the key is valid
    if($verifyResult) {
      $userId = $verifyResult['userId'];
      $allRides = $ride->getUserOffers($userId);
      echo(json_encode($allRides, JSON_PRETTY_PRINT));
    } else {
      echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-invalid'), JSON_PRETTY_PRINT));
    }
  } else {
    echo(json_encode(array('authentificated' => false, 'error' => 'auth/key-not-set'), JSON_PRETTY_PRINT));
  }
}, "GET");

Route::add($GLOBALS['apiPath'] . "ride/offer", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $ride = new Ride();
  $allRides = $ride->get($_GET['rideId']);
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath'] . "ride/offers", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $ride = new Ride();
  $allRides = $ride->getOffers();
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

Route::add($GLOBALS['apiPath'] . "ride/requests", function () {
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json; charset=utf-8');
  session_start();

  $ride = new Ride();
  $allRides = $ride->getRequests();
  echo(json_encode($allRides, JSON_PRETTY_PRINT));
}, "GET");

Route::run("/");