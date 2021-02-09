<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <title>BBS-Mitfahrzentrale • Anmelden</title>
    <!-- Other stylesheets -->
    <link rel="stylesheet" href="./assets/css/signIn.css" />
  </head>
  <body id="sign-in">
    <div class="wrapper">
      <div class="form-container p-3 p-md-4"">
        <form id="signInForm">
          <img src="./assets/img/BBS-Soltau-Logo.svg" alt="BBS Logo" />

          <div class="mb-2 mb-md-3">
            <label class="form-label font-weight-bold mb-0">E-Mail</label>
            <input type="email" id="email" class="form-control" />
            <div id="validationEmail" class="invalid-feedback"></div>
          </div>

          <label class="form-label font-weight-bold mb-0">Passwort</label>
          <div class="input-group mb-4 mb-md-3">
            <input type="password" id="password" class="form-control" />
            <button type="button" class="btn" id="toggler">
              <i id="icon" class="far fa-eye"></i>
            </button>
            <div id="validationPassword" class="invalid-feedback"></div>
          </div>

          <div class="row mx-0">
            <input type="submit" class="btn submit-btn" value="Anmelden" />
          </div>

          <hr class="divider" data-text="Noch kein Konto?" />

          <a href="./Registrieren" class="btn btn-outline-orange redirect-btn w-100 rounded-0"
            >Hier registrieren!</a
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
      const form = document.querySelector("body #signInForm"),
        email = form.querySelector("#email"),
        password = form.querySelector("#password"),
        passwordToggler = form.querySelector("#toggler"),
        togglerIcon = form.querySelector("#icon");

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        UserAPI.checkCredentials(email.value, password.value)
          .then((result) => {
            // If there are validation classes addes we're gonna remove them
            email.classList.remove("is-invalid");
            password.classList.remove("is-invalid");

            // console.log(result);
            // Check if we received an error from our RestAPI
            if (result.error == null) {
              // Everything should be fine...
              // Redriect the user to the application
              window.location.href = "../";
            } else {
              // Something went wrong
              const error = result.error;
              switch (error) {
                case "auth/password-invalid":
                  password.classList.add("is-invalid");
                  form.querySelector("#validationPassword").innerHTML = "Das Passwort ist falsch!";
                  break;

                case "auth/user-not-found":
                  email.classList.add("is-invalid");
                  form.querySelector("#validationEmail").innerHTML =
                    "Der Benutzer konnte nicht gefunden werden!";
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