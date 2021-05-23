<?php
  require_once "./endpoints/ride/ride.php";
  use DulliAG\API\Ride;
  $ride = new Ride();
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
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
      <?php require_once get_defined_constants()['COMPONENTS']['navbar']; ?>

      <section class="mx-2 mx-md-4">
        <div class="container py-4">
          <div class="row">
            <div class="col-12 mb-3 px-0">
              <?php require_once get_defined_constants()['COMPONENTS']['not-verified']; ?>
            </div>

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
                <a href="./Erstellen" id="create-btn" class="btn btn-outline-orange rounded-0">
                  <i class="fas fa-ticket-alt"></i> Anzeige erstellen
                </a>
                
                <div class="btn-group">
                  <button
                    type="button"
                    id="sort-by"
                    class="btn btn-outline-orange dropdown-toggle rounded-0"
                    data-bs-toggle="dropdown"
                  >
                    <i class="fas fa-sort"></i> Sortieren nach
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                    <li>
                      <button type="button" id="newest" class="dropdown-item">Neuste zuerst</button>
                    </li>
                    <li>
                      <button type="button" id="oldest" class="dropdown-item">Älteste zuerst</button>
                    </li>
                    <li>
                      <button type="button" id="cheapest" class="dropdown-item">Günstigste zuerst</button>
                    </li>
                    <li>
                      <button type="button" id="most-expensive" class="dropdown-item">Teuerste zuerst</button>
                    </li>
                    <li>
                      <button type="button" id="seats-ascending" class="dropdown-item">Sitze aufwärts</button>
                    </li>
                    <li>
                      <button type="button" id="seats-descending" class="dropdown-item">Sitze abwärts</button>
                    </li>
                  </ul>
                </div>
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
                      if (count($offers) > 0) {
                        foreach ($offers as $key => $offer) {
                          echo $ride->_renderOffer($offer);
                        }
                      } else {
                        echo $ride->_renderNoOffers();
                      }
                      break;
                    
                    case "Gesuche":                      
                      if (count($requests) > 0) {
                        foreach ($requests as $key => $offer) {
                          echo $ride->_renderOffer($offer);
                        }
                      } else {
                        echo $ride->_renderNoOffers();
                      } 
                      break;

                    case "Favoriten":
                      if (count($favoriteOffers) > 0) {
                        foreach ($favoriteOffers as $key => $offer) {
                          echo $ride->_renderOffer($offer);
                        }
                      } else {
                        echo $ride->_renderNoOffers();
                      } 
                      break;

                    default:
                      if (count($all) > 0) {
                        foreach ($all as $key => $offer) {
                          echo $ride->_renderOffer($offer);
                        }
                      } else {
                        echo $ride->_renderNoOffers();
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

      <?php require_once get_defined_constants()['COMPONENTS']['footer']; ?>
    </div>
    <!-- ./wrapper -->

    <?php require_once get_defined_constants()['COMPONENTS']['scripts']; ?>
    <script>
      const sort = new Sort();
      const slug = "<?php echo $slug ?>"; // I know this is very bad :o
      const offerOutput = document.querySelector("#main-column #offer-output");
      const searchOffer = document.querySelector("#search-offer");
      const sortBy = document.querySelector("#sort-by");
      const sortOptions = {
        newest: document.querySelector("#newest"),
        oldest: document.querySelector("#oldest"),
        cheapest: document.querySelector("#cheapest"),
        mostExpensive: document.querySelector("#most-expensive"),
        seastAsc: document.querySelector("#seats-ascending"),
        seatsDesc: document.querySelector("#seats-descending"),
      };
      searchOffer.addEventListener("keyup", function (event) {
        var keywords = this.value.toLowerCase();
        var items = offerOutput.querySelectorAll(".offer-card");
        var itemAmount = items.length;
        let displayOffers = itemAmount;
        if (itemAmount > 0) {
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
                <div id="err-msg" class="bg-darkblue p-3">
                  <h3 class="text-white text-center">Keine Treffer für ${keywords}!</h3>
                </div>
              `;
            } else {
              errMsg.querySelector("h3").innerText = `Keine Treffer für ${keywords}!`;
            }
          } else if(displayOffers > 1 && errMsg != null) {
            errMsg.remove();
          } else if(errMsg != null) {
            errMsg.remove();
          }
        }
      });

      const runSort = (data) => {
        if (data.length > 0) {
          sortOptions.newest.addEventListener("click", function () {
            let sorted = sort.newToOld(data);
            offerOutput.innerHTML = "";
            sorted.map((offer) => {
              offerOutput.innerHTML += new Ride()._renderOffer(offer);
            });
          });
  
          sortOptions.oldest.addEventListener("click", function () {
            let sorted = sort.oldToNew(data);
            offerOutput.innerHTML = "";
            sorted.map((offer) => {
              offerOutput.innerHTML += new Ride()._renderOffer(offer);
            });
          });
  
          sortOptions.cheapest.addEventListener("click", function () {
            let sorted = sort.cheapToMostExpensive(data);
            offerOutput.innerHTML = "";
            sorted.map((offer) => {
              offerOutput.innerHTML += new Ride()._renderOffer(offer);
            });
          });
  
          sortOptions.mostExpensive.addEventListener("click", function () {
            let sorted = sort.mostExpensiveToCheap(data);
            offerOutput.innerHTML = "";
            sorted.map((offer) => {
              offerOutput.innerHTML += new Ride()._renderOffer(offer);
            });
          });
  
          sortOptions.seastAsc.addEventListener("click", function () {
            let sorted = sort.seatsAsc(data);
            offerOutput.innerHTML = "";
            sorted.map((offer) => {
              offerOutput.innerHTML += new Ride()._renderOffer(offer);
            });
          });
  
          sortOptions.seatsDesc.addEventListener("click", function () {
            let sorted = sort.seatsDesc(data);
            offerOutput.innerHTML = "";
            sorted.map((offer) => {
              offerOutput.innerHTML += new Ride()._renderOffer(offer);
            });
          });
        }
      }

      switch (slug) {
        case "Angebote":
          new Ride()
            .getOffers()
            .then((offerList) => {
              runSort(offerList);
            })
            .catch((err) => console.error(err));
          break;

        case "Gesuche":
          new Ride()
            .getRequests()
            .then((offerList) => {
              runSort(offerList);
            })
            .catch((err) => console.error(err));
          break;

        case "Favoriten":
          new Ride()
            .getFavorites()
            .then((offerList) => {
              runSort(offerList);
            })
            .catch((err) => console.error(err));
          break;

        default:
          new Ride()
            .getAll()
            .then((offerList) => {
              runSort(offerList);
            })
            .catch((err) => console.error(err));
          break;
      }
    </script>
  </body>
</html>
