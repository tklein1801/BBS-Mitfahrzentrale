<?php
  use DulliAG\System\ApiLogger;
  
  $logger = new ApiLogger();
  $logs = $logger->count();

  $RESULTS_PER_PAGE = 35;
  $LOG_COUNT = $logs;
  $PAGE_NUMBERS = ceil($LOG_COUNT / $RESULTS_PER_PAGE); // round up to the next full number
  $CURRENT_PAGE = 1;
  if (isset($_GET['p'])) {
    $CURRENT_PAGE = $_GET['p'];
  } else if (isset($_GET['page'])) {
    $CURRENT_PAGE = $_GET['page'];
  }
  $FIRST_PAGE_RESULT = ($CURRENT_PAGE - 1) * $RESULTS_PER_PAGE;
  $logs = $logger->getRange($FIRST_PAGE_RESULT, $RESULTS_PER_PAGE);
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <?php require_once get_defined_constants()['COMPONENTS']['header']; ?>
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
                              if ($LOG_COUNT > 0) {
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
                              } else {
                                echo '<tr>
                                  <td colspan="6">
                                    <p class="text-center font-weight-bold">Keine Logs gefunden</p>
                                  </td>
                                </tr>';
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>

                      <!-- pagination -->
                      <nav class="mt-2" aria-label="...">
                        <ul class="pagination mb-0">
                          <?php
                            $PREV_PAGE = $CURRENT_PAGE - 1;
                            $NEXT_PAGE = $CURRENT_PAGE + 1;

                            if ($PREV_PAGE <= $CURRENT_PAGE && $PREV_PAGE != 0) {
                              echo ' <li class="page-item">
                                <a class="page-link" href="./Logs?p='.$PREV_PAGE.'" tabindex="-1" aria-disabled="true">
                                  <span aria-hidden="true">&laquo;</span>
                                </a>
                                </li>';
                            } else {
                              echo '<li class="page-item disabled">
                                <a class="page-link" href="#">
                                  <span aria-hidden="true">&laquo;</span>
                                </a>
                              </li>';
                            }

                            for ($pNum = 1; $pNum <= $PAGE_NUMBERS; $pNum++) {
                              if ($pNum == $CURRENT_PAGE) {
                                $classList = "page-item active";
                              } else {
                                $classList = "page-item";
                              }
                              echo '<li class="'.$classList.'">
                                <a class="page-link" href="./Logs?p='.$pNum.'">'.$pNum.'</a>
                              </li>';
                            }
                            if ($NEXT_PAGE <= $CURRENT_PAGE) {
                              echo '<li class="page-item">
                                <a class="page-link" href="./Logs?p='.$NEXT_PAGE.'">
                                  <span aria-hidden="true">&raquo;</span>
                                </a>
                              </li>';
                            } else {
                              echo '<li class="page-item disabled">
                                <a class="page-link" href="#">
                                  <span aria-hidden="true">&raquo;</span>
                                </a>
                              </li>';
                            }
                          ?>
                          <!-- <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                              <span aria-hidden="true">&laquo;</span>
                            </a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#">
                              <span aria-hidden="true">&raquo;</span>
                            </a>
                          </li> -->
                        </ul>
                      </nav>
                      <!-- ./pagination -->
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
    
    <?php require_once get_defined_constants()['BASEPATH'] . get_defined_constants()['COMPONENTS']['scripts']; ?>
    <script src="<?php echo $GLOBALS['settings']['host'] . "assets/js/sidebar.js" ?>"></script>      
    <script>
      document.querySelector(".sidebar #logs").classList.add("active");
    </script>
  </body>
</html>
