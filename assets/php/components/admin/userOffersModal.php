<!-- 
  NOTE: If you wanna use this component you need to import the editOfferModal.php
 -->

<div class="modal fade" id="user-offer-modal" tabindex="-1" aria-labelledby="user-offer-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="user-offer-label">Anzeigen</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-2">
        <div class="table-responsive">
          <table class="table text-white">
            <thead>
              <tr>
                <th>ID</th>
                <th>Titel</th>
                <th colspan="2">Anzeige</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-red rounded-0" data-bs-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var admin = new Admin();
  var editUserForm = editUserModal.querySelector("form");
  var userOffersModal = document.querySelector("#user-offer-modal");

  userOffersModal.addEventListener("show.bs.modal", function (e) {
    const trigger = e.relatedTarget;
    const userId = trigger.getAttribute("data-user");

    // TODO How can we improve the performance?
    // or maybe add an spinner during the loading time
    admin
      .getUserOffers(userId)
      .then((data) => {
        var offerList = data.sort((a, b) => {
          return a.rideId > b.rideId ? -1 : 1;
        }); // Sort newest to oldest

        if (offerList.length > 0) {
          offerList.forEach((offer) => {
            userOffersModal
              .querySelector("table tbody")
              .innerHTML += `<tr>
                  <td># ${offer.rideId}</td>
                  <td>${offer.title}</td>
                  <td>
                    <a href="${window.location.origin}/Anzeige/${offer.rideId}" class="badge bg-orange">Hier</a>
                  </td>
                  <td class="d-flex justify-content-end">
                    <button class="btn btn-outline-orange rounded-0 mr-auto px-3" data-ride="${offer.rideId}" data-bs-toggle="modal" data-bs-target="#edit-offer-modal">
                      <i class="fas fa-pencil-alt"></i>
                      Bearbeiten
                    </button>
                  </td>
                </tr>`;
          });
        } else {
          userOffersModal
            .querySelector("table tbody")
            .innerHTML = `<tr>
              <td colspan="4">
                <p class="text-center">Keine Angebote gefunden</p>
              </td>
            </tr>`;
        }
      })
      .catch((err) => console.error(err));
  });

  userOffersModal.addEventListener("hide.bs.modal", function (e) {
    userOffersModal.querySelector("table tbody").innerHTML = "";
  });
</script>