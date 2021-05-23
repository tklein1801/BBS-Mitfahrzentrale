<?php
use DulliAG\API\User;
$user = new User();
$success = false;
$verifyResult = $user->verifyKey($apiKey);

if ($verifyResult['authentificated']) {
  $verifiedUserId = $verifyResult['userId'];
  $userData = $user->get($verifiedUserId);
  $emailVerified = $user->verify($userData['userId']); // Should be equal with $verifiedUserId
  if (is_null($emailVerified['error'])) {
    $success = true;
  }
} 
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
    <title>BBS-Mitfahrzentrale • E-Mail bestätigen</title>
  </head>
  <body class="err-page">
    <div class="wrapper">
      <div class="err-container">
        <img src="<?php echo $GLOBALS['settings']['logo']; ?>" />
        <h5 class="text-center">
          <?php
            if ($success) {
              echo "Deine E-Mail Adresse <br />" . $userData['email'] . "<br /> wurde bestätigt!";
            } else {
              echo "Deine E-Mail Adresse <br /> konnte nicht bestätigt werden!";
            }
          ?>
        </h5>
        <div class="btn-container">
          <a class="btn btn-outline-orange rounded-0" href="<?php echo $GLOBALS['settings']['host'] . "Anmelden"; ?>">Anmelden</a>
          <a class="btn btn-outline-orange rounded-0" href="<?php echo $GLOBALS['settings']['host'] . "Registrieren"; ?>">Registrieren</a>
        </div>
      </div>
    </div>
  </body>
</html>
 