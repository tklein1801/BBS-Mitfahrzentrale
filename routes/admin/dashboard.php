<?php
  use DulliAG\API\User;
  use DulliAG\API\Ride;
  $user = new User();
  $ride = new Ride();

  $rideList = $ride->getAll();
  $rideCount = count($rideList);

  $userList = $user->getAll();
  $userCount = count($userList);
  $newestUserList = array_reverse($userList);
  $newestUserCount = count($newestUserList);
  $adminList = array_filter($userList, function ($user) {
    return $user['isAdmin'] == 1;
  });
  $adminCount = count($adminList);
  $verifiedUserList = array_filter($userList, function ($user) {
    return $user['verified'] == 1;
  });
  $verifiedUserCount = count($verifiedUserList);

  function curlRequest($curl_target, $headers) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curl_target);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    $response_json = json_decode($response, true);
    curl_close ($curl);
    return $response_json;
  }
  
  $APP_GITHUB_INFORMATION = get_defined_constants()['GITHUB'];
  $REPO_ISSUES_URL = "https://github.com/".$APP_GITHUB_INFORMATION['user']."/".$APP_GITHUB_INFORMATION['repo']."/issues";
  $headers = [
    'Content-Type: application/json; charset=utf-8',
    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
  ]; // to send an curl request to the github-api an user-agent-string is required
  $GH_REPO_URL = "https://api.github.com/repos/".$APP_GITHUB_INFORMATION['user']."/".$APP_GITHUB_INFORMATION['repo']."";

  $github_json = curlRequest($GH_REPO_URL, $headers);
  // If we receive an message something went wrong
  if (!isset($github_json['message'])) {
    $releases_json = curlRequest($GH_REPO_URL . "/releases", $headers);
    $releaseCount = count($releases_json);
    $latestRelease = $releases_json[0];
    $issues_json = curlRequest($GH_REPO_URL . "/issues", $headers);
    $issuesCount = count($issues_json);
  }
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <title>BBS-Mitfahrzentrale • Adminbereich</title>
    <link rel="stylesheet" href="<?php echo $GLOBALS['host'] . "assets/css/admin.css"; ?>" />
  </head>
  <body>
    <div class="wrapper">
      <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/sidebar.php"; ?>

      <main class="main">
        <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/navbar.php"; ?>

        <section class="page-content">
          <div class="page-information">
            <h2 class="mb-2">Dashboard</h2>
          </div>
          <!-- ./page-information -->

          <div class="row">
            <div class="col-12 mb-3">
              <div>
                <!-- <h3 class="mb-2">Statistiken</h3> -->

                <div class="row">
                  <div class="col-6 col-md-3 mb-3">
                    <div class="p-3 bg-darkblue"> 
                      <h4>
                      <?php
                        if ($adminCount > 9) {
                          echo $adminCount;
                        } else {
                          echo '0' . $adminCount;
                        }
                      ?>
                      </h4>
                      <h4>
                      <?php
                        if ($adminCount > 1) {
                          echo 'Aktive Admins';
                        } else {
                          echo 'Aktiver Admin';
                        }
                      ?>
                      </h4>
                    </div>
                  </div>

                  <div class="col-6 col-md-3 mb-3">
                    <div class="p-3 bg-darkblue"> 
                      <h4>
                      <?php
                        if ($userCount > 9) {
                          echo $userCount;
                        } else {
                          echo '0' . $userCount;
                        }
                      ?>
                      </h4>
                      <h4>Registrierte Benutzer</h4>
                    </div>
                  </div>

                  <div class="col-6 col-md-3 mb-3">
                    <div class="p-3 bg-darkblue"> 
                      <h4>
                      <?php
                        if ($verifiedUserCount > 9) {
                          echo $verifiedUserCount;
                        } else {
                          echo '0' . $verifiedUserCount;
                        }
                      ?>
                      </h4>
                      <h4>Verifizierte Benutzer</h4>
                    </div>
                  </div>

                  <div class="col-6 col-md-3 mb-3">
                    <div class="p-3 bg-darkblue"> 
                      <h4>
                      <?php
                        if ($rideCount > 9) {
                          echo $rideCount;
                        } else {
                          echo '0' . $rideCount;
                        }                        
                      ?>
                      </h4>
                      <h4>Aktive Anzeigen</h4>
                    </div>
                  </div>
                </div>
                <!-- ./row-->

                <div class="row">
                  <div class="col-md-7 order-2 order-md-1">
                    <!-- <h3 class="mb-2">Neuste Benutzer</h3> -->
                    <div class="p-3 bg-darkblue">
                      <div class="table-responsive">
                        <table class="table text-white mb-0">
                          <thead>
                            <tr>
                              <th class="text-center">Verifiziert</th>
                              <th>Name</th>
                              <th colspan="2">E-Mail</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $displayedUser = 20;
                              if ($newestUserCount < 20) $displayedUser = $newestUserCount;

                              for ($i = 0; $i < $displayedUser; $i++) {
                                $u = $newestUserList[$i];

                                if ($u['verified'] == 1) {
                                  $badge = '<span class="badge bg-orange">Verifiziert</span>';
                                } else {
                                  $badge = '<span class="badge bg-secondary">Unverifiziert</span>';
                                }

                                echo '<tr>
                                  <td class="text-center">
                                    '.$badge.'
                                  </td>
                                  <td>
                                    <p>'.$u['name'].' '.$u['surname'].'</p>
                                  </td>
                                  <td>
                                    <a href="mailto:'.$u['email'].'">'.$u['email'].'</a>
                                  </td>
                                  <td class="d-flex justify-content-end">
                                    <button
                                      class="btn btn-outline-orange rounded-0 mr-auto px-3"
                                      data-user="'.$u['userId'].'"
                                      data-bs-toggle="modal"
                                      data-bs-target="#edit-user-modal"
                                    >
                                      <i class="fas fa-user-edit"></i>
                                      Bearbeiten
                                    </button>
                                  </td>
                                </tr>';
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- ./newest member-->
                  
                  <?php
                    // If message isset we have received an error-message and something went wrong
                    if (!isset($github_json['message'])) {
                      if ($github_json['license'] !== null) {
                        $license = '<p class="fw-bold">Lizenz: <a href="'.$github_json['license']['url'].'" class="badge bg-orange fw-normal">'.$github_json['license']['name'].'</a></p>';
                      } else{
                        $license = '<p class="fw-bold">Lizenz: <span class="badge bg-orange">KEINE</span></p>';
                      }

                      $issues_amount = "";
                      if ($issuesCount > 0) {
                        $issues_amount = '<span class="badge bg-secondary">'.$issuesCount.' Offen</span></p>';
                      }
                      $issues = '<p class="fw-bold">Fehler melden: <a href="'.$REPO_ISSUES_URL.'" class="badge bg-orange">Hier</a> ' . $issues_amount;
                      echo '<div class="col-md-5 order-1 order-md-2 mb-3 mb-md-0">
                        <div class="bg-darkblue p-3">
                          <p class="fw-bold">'.$github_json['name'].'</p>
                          <p class="fw-bold">Aktuelle Version: <span class="fw-normal">'.get_defined_constants()['CURRENT_APP_VERSION'].'</span></p>
                          <p class="fw-bold">Neuste Version: <span class="fw-normal">'.$latestRelease['tag_name'].'</span></p>
                          <p class="fw-bold">GitHub: <a href="'.$github_json['html_url'].'">'.$github_json['html_url'].'</a></p>
                          <p class="fw-bold">Author: <a href="https://github.com/'.$APP_GITHUB_INFORMATION['user'].'/">'.$APP_GITHUB_INFORMATION['author'].'</a></p>
                          '.$issues.'
                          '.$license.'
                        </div>
                      </div>
                      <!-- ./application-information -->';
                    }
                  ?>

                </div>
                <!-- ./row -->
              </div>
            </div>
            <!-- ./col-->
          </div>
          <!-- ./row -->
        </section>
      </main>
    </div>

    <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/editUserModal.php"; ?>

    <!-- PopperJS -->
    <!-- <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script> -->
    <!-- BootstrapJS -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
      crossorigin="anonymous"
    ></script>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/ApiHandler.js" ?>"></script>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/snackbar.js" ?>"></script>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/sidebar.js" ?>"></script>
    <script>
      sidebar.querySelector("#dashboard").classList.add("active");
      
      const UserAPI = new User();
      const AdminAPI = new Admin();
      const editUserModal = document.querySelector("#edit-user-modal");
      const editUserForm = editUserModal.querySelector("form");
      const signOutBtn = document.querySelector(".navbar #signOut");

      signOutBtn.addEventListener("click", function () {
        UserAPI.destroySession().then(() => {
          window.location.href = window.location.origin + "/Anmelden";
        }).catch(err => console.error(err));
      });

      editUserModal.addEventListener("show.bs.modal", function (e) {
        const trigger = e.relatedTarget;
        const userId = trigger.getAttribute("data-user");

        AdminAPI
          .getUser(userId)
          .then((data) => {
            var userId = editUserForm.querySelector("#user").value = data.userId;
            var isAdmin = editUserForm.querySelector("#admin").value = data.isAdmin;
            var isVerified = editUserForm.querySelector("#verified").value = data.verified;
            var name = editUserForm.querySelector("#name").value = data.name;
            var surname = editUserForm.querySelector("#surname").value = data.surname;
            var email = editUserForm.querySelector("#email").value = data.email;
            var phone = editUserForm.querySelector("#phone").value = data.telNumber;
            var key = editUserForm.querySelector("#key").value = data.apiKey;
          })
          .then(() => {
            editUserForm.addEventListener("submit", function (fe) {
              fe.preventDefault();
              var userId = editUserForm.querySelector("#user").value;
              var isAdmin = editUserForm.querySelector("#admin").value;
              var isVerified = editUserForm.querySelector("#verified").value;
              var name = editUserForm.querySelector("#name").value;
              var surname = editUserForm.querySelector("#surname").value;
              var email = editUserForm.querySelector("#email").value;
              var password = editUserForm.querySelector("#password").value; 
              password !== "" ? password : null
              var phone = editUserForm.querySelector("#phone").value;

              AdminAPI
                .updateUser(userId, isVerified, isAdmin, name, surname, email, phone, password !== "" ? password : null)
                .then((result) => {
                  
                  if (result.error == null) {
                    new Snackbar("Die Änderungen wurden gespeichert!").success();
                    setTimeout(() => {
                      window.location.reload(); // Reload the website to refresh the table content
                    }, 500);
                  } else {
                    new Snackbar("Die Änderungen konnten nicht gespeichert werden!").error();
                    console.error(result.error);
                  }
                })
                .catch((err) => console.error(err));
            });
          })
          .catch((err) => console.error(err));
          
      });

      editUserModal.addEventListener("hide.bs.modal", function (e) {
        editUserForm.reset();
      });
    </script>
  </body>
</html>
