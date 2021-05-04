<?php
  use DulliAG\API\User;
  use DulliAG\API\Ride;
  $user = new User();
  $ride = new Ride();

  $rideList = $ride->getAll();
  $rideCount = count($rideList);

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
                      <div class="table-responsive">
                        <table class="table text-white mb-0">
                          <thead>
                            <tr>
                              <th class="text-center">ID</th>
                              <th class="text-center">Rang</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th colspan="2">Anzeigen</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                            if ($userCount > 0) {
                              foreach ($userList as $user) {
                                $userOfferList = $ride->getUserOffers($user['userId']);
                                $userOfferCount = count($userOfferList);
                                if ($userOfferCount < 10) {
                                  $userOfferCount = "0" . $userOfferCount;
                                }
  
                                // FIXME Use the $user->isAdmin() method
                                if ($user['isAdmin'] == 1) {
                                  $badge = '<span class="badge bg-orange">Admin<span>';
                                } else {
                                  $badge = '<span class="badge bg-blue">Benutzer<span>';
                                }
  
                                echo '<tr>
                                  <td>
                                    <p class="text-white text-center"># '.$user['userId'].'</p>
                                  </td>
                                  <td class="text-center">
                                    '.$badge.'
                                  </td>
                                  <td>
                                    <p class="text-white">'.$user['name'] .' '. $user['surname'].'</p>
                                  </td>
                                  <td>
                                    <a href="mailto:'.$user['email'].'">'.$user['email'].'</a>
                                  </td>
                                  <td>
                                    <a href="#" data-user="'.$user['userId'].'" data-bs-toggle="modal" data-bs-target="#user-offer-modal">Anzeigen ('.$userOfferCount.')</a>
                                  </td>
                                  <td class="d-flex justify-content-end">
                                    <button class="btn btn-outline-orange rounded-0 mr-auto px-3" data-user="'.$user['userId'].'" data-bs-toggle="modal" data-bs-target="#edit-user-modal">
                                      <i class="fas fa-user-edit"></i>
                                      Bearbeiten
                                    </button>
                                  </td>
                                </tr>';
                              }
                            } else {
                              echo '<tr><td colspan="6"><p class="text-center">Keine Benutzer gefunden</p></td></tr>';
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
    ?>

    <!-- BootstrapJS -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
      crossorigin="anonymous"
    ></script>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/ApiHandler.js" ?>"></script>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/snackbar.js" ?>"></script>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/sidebar.js" ?>"></script>    <script>
      sidebar.querySelector("#user").classList.add("active");

      const UserAPI = new User();
      const AdminAPI = new Admin(); // Imported through the scripts.php
      const editUserModal = document.querySelector("#edit-user-modal");
      const editUserForm = editUserModal.querySelector("form");
      const userOffersModal = document.querySelector("#user-offer-modal");
      const editOfferModal = document.querySelector("#edit-offer-modal");
      const editOfferForm = editOfferModal.querySelector("form");
      const signOutBtn = document.querySelector(".navbar #signOut");

      signOutBtn.addEventListener("click", function () {
        UserAPI
          .destroySession()
          .then(() => {
            window.location.href = window.location.origin + "/Anmelden";
          })
          .catch(err => console.error(err));
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

      userOffersModal.addEventListener("show.bs.modal", function (e) {
        const trigger = e.relatedTarget;
        const userId = trigger.getAttribute("data-user");

        // TODO How can we improve the performance?
        // or maybe add an spinner during the loading time
        AdminAPI
          .getUserOffers(userId)
          .then((data) => {
            var offerList = data.sort((a, b) => {
              return a.rideId > b.rideId ? -1 : 1;
            }); // Sort newest to oldest

            if (offerList.length > 0) {
              offerList.forEach((offer) => {
                userOffersModal
                  .querySelector("table tbody")
                  .innerHTML += `<tr>
                      <td># ${offer.rideId}</td>
                      <td>${offer.title}</td>
                      <td>
                        <a href="${window.location.origin}/Anzeige/${offer.rideId}" class="badge bg-orange">Hier</a>
                      </td>
                      <td class="d-flex justify-content-end">
                        <button class="btn btn-outline-orange rounded-0 mr-auto px-3" data-ride="${offer.rideId}" data-bs-toggle="modal" data-bs-target="#edit-offer-modal">
                          <i class="fas fa-pencil-alt"></i>
                          Bearbeiten
                        </button>
                      </td>
                    </tr>`;
              });
            } else {
              userOffersModal
                .querySelector("table tbody")
                .innerHTML = `<tr>
                  <td colspan="4">
                    <p class="text-center">Keine Angebote gefunden</p>
                  </td>
                </tr>`;
            }
          })
          .catch((err) => console.error(err));
      });

      userOffersModal.addEventListener("hide.bs.modal", function (e) {
        userOffersModal.querySelector("table tbody").innerHTML = "";
      });

      editOfferModal.addEventListener("show.bs.modal", function (e) {
        const trigger = e.relatedTarget;
        const rideId = trigger.getAttribute("data-ride");
        
        AdminAPI
          .getOffer(rideId)
          .then((data) => {
            var startAt = new Date(parseInt(data.startAt) * 1000);
            startAt.setMinutes(startAt.getMinutes() - startAt.getTimezoneOffset());
            editOfferModal.querySelector("#offer").value = data.rideId;
            editOfferModal.querySelector("#title").value = data.title;
            editOfferModal.querySelector("#type").value = data.driver;
            editOfferModal.querySelector("#information").value = data.information;
            editOfferModal.querySelector("#price").value = data.price;
            editOfferModal.querySelector("#seats").value = data.seats;
            editOfferModal.querySelector("#start-at").value = startAt.toISOString().slice(0, 16);
            editOfferModal.querySelector("#start-plz").value = data.startPlz;
            editOfferModal.querySelector("#start-city").value = data.startCity;
            editOfferModal.querySelector("#start-adress").value = data.startAdress;
            editOfferModal.querySelector("#destination-plz").value = data.destinationPlz;
            editOfferModal.querySelector("#destination-city").value = data.destinationCity;
            editOfferModal.querySelector("#destination-adress").value = data.destinationAdress;
          })
          .catch((err) => console.error(err));
      });

      editOfferForm.addEventListener("submit", function (e) {
        e.preventDefault();
        var rideId = editOfferForm.querySelector("#offer").value;
        var title = editOfferForm.querySelector("#title").value;
        var type = editOfferForm.querySelector("#type").value;
        var information = editOfferForm.querySelector("#information").value;
        var price = editOfferForm.querySelector("#price").value;
        var seats = editOfferForm.querySelector("#seats").value;
        var startAtDate = editOfferForm.querySelector("#start-at").value;
        var startAt = Date.parse(startAtDate) / 1000; // bcause we wan't timestamp in seconds not in millis
        var startPlz = editOfferForm.querySelector("#start-plz").value;
        var startCity = editOfferForm.querySelector("#start-city").value;
        var startAdress = editOfferForm.querySelector("#start-adress").value;
        var destinationPlz = editOfferForm.querySelector("#destination-plz").value;
        var destinationCity = editOfferForm.querySelector("#destination-city").value;
        var destinationAdress = editOfferForm.querySelector("#destination-adress").value;

        AdminAPI
          .updateOffer(
            rideId,
            title,
            information,
            price,
            seats,
            startAt,
            startPlz,
            startCity,
            startAdress,
            destinationPlz,
            destinationCity,
            destinationAdress
          )
          .then((result) => {
            if (result.error == null) {
              new Snackbar("Die Änderungen wurden gespeichert!").success();
              setTimeout(() => {
                window.location.reload();
              }, 500);
            } else {
              new Snackbar("Die Änderungen konnten nicht gespeichert werden!").error();
              console.error(result.error);
            }
          })
          .catch((err) => console.error(err));
      });

      editOfferModal.addEventListener("hide.bs.modal", function (e) {
        editOfferModal.querySelector("form").reset();
      });
    </script>
  </body>
</html>
