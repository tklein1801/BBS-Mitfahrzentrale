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
        <form id="requestResetForm">
          <img src="<?php echo $GLOBALS['settings']['host'] . "assets/img/BBS-Soltau-Logo.svg"; ?>" alt="BBS Logo" />

          <div class="mb-2 mb-md-3">
            <label class="form-label font-weight-bold mb-0">E-Mail</label>
            <input type="email" id="email" class="form-control" required />
            <div id="validationEmail" class="invalid-feedback"></div>
          </div>

          <div class="row mx-0">
            <input type="submit" class="btn submit-btn" value="Abschicken" />
          </div>

          <hr class="divider" data-text="Doch anmelden?" />

          <a href="<?php echo $GLOBALS['settings']['host'] . "Anmelden"; ?>" class="btn btn-outline-orange redirect-btn w-100 rounded-0"
            >Hier anmelden!</a
          >
        </form>
      </div>
    </div>

    <script>
      const mailer = new Mailer();
      const form = document.querySelector("body #requestResetForm"),
        email = form.querySelector("#email");

      form.addEventListener("submit", function (event) {
        event.preventDefault();
        mailer
          .requestPasswordReset(email.value)
          .then((data) => {
            new Snackbar("Die E-Mail wurde verschickt!").success();
            form.reset();
          })
          .catch((err) => {
            console.error("ERROR: ", err);
          });
      });
    </script>
  </body>
</html>
