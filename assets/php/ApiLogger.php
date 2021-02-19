<?php
namespace DulliAG\API;

class ApiLogger 
{
  public $sqlPHP = "C:/xampp/htdocs/endpoints/sql.php";
  // public $sqlPHP = "/Applications/XAMPP/xamppfiles/htdocs/endpoints/sql.php";
  
  public function create(string $requestedPath, string $requestedIp, $requestedKey)
  {
    require get_defined_constants()['CON_PATH'];

    $insert = $con->prepare("INSERT INTO `cshare_apiLogs` (`requestedPath`, `requestedIp`, `requestKey`) VALUES (?, ?, ?);");
    $insert->bind_param("sss", $requestedPath, $requestedIp, $requestedKey);
    $insert->execute();

    return $insert;
    $insert->close();
    $con->close();
  }
}