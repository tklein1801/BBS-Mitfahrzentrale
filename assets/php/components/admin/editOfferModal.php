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