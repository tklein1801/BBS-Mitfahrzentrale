  <?php
  require_once "./endpoints/ride/ride.php";
  use DulliAG\API\User;
  use DulliAG\API\Ride;
  $ride = new Ride();
  $offer = $ride->get($rideId);
  
  function _renderSidebar(array $offer) {
    $user = new User();
    $btn = ""; $adminBadge = "";

    if ($_SESSION['login']['isAdmin'] || $_SESSION['login']['userId'] == $offer['creatorId']) {
      $btn = '<div>
        <button type="button" class="btn btn-outline-orange w-100 rounded-0 mb-2" data-bs-toggle="modal" data-bs-target="#editModal">
          <i class="fas fa-pencil-alt"></i>
          Anzeige bearbeiten
        </button>
        <button type="button" id="wanna-delete" class="btn btn-outline-orange w-100 rounded-0">
          <i class="far fa-trash-alt"></i>
          Anzeige löschen        
        </button>
        <div role="group" class="w-100 btn-group d-none">
          <button type="button" id="cancel-delete" class="btn btn-outline-red rounded-0">Abbrechen</button>
          <button type="submit" id="delete" class="btn btn-orange rounded-0">Löschen</button>
        </div>
      </div>';
    }

    if ($offer['isAdmin']) {
      $adminBadge = '<span class="badge bg-orange">Admin</span>';
    }
    $avatarUrl = $user->getAvatarUrl($offer['name']);
    return '<div id="sidebar-column" class="col-md-3 col-12">
        <div class="profile-container bg-darkblue p-3">
          <!-- <p class="text-center text-white mb-1">
            <i class="far fa-user-circle" style="font-size: 7rem;"></i>
          </p> -->
          <img class="profile-image mb-1" src="'.$avatarUrl.'" alt="Profile picture of '.$offer['name'].' '.$offer['surname'].'" />
          <h5 class="text-white text-center mb-2">'.$offer['name'].' '.$offer['surname'].'</h5>
          
          <div class="role-container d-flex mb-2 justify-content-center">
            '.$adminBadge.'
          </div>
          
          <!-- <a class="btn btn-outline-orange rounded-0 w-100 mb-2">
            <i class="far fa-star"></i>
            Favorit hinzufügen
          </a>

          <a class="btn btn-outline-orange rounded-0 w-100 mb-2">
            <i class="fas fa-star"></i>
            Favorit entfernen
          </a> -->
                
          <a href="tel:'.$offer['telNumber'].'" class="btn btn-outline-orange rounded-0 w-100 mb-2">
            <i class="fas fa-phone"></i>
            Anrufen
          </a>

          <a href="mailto:'.$offer['email'].'" class="btn btn-outline-orange rounded-0 w-100 mb-2">
            <i class="far fa-paper-plane"></i>
            E-Mail schreiben
          </a>
          '.$btn.'
        </div>
        <!-- ./filter-container -->
      </div>
      <!-- ./sidebar -->';
  }

  function _renderOffer(array $offer) {
    $type = $offer['driver'] == 1 ? "Angebot" : "Gesuche";
    $seats = $offer['seats'] > 1 ? $offer['seats']." Plätze" : $offer['seats']." Platz";
    echo '<div id="main-column" class="col-md-9 col-12" style="padding: 0">
        <div class="bg-darkblue p-3">
          <h3 class="text-white mb-1">'.$offer['title'].'</h3>
          <span class="badge bg-orange">'.$offer['price'].' €</span>
          <span class="badge bg-orange">'.$type.'</span>
          <span class="badge bg-orange">'.$seats.'</span>
                
          <p class="text-white font-weight-bold mb-0 mt-2">Beschreibung</p>
          <p class="text-white">'.$offer['information'].'</p>
          
          <p class="text-white font-weight-bold mb-0 mt-2">Start</p>
          <p class="text-white">'.date("d.M Y • H:i", $offer['startAt']).' Uhr</p>
          <p class="text-white">'.$offer['startPlz'].' '.$offer['startCity'].' • '.$offer['startAdress'].'</p>

          <p class="text-white font-weight-bold mb-0 mt-2">Ziel</p>
          <p class="text-white mb-3">'.$offer['destinationPlz'].' '.$offer['destinationCity'].' • '.$offer['destinationAdress'].'</p>
          <a class="btn btn-outline-white rounded-0" onclick="window.history.back();"> 
            <i class="fas fa-angle-double-left"></i>
            Zurück
          </a>
        </div>
      </div>
      <!-- ./offers -->';
  }

  function _renderErrorMessage(int $rideId) {
    echo '<div class="bg-darkblue p-3">
        <h3 class="text-white text-center">Anzeige '.$rideId.' nicht gefunden!</h3>
      </div>';
  }
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <?php
      switch ($slug) {
        case "Angebot":
          echo '<title>BBS-Mitfahrzentrale • Angebot</title>';
          break;

        default:
          echo '<title>BBS-Mitfahrzentrale • Anzeige</title>';
          break;
      }
    ?>
  </head>
  <body>
    <div class="wrapper">
      <?php require_once "assets/php/navbar.php"; ?>

      <section class="mx-2 mx-md-4">
        <div class="container py-4">
          <div class="row">
            <?php
              if (count($offer) !== 0) {
                echo _renderSidebar($offer);
                echo _renderOffer($offer);
              } else {
                echo _renderErrorMessage($rideId);
              }
            ?>
          </div>
          <!-- ./row -->
        </div>
        <!-- ./container -->

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anzeige bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form>
                <input type="hidden" id="offer" value="<?php echo $offer['rideId']; ?>" />
                <div class="modal-body">
                  <div class="row mb-3">
                    <label for="title" class="col-sm-2 form-label">Titel</label>
                    <div class="col-sm-10">
                      <input type="text" id="title" class="form-control" maxlength="50" value="<?php echo $offer['title']; ?>" disabled />
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="type" class="col-sm-2 form-label">Typ</label>
                    <div class="col-sm-10">
                      <input type="text" id="type" class="form-control" value="<?php echo $offer['driver'] == 1 ? "Angebot" : "Gesuche"; ?>" disabled />
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="information" class="col-sm-2 form-label">Beschreibung</label>
                    <div class="col-sm-10">
                      <textarea id="information" class="form-control" cols="30" rows="5" maxlength="250"><?php echo $offer['information']; ?></textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="description" class="col-sm-2 form-label">Preis</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <input type="number" name="price" id="price" class="form-control" value="<?php echo $offer['price']; ?>" required />
                        <button type="button" class="btn px-3" disabled>
                          <i class="fas fa-euro-sign"></i>
                        </button>
                      </div>                    
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="seats" class="col-sm-2 form-label">Freie Plätze</label>
                    <div class="col-sm-10">
                      <input type="number" id="seats" class="form-control" value="<?php echo $offer['seats']; ?>" />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="start-at" class="col-sm-2 form-label">Start um</label>
                    <div class="col-sm-10">
                      <input type="datetime-local" id="start-at" class="form-control" value="<?php echo date("Y-m-d", $offer['startAt']); ?>T<?php echo date("H:i", $offer['startAt']); ?>">
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
                              <input type="number" name="start-plz" id="start-plz" class="form-control" value="<?php echo $offer['startPlz']; ?>" maxlength="5" required />
                            </div>
                          </div>
                          <div class="col-md-8 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Ort</label>
                              <input type="text" name="start-city" id="start-city" class="form-control" maxlength="40" value="<?php echo $offer['startCity']; ?>" maxlength="40" required />
                              <!-- <select name="start-city" id="start-city" class="form-control" required></select> -->
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Straße</label>
                          <input type="text" name="start-adress" id="start-adress" class="form-control" maxlength="40" value="<?php echo $offer['startAdress']; ?>" maxlength="40" required />
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
                              <input type="number" name="destination-plz" id="destination-plz" class="form-control" value="<?php echo $offer['destinationPlz']; ?>" maxlength="5" required />
                            </div>
                          </div>
                          <div class="col-md-8 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Ort</label>
                              <input type="text" name="destination-city" id="destination-city" class="form-control" maxlength="40" value="<?php echo $offer['destinationCity']; ?>" maxlength="40" required />
                              <!-- <select name="destination-city" id="destination-city" class="form-control" required></select> -->
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Straße</label>
                          <input type="text" name="destination-adress" id="destination-adress" class="form-control" maxlength="40" value="<?php echo $offer['destinationAdress']; ?>" maxlength="40" required />
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
      let del = false;
      const ride = new Ride();
      const sidebar = document.querySelector("#sidebar-column");
      const wannaDelBtn = sidebar.querySelector("#wanna-delete");
      const cancelDelBtn = sidebar.querySelector("#cancel-delete");
      const delBtn = sidebar.querySelector("#delete");
      const editModal = document.getElementById("editModal"),
        editForm = editModal.querySelector("form");
      wannaDelBtn.addEventListener("click", function () {
        if (!del) {
          del = true;
          wannaDelBtn.classList.add("d-none");
          sidebar.querySelector(".btn-group").classList.remove("d-none"); 
        }
      });
      cancelDelBtn.addEventListener("click", function () {
        if (del) {
          del = false;
          wannaDelBtn.classList.remove("d-none");
          sidebar.querySelector(".btn-group").classList.add("d-none"); 
        }
      });
      delBtn.addEventListener("click", function () {
        if (del) {
          del = false;
          const rideId = window.location.pathname.split("/")[2];
          ride
            .delete(rideId)
            .then((result) => {
              if (result.error == null) {
                window.location.href = window.location.origin + "/Anzeigen";
              } else {
                console.error(result.error);
              }
            })
            .catch((err) => console.error(err));
        }
      });

      editForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const rideId = editForm.querySelector("#offer").value,
          title = editForm.querySelector("#title").value,
          type = editForm.querySelector("#type").value,
          information = editForm.querySelector("#information").value,
          price = editForm.querySelector("#price").value,
          seats = editForm.querySelector("#seats").value,
          startAtDate = editForm.querySelector("#start-at").value,
          startAt = Date.parse(startAtDate) / 1000, // bcause we wan't timestamp in seconds not in millis
          startPlz = editForm.querySelector("#start-plz").value,
          startCity = editForm.querySelector("#start-city").value,
          startAdress = editForm.querySelector("#start-adress").value,
          destinationPlz = editForm.querySelector("#destination-plz").value,
          destinationCity = editForm.querySelector("#destination-city").value,
          destinationAdress = editForm.querySelector("#destination-adress").value;

        ride
          .update(rideId, information, price, seats, startAt, startPlz, startCity, startAdress, destinationPlz, destinationCity, destinationAdress)
          .then((result) => {
            if (result.error == null) {
              location.reload();
            } else {
              console.error(result.error);
            }
          })
          .catch((err) => console.error(err));
      });
    </script>
  </body>
</html>
