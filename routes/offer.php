<?php
  require_once "./endpoints/ride/ride.php";
  use DulliAG\API\Ride;
  $ride = new Ride();
  $offer = $ride->get($rideId);
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
            <div id="sidebar-column" class="col-md-3 col-12">
              <!-- TOOD Maybe change this to an collapseable object for better mobile experience -->
              <div class="profile-container bg-blue p-3">
                <p class="text-center text-white mb-1">
                  <i class="far fa-user-circle" style="font-size: 7rem;"></i>
                </p>
                <h5 class="text-white text-center mb-2"><?php echo $offer['name']." ".$offer['surname']; ?></h5>
                <a class="btn btn-outline-orange rounded-0 w-100 mb-2">
                  <i class="far fa-star"></i>
                  Favorit hinzufügen
                </a>

                <a class="btn btn-outline-orange rounded-0 w-100 mb-2">
                  <i class="fas fa-star"></i>
                  Favorit entfernen
                </a>
                
                <a href="tel:<?php echo $offer['telNumber']; ?>" class="btn btn-outline-orange rounded-0 w-100 mb-2">
                  <i class="fas fa-phone"></i>
                  Anrufen
                </a>

                <a href="mailto:<?php echo $offer['email']; ?>" class="btn btn-outline-orange rounded-0 w-100">
                  <i class="far fa-paper-plane"></i>
                  E-Mail schreiben
                </a>
              </div>
              <!-- ./filter-container -->
            </div>
            <!-- ./sidebar -->

            <div id="main-column" class="col-md-9 col-12" style="padding: 0">
              <div class="bg-blue p-3">
                <h3 class="text-white mb-1"><?php echo $offer['title']; ?></h3>
                
                <span class="badge bg-orange"><?php echo $offer['price']; ?> €</span>
                <span class="badge bg-orange"><?php echo $offer['driver'] == 1 ? "Angebot" : "Gesuche"; ?></span>
                
                <p class="text-white font-weight-bold mb-0 mt-2">Beschreibung</p>
                <p class="text-white"><?php echo $offer['information']; ?></p>

                <p class="text-white font-weight-bold mb-0 mt-2">Start</p>
                <p class="text-white"><?php echo date("d.M.Y • H:m", $offer['startAt']); ?> Uhr</p>
                <p class="text-white"><?php echo $offer['startPlz']." ".$offer['startCity']; ?> • <?php echo $offer['startAdress']; ?></p>

                <p class="text-white font-weight-bold mb-0 mt-2">Ziel</p>
                <p class="text-white mb-3"><?php echo $offer['destinationPlz']." ".$offer['destinationCity']; ?> • <?php echo $offer['destinationAdress']; ?></p>
                <a class="btn btn-outline-white rounded-0" onclick="window.history.back();"> 
                  <i class="fas fa-angle-double-left"></i>
                  Zurück
                </a>
              </div>
            </div>
            <!-- ./offers -->
          </div>
          <!-- ./row -->
        </div>
        <!-- ./container -->
      </section>

      <?php require_once "assets/php/footer.php"; ?>
    </div>
    <!-- ./wrapper -->

    <?php require_once "assets/php/scripts.php"; ?>
  </body>
</html>
