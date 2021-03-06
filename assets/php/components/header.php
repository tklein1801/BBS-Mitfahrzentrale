<?php
  $url;
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") {
    $url = "https://";
  } else {
    $url = "http://";
  }
  $url.= $_SERVER['HTTP_HOST']."/";
?>
<meta charset="UTF-8">
<meta name="viewport" content="width-device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="id=edge">
<meta name="theme-color" content="#023846">
<meta property="og:image" content="<?php echo $url . "assets/img/BBS-Soltau-Logo.svg"; ?>">
<meta name="description" content="Enter an description...">
<meta property="og:type" content="website">
<link rel="icon" type="image/svg" sizes="500x500" href="<?php echo $url . "assets/img/BBS-Soltau-Logo.svg"; ?>">
<!-- Stylesheets -->
<!-- Bootstrap v5.0.0-beta1 -->
<link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
  crossorigin="anonymous"
/>
<!-- Fontawesome v5.6.3 -->
<link
  rel="stylesheet"
  href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
  integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
  crossorigin="anonymous"
/>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com" />
<link
  href="https://fonts.googleapis.com/css2?family=Hind+Madurai:wght@300;400;500;600;700&display=swap"
  rel="stylesheet"
/>
<!-- Custom Stylesheets -->
<link rel="stylesheet" href="<?php echo $url . "assets/css/master.css"; ?>" />
<link rel="stylesheet" href="<?php echo $url . "assets/css/snackbar.css"; ?>" />

<!-- JavaScript-files -->
<!-- BootstrapBundleJS -->
<script
  type="text/javascript"
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
  crossorigin="anonymous"
></script>
<script type="text/javascript" src="<?php echo $url . "assets/js/ApiHandler.js" ?>"></script>
<script type="text/javascript" src="<?php echo $url . "assets/js/snackbar.js" ?>"></script>
<script type="text/javascript" src="<?php echo $url . "assets/js/sort.js" ?>"></script>