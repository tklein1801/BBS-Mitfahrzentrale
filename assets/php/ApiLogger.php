<?php
namespace DulliAG\System;

class ApiLogger 
{  
  public function create(int $responseCode, string $requestedPath, string $requestedIp, $requestedKey)
  {
    require get_defined_constants()['CON_PATH'];

    $insert = $con->prepare("INSERT INTO `cshare_apiLogs` (`response_code`, `requestedPath`, `requestedIp`, `requestKey`) VALUES (?, ?, ?, ?)");
    $insert->bind_param("isss", $responseCode, $requestedPath, $requestedIp, $requestedKey);
    $insert->execute();

    return $insert;
    $insert->close();
    $con->close();
  }

  /**
   * Get an x-amount of the last saved api logs
   * Sorted from newest to oldest => logId DESC
   */
  public function getLogs(int $amount = 100)
  {
    require get_defined_constants()['CON_PATH'];

    $arr = array();
    $select = $con->query("SELECT * FROM cshare_apiLogs WHERE 1 ORDER BY logId DESC LIMIT ".$amount." ");
    while ($row = $select->fetch_assoc()) {
      $arr[] = $row;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function createLog($requestedPath)
  {
    if (isset($_SESSION['login'])) {
      $apiKey = $_SESSION['login']['apiKey'];
    } else {    
      $RequestMethod = $_SERVER['REQUEST_METHOD'];
      if ($RequestMethod === "POST") {
        if (isset($_POST['apiKey'])) {
          $apiKey = $_POST['apiKey'];
        } else {
          $apiKey = null;
        }
      } else if($RequestMethod === "GET") {
        if (isset($_GET['apiKey'])) {
          $apiKey = $_GET['apiKey'];
        } else {
          $apiKey = null;
        }
      }
    }

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $clientIp = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $clientIp = $_SERVER['REMOTE_ADDR'];
    }

    $HTTP_STATUS_CODE = http_response_code();

    $this->create($HTTP_STATUS_CODE, $requestedPath, $clientIp, $apiKey);
  }
}