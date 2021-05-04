<nav class="navbar sticky-top">
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
        <i class="far fa-user"></i> Mein Profil
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