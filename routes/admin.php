<?php
  require_once "./endpoints/user/user.php";
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
<html lang="en">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <title>BBS-Mitfahrzentrale • Adminbereich</title>
  </head>
  <body>
    <div class="wrapper">
      <?php require_once "assets/php/navbar.php"; ?>

      <section class="mx-2 mx-md-4">
        <div class="container py-4 px-0 px-md-3">
          <div style="display: flex; flex-direction: row; flex-wrap: wrap;">
            <section class="col-12 mb-3 px-0">
              <div>
                <h3 class="mb-2">Statistiken</h3>
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
              </div>
            </section>
            <!-- ./stats -->

            <section class="col-12 mb-3 px-0">
              <div>
                <h3 class="mb-2">Benutzer</h3>

                <div class="table-responsive">
                  <table class="table text-white">
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
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
            <!-- ./user -->

            <section class="col-12 mb-3 px-0">
              <div>
                <h3 class="mb-2">Anzeigen</h3>

                <div class="table-responsive">
                  <table class="table text-white">
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
                            <a href="Angebot/'.$ride['rideId'].'" class="badge bg-orange">Hier</a>
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
            </section>
            <!-- ./offer -->

          </div>
          <!-- ./row -->
        </div>
        <!-- ./container -->
        
        <div class="modal fade" id="edit-user-modal" tabindex="-1" aria-labelledby="edit-user-modal" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="edit-user-label">Benutzer bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form>
                <input type="hidden" id="user" />
                <div class="modal-body">
                  <div class="row mb-3">
                    <label for="admin" class="col-sm-2 form-label">Admin</label>
                    <div class="col-sm-10">
                      <select name="admin" id="admin" class="form-control" required>
                        <option value="1">Ja</option>
                        <option value="0">Nein</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="verified" class="col-sm-2 form-label">Verifiziert</label>
                    <div class="col-sm-10">
                      <select name="verified" id="verified" class="form-control" required>
                        <option value="1">Ja</option>
                        <option value="0">Nein</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="name" class="col-sm-2 form-label">Name</label>
                    <div class="col-sm-5">
                      <input type="text" name="name" id="name" class="form-control mb-3 mb-md-0" maxlength="30" placeholder="Vorname" required />
                    </div>
                    <div class="col-sm-5">
                      <input type="text" name="surname" id="surname" class="form-control" maxlength="30" placeholder="Nachname" required />
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="email" class="col-sm-2 form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" name="email" id="email" class="form-control" maxlength="40" placeholder="Email" required />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="password" class="col-sm-2 form-label">Passwort</label>
                    <div class="col-sm-10">
                      <input type="text" name="password" id="password" class="form-control" placeholder="Passwort" />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="phone" class="col-sm-2 form-label">Telefon</label>
                    <div class="col-sm-10">
                      <input type="text" name="phone" id="phone" class="form-control" maxlength="18" placeholder="Telefonnummer" required />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="key" class="col-sm-2 form-label">API-Key</label>
                    <div class="col-sm-10">
                      <input type="text" name="key" id="key" class="form-control" maxlength="16" required disabled />
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-red rounded-0" data-bs-dismiss="modal">Abbrechen</button>
                  <button type="submit" class="btn btn-outline-orange rounded-0">Speichern</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="user-offer-modal" tabindex="-1" aria-labelledby="user-offer-modal" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="user-offer-label">Anzeigen</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body px-2">
                <div class="table-responsive">
                  <table class="table text-white">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Titel</th>
                        <th colspan="2">Anzeige</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-red rounded-0" data-bs-dismiss="modal">Schließen</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="edit-offer-modal" tabindex="-1" aria-labelledby="edit-offer-modal" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="edit-user-label">Anzeige bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form>
                <input type="hidden" id="offer" />
                <div class="modal-body">
                  <div class="row mb-3">
                    <label for="title" class="col-sm-2 form-label">Titel</label>
                    <div class="col-sm-10">
                      <input type="text" name="title" id="title" class="form-control" maxlength="50" required />
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="type" class="col-sm-2 form-label">Typ</label>
                    <div class="col-sm-10">
                      <select name="type" id="type" class="form-control" required>
                        <option value="1">Angebot</option>
                        <option value="0">Gesuche</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="information" class="col-sm-2 form-label">Beschreibung</label>
                    <div class="col-sm-10">
                      <textarea name="information" id="information" class="form-control" cols="30" rows="5" maxlength="250"></textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="description" class="col-sm-2 form-label">Preis</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <input type="number" name="price" id="price" class="form-control" required />
                        <button type="button" class="btn px-3" disabled>
                          <i class="fas fa-euro-sign"></i>
                        </button>
                      </div>                    
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="seats" class="col-sm-2 form-label">Freie Plätze</label>
                    <div class="col-sm-10">
                      <input type="number" name="seats" id="seats" class="form-control" required />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="start-at" class="col-sm-2 form-label">Start um</label>
                    <div class="col-sm-10">
                      <input type="datetime-local" name="start-at" id="start-at" class="form-control">
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div>
                        <h5 class="text-white">Start</h5>
                        <div class="row">
                          <div class="col-md-4 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Postleitzahl</label>
                              <input type="number" name="start-plz" id="start-plz" class="form-control" maxlength="5" required />
                            </div>
                          </div>
                          <div class="col-md-8 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Ort</label>
                              <input type="text" name="start-city" id="start-city" class="form-control" maxlength="40" maxlength="40" required />
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Straße</label>
                          <input type="text" name="start-adress" id="start-adress" class="form-control" maxlength="40" maxlength="40" required />
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <div>
                        <h5 class="text-white">Ziel</h5>
                        <div class="row">
                          <div class="col-md-4 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Postleitzahl</label>
                              <input type="number" name="destination-plz" id="destination-plz" class="form-control" maxlength="5" required />
                            </div>
                          </div>
                          <div class="col-md-8 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Ort</label>
                              <input type="text" name="destination-city" id="destination-city" class="form-control" maxlength="40" maxlength="40" required />
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Straße</label>
                          <input type="text" name="destination-adress" id="destination-adress" class="form-control" maxlength="40" maxlength="40" required />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-red rounded-0" data-bs-dismiss="modal">Abbrechen</button>
                  <button type="submit" class="btn btn-outline-orange rounded-0">Speichern</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>

      <?php require_once "assets/php/footer.php"; ?>
    </div>
    <!-- ./wrapper -->

    <?php require_once "assets/php/scripts.php"; ?>
    <script>
      const AdminAPI = new Admin(); // Imported through the scripts.php
      const editUserModal = document.querySelector("#edit-user-modal");
      const editUserForm = editUserModal.querySelector("form");
      const userOffersModal = document.querySelector("#user-offer-modal");
      const editOfferModal = document.querySelector("#edit-offer-modal");
      const editOfferForm = editOfferModal.querySelector("form");

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
                    window.location.reload(); // Reload the website to refresh the table content
                  } else {
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
            if (data.length > 0) {
              data.forEach(offer => {
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
              window.location.reload();
            } else {
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
