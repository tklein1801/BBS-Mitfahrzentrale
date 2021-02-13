<?php
  require_once "./endpoints/ride/ride.php";
  use DulliAG\API\Ride;
  $ride = new Ride();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <title>BBS-Mitfahrzentrale • Anzeige erstellen</title>
  </head>
  <body>
    <div class="wrapper">
      <?php require_once "assets/php/navbar.php"; ?>

      <section class="mx-2 mx-md-4">
        <div class="container py-4">
          <div class="row">
            <div id="sidebar-column" class="col-md-3 col-12 d-none">
              <div class="bg-blue p-3">
                <form>
                  <img class="w-25" src="https://files.dulliag.de/share/Blobbo.png" alt="User avatar" />
                </form>
              </div>
            </div>
            <!-- ./sidebar -->

            <div id="main-column" class="col-md-12 col-12" style="padding: 0">
              <div class="bg-blue p-3">
                <h3 class="text-white">Anzeige erstellen</h3>
                <small class="text-white">* Pflichtfelder</small>

                <form>
                  <div class="row">
                    <div class="col-12 col-md-8 mb-3">
                      <label class="form-label">Titel*</label>
                      <input type="text" name="title" id="title" class="form-control" maxlength="50" required />
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                      <label class="form-label">Typ*</label>
                      <select name="type" id="type" class="form-control" required>
                        <option value="1">Angebot</option>
                        <option value="0">Gesuche</option>
                      </select>
                    </div>
                  </div>
                  <!-- ./row -->

                  <div class="form-group mb-3">
                    <label class="form-label">Beschreibung*</label>
                    <textarea name="information" id="information" class="form-control" cols="30" rows="5" maxlength="250" required></textarea>
                  </div>

                  <div class="row">
                    <div class="col-12 col-md-4 mb3">
                      <label class="form-label">Preis*</label>
                      <div class="input-group">
                        <input type="number" name="price" id="price" class="form-control" required />
                        <button type="button" class="btn px-3" disabled>
                          <i class="fas fa-euro-sign"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                      <label class="form-label">Sitze*</label>
                      <input type="number" name="seats" id="seats" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                      <label class="form-label">Abfahrt um*</label>
                      <input type="datetime-local" name="start-at" id="start-at" class="form-control">
                    </div>
                  </div>
                  <!-- ./row -->

                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div>
                        <h3 class="text-white">Start</h3>
                        <div class="row">
                          <div class="col-md-4 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Postleitzahl*</label>
                              <input type="number" name="start-plz" id="start-plz" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-8 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Ort*</label>
                              <input type="text" name="start-city" id="start-city" class="form-control" maxlength="20" required>
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Straße*</label>
                          <input type="text" name="start-adress" id="start-adress" class="form-control" maxlength="40" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-12">
                      <div>
                        <h3 class="text-white">Ziel</h3>
                        <div class="row">
                          <div class="col-md-4 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Postleitzahl*</label>
                              <input type="number" name="destination-plz" id="destination-plz" class="form-control" required>
                            </div>
                          </div>
                          <div class="col-md-8 col-12 mb-3">
                            <div class="form-group">
                              <label class="form-label">Ort*</label>
                              <input type="text" name="destination-city" id="destination-city" class="form-control" maxlength="20" required>
                            </div>
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label class="form-label">Straße*</label>
                          <input type="text" name="destination-adress" id="destination-adress" class="form-control" maxlength="40" required>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <!-- ./row -->
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" required>
                    <label class="form-check-label">
                      Hiermit akzeptiere ich die aktuellen <a href="#">Nutzungsbedingungen</a> und Informationen zu Verarbeitung der Daten findest du in unserer <a href="#">Datenschutzerklärung</a>.
                    </label>
                  </div>

                  <div style="display: flex; flex-direction: row;">
                    <input type="submit" class="btn btn-outline-orange rounded-0 px-5 mx-auto" value="Erstellen">
                  </div>
                </form>
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
      const navbar = document.querySelector(".navbar");
      window.addEventListener("scroll", () => {
        const scrollOffset = window.scrollY;
        scrollOffset >= 1 ? navbar.classList.add("scrolled") : navbar.classList.remove("scrolled");
      });

      const UserAPI = new User();
      const signOutBtn = document.querySelector(".navbar #signOut");
      signOutBtn.addEventListener("click", function () {
        UserAPI.destroySession().then(() => {
          window.location.href = window.location.origin + "/Anmelden";
        }).catch(err => console.error(err));
      });

      const RideAPI = new Ride();
      const form = document.querySelector("#main-column form")
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        const title = form.querySelector("#title").value,
          type = form.querySelector("#type").value,
          information = form.querySelector("#information").value,
          price = form.querySelector("#price").value,
          seats = form.querySelector("#seats").value,
          startAtDate = form.querySelector("#start-at").value,
          startAt = Date.parse(startAtDate) / 1000, // bcause we wan't timestamp in seconds not in millis
          startPlz = form.querySelector("#start-plz").value,
          startCity = form.querySelector("#start-city").value,
          startAdress = form.querySelector("#start-adress").value,
          destinationPlz = form.querySelector("#destination-plz").value,
          destinationCity = form.querySelector("#destination-city").value,
          destinationAdress = form.querySelector("#destination-adress").value;

        console.log(startAt);
        RideAPI
          .create(type, title, information, price, seats, startAt, startPlz, startCity, startAdress, destinationPlz, destinationCity, destinationAdress)
          .then((result) => {
            console.log(result);
          })
          .catch((err) => console.error(err));
      });
    </script>
  </body>
</html>