  <?php
  require_once "./endpoints/ride/ride.php";
  use DulliAG\API\Ride;
  $ride = new Ride();
  $offer = $ride->get($rideId);
  
  function _renderSidebar(array $offer) {
    $btn = $_SESSION['login']['userId'] != $offer['creatorId'] ? '' : '<div>
            <button type="button" id="edit" class="btn btn-outline-orange w-100 rounded-0">
              <i class="far fa-trash-alt"></i>
              Anzeige löschen        
            </button>
            <div role="group" class="w-100 btn-group d-none">
              <button type="button" id="cancel" class="btn btn-outline-red rounded-0">Abbrechen</button>
              <button type="submit" id="delete" class="btn btn-orange rounded-0">Löschen</button>
            </div>
          </div>';
    return '<div id="sidebar-column" class="col-md-3 col-12">
        <!-- TOOD Maybe change this to an collapseable object for better mobile experience -->
        <div class="profile-container bg-darkblue p-3">
          <p class="text-center text-white mb-1">
            <i class="far fa-user-circle" style="font-size: 7rem;"></i>
          </p>
          <h5 class="text-white text-center mb-2">'.$offer['name'].' '.$offer['surname'].'</h5>
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
<html lang="en">
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
      </section>

      <?php require_once "assets/php/footer.php"; ?>
    </div>
    <!-- ./wrapper -->

    <?php require_once "assets/php/scripts.php"; ?>
    <script>
      let del = false;
      const ride = new Ride();
      const sidebar = document.querySelector("#sidebar-column");
      const editBtn = sidebar.querySelector("#edit");
      const cancelBtn = sidebar.querySelector("#cancel");
      const delBtn = sidebar.querySelector("#delete");
      editBtn.addEventListener("click", function () {
        if (!del) {
          del = true;
          editBtn.classList.add("d-none");
          sidebar.querySelector(".btn-group").classList.remove("d-none"); 
        }
      });
      cancelBtn.addEventListener("click", function () {
        if (del) {
          del = false;
          editBtn.classList.remove("d-none");
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
    </script>
  </body>
</html>
