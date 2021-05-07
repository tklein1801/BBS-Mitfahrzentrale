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
                  <div class="col-12 mb-3">
                    <div class="callout">
                      <h5 class="callout-title">Anzeigen suchen</h5>
                      <p class="callout-text">Sie können Anzeigen nach Titel, Name des Erstellers sowie der Email des Erstellers filtern!</p>
                    </div>
                  </div>

                  <div class="col-md-12 mb-3 mb-md-0">
                    <!-- <h3 class="mb-2">Aktive Anzeigen</h3> -->
                    <div class="p-3 bg-darkblue">
                      <div class="input-group search-table mb-2">
                        <input type="text" id="search-offer" class="form-control" placeholder="Anzeige suchen" />
                        <button type="button" class="btn px-3" disabled>
                          <i class="fas fa-search"></i>
                        </button>
                      </div>

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
      require_once get_defined_constants()['BASEPATH'] . "assets/php/scripts.php";
    ?>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/sidebar.js" ?>"></script>    
    <script>
      document.querySelector(".sidebar #offers").classList.add("active");

      var searchOfferInput = document.querySelector(".wrapper section #search-offer");
      searchOfferInput.addEventListener("keyup", function (e) {
        let tableItems = document.querySelectorAll(".wrapper table tbody tr");
        let rowAmount = tableItems.length;
        let keyword = this.value.toLowerCase();

        if (keyword !== "" && rowAmount > 0) {
          tableItems.forEach((row) => {
            let title = row.querySelector("td:nth-child(2) > p").innerText.toLowerCase();
            let creatorName = row.querySelector("td:nth-child(3) > p").innerText.toLowerCase();
            let creatorEmail = row.querySelector("td:nth-child(3) > p > a").innerText.toLowerCase();
            let match = title.includes(keyword) || creatorName.includes(keyword) || creatorEmail.includes(keyword);
            
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
