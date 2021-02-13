<?php
  require_once "./endpoints/ride/ride.php";
  use DulliAG\API\Ride;
  $ride = new Ride();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <?php
      switch ($slug) {
        case "Angebote":
          echo '<title>BBS-Mitfahrzentrale • Angebote</title>';
          break;
        
        case "Gesuche":
          echo '<title>BBS-Mitfahrzentrale • Gesuche</title>';
          break;

        case "Favoriten":
          echo '<title>BBS-Mitfahrzentrale • Favoriten</title>';
          break;

        default:
          echo '<title>BBS-Mitfahrzentrale • Anzeigen</title>';
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
            <div class="col-12 mb-3" style="padding-left: 0; padding-right: 0">
              <div
                class="search-container p-3"
                style="display: flex; flex-direction: row; flex-wrap: wrap"
              >
                <div class="input-group col" style="margin-right: 1.5rem">
                  <input type="text" id="search-offer" class="form-control" maxlength="50" />
                  <button type="button" class="btn px-3">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
                <!-- ./input-group -->
                <a href="./Erstellen" class="btn btn-outline-orange rounded-0">
                  <i class="fas fa-ticket-alt"></i> Anzeige erstellen
                </a>
              </div>
              <!-- ./search-container -->
            </div>
            <!-- ./top-bar -->

            <?php
              $all = $ride->getAll();
              $allAmount = count($all);
              $offers = $ride->getOffers();
              $offerAmount = count($offers);
              $requests = $ride->getRequests();
              $requestAmount = count($requests);
              $favoriteOffers = $ride->getFavorites($_SESSION['login']['userId']);
            ?>

            <div id="sidebar-column" class="col-md-3 col-12">
              <!-- TOOD Maybe change this to an collapseable object for better mobile experience -->
              <div class="filter-container p-3">
                <h4>Filter</h4>
                <h6>Angebotstyp</h6>
                <!-- Redirect to new URL instead of checkboxes -->
                <?php
                  $categories = array(
                    array('slug' => 'Anzeigen', 'id' => 'all', 'href' => '/Anzeigen', 'text' => 'Alle anzeigen', 'amount' => $allAmount),
                    array('slug' => 'Angebote', 'id' => 'offers', 'href' => '/Angebote', 'text' => 'Angebote', 'amount' => $offerAmount),
                    array('slug' => 'Gesuche', 'id' => 'request', 'href' => '/Gesuche', 'text' => 'Gesuche', 'amount' => $requestAmount)
                  );
                  foreach ($categories as $key => $category) {
                    $slug == $category['slug'] ? $class = 'class="active"' : $class = "";
                    echo '<a href="'.$category['href'].'" id="'.$category['id'].'" '.$class.'>'.$category['text'].' <span>('.$category['amount'].')</span></a>';
                  }
                ?>
              </div>
              <!-- ./filter-container -->
            </div>
            <!-- ./sidebar -->

            <div id="main-column" class="col-md-9 col-12" style="padding: 0">
              <div id="offer-output">
                <?php
                  switch ($slug) {
                    case "Angebote":
                      foreach ($offers as $key => $offer) {
                        echo $ride->_renderOffer($offer);
                      }
                      break;
                    
                    case "Gesuche":
                      foreach ($requests as $key => $offer) {
                        echo $ride->_renderOffer($offer);
                      }
                      break;

                    case "Favoriten":
                      foreach ($favoriteOffers as $key => $offer) {
                        echo $ride->_renderOffer($offer);
                      }
                      break;

                    default:
                      foreach ($all as $key => $offer) {
                        echo $ride->_renderOffer($offer);
                      }   
                      break;
                  }
                ?>
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
    <script>
      const offerOutput = document.querySelector("#main-column #offer-output");
      const searchOffer = document.querySelector("#search-offer");
      searchOffer.addEventListener("keyup", function (event) {
        var keywords = this.value.toLowerCase();
        var items = offerOutput.querySelectorAll(".offer-card");
        var itemAmount = items.length;
        let displayOffers = itemAmount;
        for (let i = 0; i < itemAmount; i++) {
          const item = items[i];
          const itemTitle = item.querySelector(".card-title").innerText.toLowerCase();
          if (itemTitle.includes(keywords)) {
            item.style.display = "";
          } else {
            displayOffers--;
            item.style.display = "none";
          }
        } 
        const errMsg = offerOutput.querySelector("#err-msg");
        if (displayOffers == 0) {
          if(errMsg == undefined) {
            offerOutput.innerHTML += `
              <div id="err-msg" class="bg-blue p-3">
                <h3 class="text-white text-center">Keine Treffer für ${keywords}!</h3>
              </div>
            `;
          } else {
            errMsg.querySelector("h3").innerText = `Keine Treffer für ${keywords}!`;
          }
        } else if(displayOffers > 1 && errMsg != undefined) {
          errMsg.remove();
        }
      });
    </script>
  </body>
</html>
