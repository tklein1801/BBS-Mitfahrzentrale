<?php
if (isset($_SESSION['login'])) {
  $userId = $_SESSION['login']['userId'];
  $isVerified = $user->isVerified($userId);
  if (!$isVerified) {
    $userData = $user->get($userId);
    $sendVerificationMail = get_defined_constants()['SETTINGS']['host'] . "api/mail/send_verify/" . $userData['apiKey'];
    echo '<div class="callout">
      <h5 class="callout-title">E-Mail bestätigen</h5>
      <p class="callout-text">
        Bevor du Anzeigen veröffentlichen kannst musst du deine E-Mail Adresse bestätigen.
        Klicke <a href="'.$sendVerificationMail.'"
        >hier</a> um dir die E-Mail erneut zukommen zu lassen.
      </p>
    </div>';
  }
}
?>