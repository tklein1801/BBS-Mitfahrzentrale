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

<script type="text/javascript">
  var admin = new Admin();
  var eom = document.querySelector("#edit-offer-modal");
  var modalOptions = {};
  var editOfferModal = new bootstrap.Modal(eom, modalOptions)
  var editOfferForm = eom.querySelector("form");
  
  eom.addEventListener("show.bs.modal", function (e) {
    const trigger = e.relatedTarget;
    const rideId = trigger.getAttribute("data-ride");
        
    admin
      .getOffer(rideId)
      .then((data) => {
        var startAt = new Date(parseInt(data.startAt) * 1000);
        startAt.setMinutes(startAt.getMinutes() - startAt.getTimezoneOffset());
        eom.querySelector("#offer").value = data.rideId;
        eom.querySelector("#title").value = data.title;
        eom.querySelector("#type").value = data.driver;
        eom.querySelector("#information").value = data.information;
        eom.querySelector("#price").value = data.price;
        eom.querySelector("#seats").value = data.seats;
        eom.querySelector("#start-at").value = startAt.toISOString().slice(0, 16);
        eom.querySelector("#start-plz").value = data.startPlz;
        eom.querySelector("#start-city").value = data.startCity;
        eom.querySelector("#start-adress").value = data.startAdress;
        eom.querySelector("#destination-plz").value = data.destinationPlz;
        eom.querySelector("#destination-city").value = data.destinationCity;
        eom.querySelector("#destination-adress").value = data.destinationAdress;
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

    editOfferModal.toggle();
    admin
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
          }, 1000);
        } else {
          new Snackbar("Die Änderungen konnten nicht gespeichert werden!").error();
          console.error(result.error);
        }
      })
      .catch((err) => console.error(err));
  });

  eom.addEventListener("hide.bs.modal", function (e) {
    eom.querySelector("form").reset();
  });
</script>