<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
    <title>BBS-Mitfahrzentrale • Registrieren</title>
    <!-- Other stylesheets -->
    <link rel="stylesheet" href="./assets/css/signIn.css" />
  </head>
  <body id="sign-up">
    <div class="wrapper">
      <div class="form-container p-3 p-md-4">
        <form id="signUpForm">
          <img src="./assets/img/BBS-Soltau-Logo.svg" alt="BBS Logo" />

          <div class="row mb-0">
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">Vorname</label>
              <input type="text" name="name" id="name" class="form-control" required />
            </div>
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">Nachname</label>
              <input type="text" name="surname" id="surname" class="form-control" required />
            </div>
          </div>

          <div class="row mb-0">
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">E-Mail</label>
              <input type="email" name="email" id="email" class="form-control" required />
              <div id="validationEmail" class="invalid-feedback"></div>
            </div>
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">Telefon</label>
              <input type="tel" name="phone" id="phone" class="form-control" required />
            </div>
          </div>

          <label class="form-label">Passwort</label>
          <div class="input-group mb-2 mb-md-3">
            <input type="password" name="password" id="password" class="form-control" required />
            <button type="button" class="btn" id="toggler">
              <i id="icon" class="far fa-eye"></i>
            </button>
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" name="data-protection" id="data-protection" class="form-check-input" required>
            <label for="data-protection" class="form-check-label">
              Hiermit akzeptiere ich die aktuelle Datenschutzerklärung und stimme der Verarbeitung meiner Daten zu. Informationen zu Verarbeitung der Daten findest du in unserer <a href="<?php echo $url . "Datenschutz"; ?>">Datenschutzerklärung</a>.
            </label>
          </div>

          <div class="row mx-0">
            <input type="submit" class="btn submit-btn" value="Registrieren" />
          </div>

          <hr class="divider" data-text="Schon ein Konto?" />

          <a href="./Anmelden" class="btn btn-outline-orange redirect-btn w-100 rounded-0"
            >Hier anmelden!</a
          >
        </form>
      </div>
    </div>

    <script>
      const UserAPI = new User();
      const Places = new PLZ();
      const form = document.querySelector("body #signUpForm"),
        name = form.querySelector("#name"),
        surname = form.querySelector("#surname"),
        email = form.querySelector("#email"),
        phone = form.querySelector("#phone"),
        password = form.querySelector("#password"),
        passwordToggler = form.querySelector("#toggler"),
        togglerIcon = form.querySelector("#icon");

      // plz.addEventListener("keyup", function () {
      //   const enteredPlz = this.value;
      //   Places
      //     .placesByPlz(enteredPlz)
      //     .then((list) => {
      //       // place.innerHTML += `<option id="place-${p.plzId}" value="${p.name}">${p.name}</option>`;
      //       place.innerHTML = ""; // remove all options
      //       list.map((item) => {
      //         let element = place.querySelector(`option[value="${item.name}"]`);
      //         if (!element) {
      //           place.innerHTML += `<option id="place-${item.plzId}" value="${item.name}">${item.name}</option>`;
      //         }
      //       });
      //     })
      //     .catch((err) => console.error(err));
      // });

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        UserAPI.register(
          name.value,
          surname.value,
          email.value,
          password.value,
          phone.value
        )
          .then((result) => {
            // If there are validation classes addes we're gonna remove them
            email.classList.remove("is-invalid");

            // console.log("RESULT", result);
            // Check if we received an error from our RestAPI
            if (result.error == null) {
              // Everything should be fine...
              // Now we're gonna call the checkCredentials-function to sign the user in
              UserAPI.checkCredentials(email.value, password.value).then(() => {
                new Snackbar("Du wurdest registriert!").success();
                setTimeout(() => {
                  window.location.href = "../Anzeigen";
                }, 500);
              });
            } else {
              // Something went wrong
              const error = result.error;
              switch (error) {
                case "auth/user-already-exist":
                  email.classList.add("is-invalid");
                  form.querySelector("#validationEmail").innerHTML =
                    "Der Benutzer ist bereits registriert!";
                  new Snackbar("Der Benutzer ist bereits registriert!").error();
                  break;
              }
            }
          })
          .catch((err) => console.error(err));
      });

      passwordToggler.addEventListener("click", function () {
        if (password.type == "password") {
          password.type = "text";
          togglerIcon.classList = "far fa-eye-slash";
        } else {
          password.type = "password";
          togglerIcon.classList = "far fa-eye";
        }
      });
    </script>
  </body>
</html>
