<?php
  use DulliAG\API\Ride;
  use DulliAG\API\User;
  $user = new User();
  $ride = new Ride();
  $userList = $user->getAll();
  $userCount = count($userList);
  $adminList = array_filter($userList, function ($user) {
    return $user['isAdmin'] == 1;
  });
  $adminCount = count($adminList);
  $verifiedUserList = array_filter($userList, function ($user) {
    return $user['verified'] == 1;
  });
  $verifiedUserCount = count($verifiedUserList);
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
    <title>BBS-Mitfahrzentrale • Adminbereich</title>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $GLOBALS['host'] . "assets/css/admin.css"; ?>" />
  </head>
  <body>

    <div class="wrapper">
      <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/sidebar.php"; ?>

      <main class="main">
        <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/navbar.php"; ?>

        <section class="page-content">
          <div class="page-information">
            <h2 class="mb-2">Benutzer</h2>
          </div>
          <!-- ./page-information -->

          <div class="row">
            <div class="col-12 mb-3">
              <div>
                <div class="row">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <!-- <h3 class="mb-2">Benutzer</h3> -->
                    <div class="p-3 bg-darkblue">
                      <div class="input-group search-table mb-2">
                        <input type="text" id="search-user" class="form-control" placeholder="Benutzer suchen" />
                        <button type="button" class="btn px-3" disabled>
                          <i class="fas fa-search"></i>
                        </button>
                      </div>

                      <div class="table-responsive">
                        <table class="table text-white mb-0">
                          <thead>
                            <tr>
                              <th class="text-center">ID</th>
                              <th class="text-center">Verifiziert</th>
                              <th class="text-center">Rang</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th colspan="2">Anzeigen</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                            if ($userCount > 0) {
                              foreach ($userList as $u) {
                                $userOfferList = $ride->getUserOffers($u['userId']);
                                $userOfferCount = count($userOfferList);
                                if ($userOfferCount < 10) {
                                  $userOfferCount = "0" . $userOfferCount;
                                }
  
                                if ($user->isAdmin($u['userId'])) {
                                  $badge = '<span class="badge bg-orange">Admin<span>';
                                } else {
                                  $badge = '<span class="badge bg-blue">Benutzer<span>';
                                }

                                if ($u['verified'] == 1) {
                                  $verified = '<span class="badge bg-orange">Verifiziert</span>';
                                } else {
                                  $verified = '<span class="badge bg-blue">Nicht Verifiziert</span>';
                                }
  
                                echo '<tr>
                                  <td>
                                    <p class="text-white text-center"># '.$u['userId'].'</p>
                                  </td>
                                  <td class="text-center">
                                    '.$verified.'
                                  </td>
                                  <td class="text-center">
                                    '.$badge.'
                                  </td>
                                  <td>
                                    <p class="text-white">'.$u['name'] .' '. $u['surname'].'</p>
                                  </td>
                                  <td>
                                    <a href="mailto:'.$u['email'].'">'.$u['email'].'</a>
                                  </td>
                                  <td>
                                    <a href="#" data-user="'.$u['userId'].'" data-bs-toggle="modal" data-bs-target="#user-offer-modal">Anzeigen ('.$userOfferCount.')</a>
                                  </td>
                                  <td class="d-flex justify-content-end">
                                    <button class="btn btn-outline-orange rounded-0 mr-auto px-3" data-user="'.$u['userId'].'" data-bs-toggle="modal" data-bs-target="#edit-user-modal">
                                      <i class="fas fa-user-edit"></i>
                                      Bearbeiten
                                    </button>
                                  </td>
                                </tr>';
                              }
                            } else {
                              echo '<tr>
                                <td colspan="6">
                                  <p class="text-center">Keine Benutzer gefunden</p>
                                </td>
                              </tr>';
                            }
                          ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- ./member -->

                </div>
                <!-- ./row -->
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- ./row -->
        </section>
      </main>
    </div>

    <?php 
      require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/editUserModal.php";
      require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/userOffersModal.php";
      require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/editOfferModal.php";
      require_once get_defined_constants()['BASEPATH'] . get_defined_constants()['COMPONENTS']['scripts'];
    ?>
    <script type="text/javascript" src="<?php echo $GLOBALS['settings']['host'] . "assets/js/sidebar.js" ?>"></script>    
    <script>
      document.querySelector(".sidebar #user").classList.add("active");

      var searchUserInput = document.querySelector(".wrapper section #search-user");
      searchUserInput.addEventListener("keyup", function (e) {
        let tableItems = document.querySelectorAll(".wrapper table tbody tr");
        let rowAmount = tableItems.length;
        let keyword = this.value.toLowerCase();

        if (keyword !== "" && rowAmount > 0) {
          tableItems.forEach((row) => {
            let name = row.querySelector("td:nth-child(4) > p").innerText.toLowerCase();
            let email = row.querySelector("td:nth-child(5) > a").innerText.toLowerCase();
            let match = email.includes(keyword) || name.includes(keyword);
            
            if (!match) row.classList.add("d-none");
          });
        } else {
          let hiddenRows = document.querySelectorAll(".wrapper table tbody tr.d-none");
          hiddenRows.forEach((row) => {
            row.classList.remove("d-none");
          });
        }
      });
    </script>
  </body>
</html>
