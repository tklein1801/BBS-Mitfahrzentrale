<?php
use DulliAG\API\User;
$user = new User();
?>
<nav class="navbar admin-navbar">
  <button type="button" class="navbar-toggler hamburger border-0">
    <span class="navbar-toggler-icon"></span></button
  ><!-- ./hamburger-->

  <div>
    <a
      href="<?php echo $GLOBALS['settings']['host'] . "Anzeigen"; ?>"
      class="btn btn-outline-orange rounded-0"
    >
      Anzeigen
    </a>
    <div class="btn-group">
      <button
        type="button"
        id="profile-dropdown"
        class="btn btn-outline-orange dropdown-toggle rounded-0"
        data-bs-toggle="dropdown"
      >
        <?php
          $userData = $user->get($_SESSION['login']['userId']);
          $avatarUrl = $user->getAvatarUrl($userData['name']);
          echo '<img class="profile-avatar" src="'.$avatarUrl.'" alt="Avatar url" />';
        ?>
        Mein Profil
      </button>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
        <li>
          <a class="dropdown-item" href="<?php echo $GLOBALS['settings']['host'] . "Profil"; ?>">
            <i class="far fa-address-book"></i> Meine Anzeigen
          </a>
        </li>
        <li>
          <button id="signOut" class="dropdown-item" type="button">
            <i class="fas fa-sign-out-alt"></i> Abmelden
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>