<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once "assets/php/header.php"; ?>
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
              <input type="text" id="name" class="form-control" />
            </div>
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">Nachname</label>
              <input type="text" id="surname" class="form-control" />
            </div>
          </div>

          <div class="row mb-0">
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">E-Mail</label>
              <input type="email" id="email" class="form-control" />
              <div id="validationEmail" class="invalid-feedback"></div>
            </div>
            <div class="col-12 col-md-6 mb-2 mb-md-3">
              <label class="form-label">Telefon</label>
              <input type="tel" id="phone" class="form-control" />
            </div>
          </div>

          <label class="form-label">Passwort</label>
          <div class="input-group mb-2 mb-md-3">
            <input type="password" id="password" class="form-control" />
            <button type="button" class="btn" id="toggler">
              <i id="icon" class="far fa-eye"></i>
            </button>
          </div>

          <div class="row">
            <div class="col-12 col-md-3 mb-2 mb-md-3">
              <label class="form-label">PLZ</label>
              <input type="text" id="plz" class="form-control" />
            </div>
            <div class="col-12 col-md-4 mb-2 mb-md-3">
              <label class="form-label">Ort</label>
              <input type="text" id="place" class="form-control" />
            </div>
            <div class="col-12 col-md-5 mb-4 mb-md-3">
              <label class="form-label">Straße</label>
              <input type="text" id="adress" class="form-control" />
            </div>
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
      crossorigin="anonymous"
    ></script>
    <script src="./assets/js/ApiHandler.js"></script>
    <script>
      const UserAPI = new User();
      const form = document.querySelector("body #signUpForm"),
        name = form.querySelector("#name"),
        surname = form.querySelector("#surname"),
        email = form.querySelector("#email"),
        phone = form.querySelector("#phone"),
        password = form.querySelector("#password"),
        passwordToggler = form.querySelector("#toggler"),
        togglerIcon = form.querySelector("#icon"),
        plz = form.querySelector("#plz"),
        place = form.querySelector("#place"),
        adress = form.querySelector("#adress");

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        UserAPI.register(
          name.value,
          surname.value,
          email.value,
          password.value,
          adress.value,
          plz.value,
          place.value,
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
                window.location.href = "../";
              });
            } else {
              // Something went wrong
              const error = result.error;
              switch (error) {
                case "auth/user-already-exist":
                  email.classList.add("is-invalid");
                  form.querySelector("#validationEmail").innerHTML =
                    "Der Benutzer ist bereits registriert!";
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