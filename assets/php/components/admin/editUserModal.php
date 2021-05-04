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