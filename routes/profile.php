<?php
  require_once "./endpoints/ride/ride.php";
  require_once "./endpoints/user/user.php";
  use DulliAG\API\Ride;
  use DulliAG\API\User;
  $ride = new Ride();
  $user = new User();
  $userData = $user->get($_SESSION['login']['userId']);
  $avatarUrl = $user->getAvatarUrl($userData['name']);
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <title>BBS-Mitfahrzentrale • Profil</title>  
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

            <div id="sidebar-column" class="col-md-3 col-12">
              <div class="profile-container bg-blue p-3">
                <form id="profile-form">
                  <!-- <p class="text-center text-white mb-1">
                    <i class="far fa-user-circle" style="font-size: 7rem;"></i>
                  </p> -->
                  <img class="profile-image mb-1" src="<?php echo $avatarUrl ?>" alt="Profile picture of <?php echo $userData['name'].$userData['surname']; ?>" />

                  <h5 class="text-white text-center mb-2">
                    <?php 
                      echo $userData['name']." ".$userData['surname']; 
                    ?>
                  </h5>

                  <div class="role-container mb-2 d-flex justify-content-center">
                    <?php
                      if ($_SESSION['login']['isAdmin']) {
                        echo '<span class="badge bg-orange">Admin</span>';
                      }
                    ?>
                  </div>

                  <div>
                    <button type="button" id="edit" class="btn btn-outline-orange w-100 mb-2 rounded-0">
                      <i class="fas fa-user-edit"></i>
                      Bearbeiten
                    </button>
                    <div role="group" class="w-100 mb-2 btn-group d-none">
                      <button type="button" id="cancel" class="btn btn-outline-red rounded-0">Abbrechen</button>
                      <button type="submit" id="save" class="btn btn-orange rounded-0">Speichern</button>
                    </div>
                  </div>

                  <div class="mb-0 form-group">
                    <label class="font-weight-bold form-label">E-Mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $userData['email']; ?>" readonly>
                  </div>
                      
                  <div class="mb-0 form-group">
                    <label class="font-weight-bold form-label">Telefon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $userData['telNumber']; ?>" readonly>
                  </div>

                  <div class="mb-0 form-group">
                    <label class="font-weight-bold form-label">Passwort</label>
                    <input type="text" name="password" id="password" class="form-control" placeholder="Passwort unsichtbar" readonly>
                  </div>
                </form>
              </div>
              <!-- ./profile-container -->
            </div>
            <!-- ./sidebar -->

            <div id="main-column" class="col-md-9 col-12" style="padding: 0">
              <div id="offer-output">
                <?php 
                  $userOffers = $ride->getUserOffers($_SESSION['login']['userId']);
                  if (count($userOffers) > 0) {
                    foreach ($userOffers as $key => $offer) {
                      echo $ride->_renderOffer($offer);
                    }
                  } else {
                    echo $ride->_renderNoOffers();
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
      const sort = new Sort();
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

        for (let i = 0; i < itemAmount; i++) {
          const item = items[i];
          const itemTitle = item.querySelector(".card-title").innerText.toLowerCase();
          if (itemTitle.includes(keywords)) { 
            item.style.display = "";
          } else {
            item.style.display = "none";
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

      new Ride()
        .getUserOffers()
        .then((offerList) => {
          runSort(offerList);
        })
        .catch((err) => console.error(err));

      let editProfile = false;
      const user = new User();
      const profileContianer = document.querySelector(".profile-container");
      const buttons = {
        edit: profileContianer.querySelector("#edit"),
        cancel: profileContianer.querySelector("#cancel"),
        save: profileContianer.querySelector("#save"),
      }
      const form = {
        profile: profileContianer.querySelector("#profile-form"),
        email: profileContianer.querySelector("#email"),
        phone: profileContianer.querySelector("#phone"),
        password: profileContianer.querySelector("#password"),
      }
      var temp = {
        email: form.email.value,
        phone: form.phone.value,
        password: null,
      }
      buttons.edit.addEventListener("click", function () {
        if(!editProfile) {
          editProfile = true;
          // form.email.toggleAttribute("readonly", false);
          form.phone.toggleAttribute("readonly", false);
          form.password.toggleAttribute("readonly", false);
          buttons.edit.classList.add("d-none");
          profileContianer.querySelector(".btn-group").classList.remove("d-none");
        }
      });
      buttons.cancel.addEventListener("click", function () {
        if(editProfile) {
          editProfile = false;
          form.email.value = temp.email;
          form.phone.value = temp.phone;
          form.password.value = temp.password;
          // form.email.toggleAttribute("readonly", true);
          form.phone.toggleAttribute("readonly", true);
          form.password.toggleAttribute("readonly", true);
          buttons.edit.classList.remove("d-none");
          profileContianer.querySelector(".btn-group").classList.add("d-none");
        }
      });
      form.profile.addEventListener("submit", function (event) {
        event.preventDefault();
        if(editProfile) {   
          var password = form.password.value;
          user
            .update(form.phone.value, password !== "" ? password : null)
            .then((result) => {
              editProfile = false;
              temp.email = form.email.value;
              temp.phone = form.phone.value;
              temp.password = null;
              form.password.value = null;
              // form.email.toggleAttribute("readonly", true);
              form.phone.toggleAttribute("readonly", true);
              form.password.toggleAttribute("readonly", true);
              buttons.edit.classList.remove("d-none");
              profileContianer.querySelector(".btn-group").classList.add("d-none");       
            })
            .catch((err) => console.error(err));
        }
      });
    </script>
  </body>
</html>
