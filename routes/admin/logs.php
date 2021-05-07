<?php
  use DulliAG\System\ApiLogger;
  
  $logger = new ApiLogger();
  $logs = $logger->getLogs();
  $logCount = count($logs);
  // $logs = array_reverse($logs); // if we're gonna reverse the array the will be sortey from oldest to newest
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once "assets/php/header.php"; ?>
    <title>BBS-Mitfahrzentrale • Adminbereich</title>
    <link rel="stylesheet" href="<?php echo $GLOBALS['host'] . "assets/css/admin.css"; ?>" />
  </head>
  <body>
    <div class="wrapper">
      <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/sidebar.php"; ?>

      <main class="main">
        <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/components/admin/navbar.php"; ?>

        <section class="page-content">
          <div class="page-information">
            <h2 class="mb-2">Logs</h2>
          </div>
          <!-- ./page-information -->

          <div class="row">
            <div class="col-12 mb-3">
              <div>
                <div class="row">
                  <div class="col-md-8 mb-3 mb-md-0">
                    <!-- <h3 class="mb-2">Logs</h3> -->
                    <div class="p-3 bg-darkblue">
                      <div class="table-responsive">
                        <table class="table text-white mb-0">
                          <thead>
                            <tr>
                              <th class="text-center">ID</th>
                              <th class="text-center">Statuscode</th>
                              <th>Pfad</th>
                              <th>IP-Adresse</th>
                              <th colspan="2">API-Key</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach ($logs as $log) {
                                $statusCode = $log['response_code'];
                                if ($statusCode >= 500 && $statusCode < 600) {
                                  $statusBadge = '<span class="badge bg-danger">'.$statusCode.'</span>';
                                } else if ($statusCode >= 400) {
                                  $statusBadge = '<span class="badge bg-warning">'.$statusCode.'</span>';
                                } else if ($statusCode >= 300) {
                                  $statusBadge = '<span class="badge bg-primary">'.$statusCode.'</span>';
                                } else if($statusCode >= 200) {
                                  $statusBadge = '<span class="badge bg-orange">'.$statusCode.'</span>';
                                } else {
                                  $statusBadge = '<span class="badge bg-secondary">'.$statusCode.'</span>';
                                }
                                echo '<tr>
                                  <td class="text-center">
                                    <p class="text-center">'.$log['logId'].'</p>
                                  </td>
                                  <td class="text-center">
                                    '.$statusBadge.'
                                  </td>
                                  <td>
                                    <p>'.$log['requestedPath'].'</p>
                                  </td>
                                  <td>
                                    <p>'.$log['requestedIp'].'</p>
                                  </td>
                                  <td colspan="2">
                                    <p>'.$log['requestKey'].'</p>
                                  </td>
                                </tr>';
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- ./logs-->
                </div>
                <!-- ./row -->
              </div>
            </div>
            <!-- ./col-->
          </div>
          <!-- ./row -->
        </section>
      </main>
    </div>
    
    <?php require_once get_defined_constants()['BASEPATH'] . "assets/php/scripts.php"; ?>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/sidebar.js" ?>"></script>      
    <script>
      document.querySelector(".sidebar #logs").classList.add("active");
    </script>
  </body>
</html>
