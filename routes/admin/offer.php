<?php
  use DulliAG\API\Ride;
  $ride = new Ride();

  $temp = array();
  $rideList = $ride->getAll();
  // Sort the rides from newest to oldest
  for ($j = 0; $j < count($rideList); $j++) {
    for ($i = 0; $i < count($rideList)-1; $i++) {
      if($rideList[$i] < $rideList[$i+1]) {
        $temp = $rideList[$i+1];
        $rideList[$i+1] = $rideList[$i];
        $rideList[$i] = $temp;
      }       
    }
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
            <h2 class="mb-2">Anzeigen</h2>
          </div>
          <!-- ./page-information -->

          <div class="row">
            <div class="col-12 mb-3">
              <div>

                <div class="row">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <!-- <h3 class="mb-2">Aktive Anzeigen</h3> -->
                    <div class="p-3 bg-darkblue">
                      <div class="table-responsive">
                        <table class="table text-white mb-0">
                          <thead>
                            <tr>
                              <th class="text-center">ID</th>
                              <th>Titel</th>
                              <th>Ersteller</th>
                              <th colspan="2">Anzeige</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                            foreach ($rideList as $ride) {
                              echo '<tr>
                                <td>
                                  <p class="text-center"># '.$ride['rideId'].'</p>
                                </td>
                                <td>
                                  <p>'.$ride['title'].'</p>
                                </td>
                                <td>
                                  <p>
                                    '.$ride['name'].' '.$ride['surname'].'
                                    <a href="mailto:'.$ride['email'].'">'.$ride['email'].'</a>
                                  </p>
                                </td>
                                <td>
                                  <a href="'.$GLOBALS['settings']['host'].'Angebot/'.$ride['rideId'].'" class="badge bg-orange">Hier</a>
                                </td>
                                <td class="d-flex justify-content-end">
                                  <button class="btn btn-outline-orange rounded-0 mr-auto px-3" data-ride="'.$ride['rideId'].'" data-bs-toggle="modal" data-bs-target="#edit-offer-modal">
                                    <i class="fas fa-pencil-alt"></i>
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
                  <!-- ./offers-->
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

    <?php 
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
      sidebar.querySelector("#offers").classList.add("active");
      
      const AdminAPI = new Admin();
      const UserAPI = new User();
      const editOfferModal = document.querySelector("#edit-offer-modal");
      const editOfferForm = editOfferModal.querySelector("form");
      const signOutBtn = document.querySelector(".navbar #signOut");

      signOutBtn.addEventListener("click", function () {
        UserAPI.destroySession().then(() => {
          window.location.href = window.location.origin + "/Anmelden";
        }).catch(err => console.error(err));
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
