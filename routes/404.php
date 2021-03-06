<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
    <title>BBS-Mitfahrzentrale • 404 Page Not Found</title>
  </head>
  <body class="err-page">
    <div class="wrapper">
      <div class="err-container">
        <img src="<?php echo $GLOBALS['settings']['logo']; ?>" />
        <h2 class="title">404 - Page Not Found</h2>
        <div class="btn-container">
          <a class="btn btn-outline-orange rounded-0" onclick="js:history.back()" href="#"
            >Zurück</a
          >
          <a class="btn btn-outline-orange rounded-0" href="<?php echo $GLOBALS['settings']['host']; ?>">Startseite</a>
          <a class="btn btn-outline-orange rounded-0" onclick="js:location.reload();" href="#"
            >Neu laden</a
          >
        </div>
      </div>
    </div>
  </body>
</html>
