<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
    <title>BBS-Mitfahrzentrale • Passwort zurücksetzen</title>
    <!-- Other stylesheets -->
    <link rel="stylesheet" href="<?php echo $GLOBALS['settings']['host'] . "assets/css/signIn.css"; ?>" />
  </head>
  <body id="sign-in">
    <div class="wrapper">
      <div class="form-container p-3 p-md-4"">
        <form id="resetPasswordForm">
          <img src="<?php echo $GLOBALS['settings']['host'] . "assets/img/BBS-Soltau-Logo.svg"; ?>" alt="BBS Logo" />

          <div class="mb-2 mb-md-3">
            <label class="form-label font-weight-bold mb-0">Passwort</label>
            <input type="text" id="password" name="password" class="form-control" placeholder="Neues Passwort" required />
          </div>

          <div class="row mx-0">
            <input type="submit" name="submit" class="btn submit-btn" value="Speichern" />
          </div>

          <hr class="divider" data-text="Doch anmelden?" />

          <a href="<?php echo $GLOBALS['settings']['host'] . "Anmelden"; ?>" class="btn btn-outline-orange redirect-btn w-100 rounded-0"
            >Hier anmelden!</a
          >
        </form>
      </div>
    </div>

    <script>
      const UserAPI = new User();
      const form = document.querySelector("body #resetPasswordForm"),
        password = form.querySelector("#password");

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        let apiKey = window.location.pathname.split("/").pop();
        let newPassword = password.value;
        UserAPI
          .setPassword(apiKey, newPassword)
          .then((data) => {
            new Snackbar("Dein neues Passwort wurde gespeichert!").success();
            form.reset();
            setTimeout(() => {
              window.location.href = window.location.origin + "/Anmelden";
            }, 1000);
          })  
          .catch((err) => {
            new Snackbar("Etwas ist schief gelaufen!").error();
          })
      });
    </script>
  </body>
</html>
