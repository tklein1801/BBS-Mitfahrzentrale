<!-- Navbar -->
<nav class="navbar main-navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img
        class="d-inline-block align-top"
        src="<?php echo $url . "assets/img/BBS-Soltau-Logo.svg"; ?>"
        alt="BBS Logo"
      />
    </a>
    <button
      type="button"
      class="navbar-toggler border-0"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNav" class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="<?php echo $url . "Anzeigen"; ?>" class="nav-link text-white">Anzeigen</a>
        </li>
        <?php
          if (isset($_SESSION['login']) && $_SESSION['login']['isAdmin']) {
            echo '<li class="nav-item">
              <a href="' .$url . 'Admin" class="nav-link text-white">Adminbereich</a>
            </li>';
          }
        ?>
        <li class="nav-item">
          <a href="https://bbssoltau.de" class="nav-link text-white">BBS Soltau</a>
        </li>
        <?php
          if(isset($_SESSION['login'])) {
            echo '<div class="btn-group">
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
                    <a class="dropdown-item" href="'.$url.'Profil">
                      <i class="far fa-address-book"></i> Meine Anzeigen
                    </a>
                  </li>
                  <!-- <li>
                    <a class="dropdown-item" href="'.$url.'Anzeigen">
                      <i class="far fa-star"></i> Favoriten
                    </a>
                  </li> -->
                  <li>
                    <button id="signOut" class="dropdown-item" type="button">
                      <i class="fas fa-sign-out-alt"></i> Abmelden
                    </button>
                  </li>
                </ul>
              </div>';
          } else {
            echo '<li class="nav-item">
                <a href="../Anmelden" class="nav-link btn btn-outline-orange rounded-0 px-3">
                  <i class="far fa-user-circle"></i>
                  Anmelden
                </a>
              </li>'; 
          }
        ?>
      </ul>
    </div>
    <!-- ./Navbar-Collapse -->
  </div>
  <!-- ./Container-Fluid -->
</nav>
<!-- ./Navbar -->