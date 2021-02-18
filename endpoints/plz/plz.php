<?php
namespace DulliAG\API;

class PLZ 
{
  public $sqlPHP = "C:/xampp/htdocs/endpoints/sql.php";
  // public $sqlPHP = "/Applications/XAMPP/xamppfiles/htdocs/endpoints/sql.php";

  public function getPlacesByPlz(int $plz)
  {
    require $this->sqlPHP;

    $arr = array();
    $select = $con->query("SELECT * FROM `cshare_plz` WHERE `PLZ` LIKE '".$plz."%' ORDER BY name ASC");
    while ($row = $select->fetch_assoc()) {
      $arr[] = $row;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function getPlaceByPlz(int $plz)
  {
    require $this->sqlPHP;

    $arr = array();
    $select = $con->query("SELECT * FROM `cshare_plz` WHERE `PLZ`='".$plz."'");
    while ($row = $select->fetch_assoc()) {
      $arr = $row;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function getPlzByName(string $name)
  {
    require $this->sqlPHP;

    $arr = array();
    $select = $con->query("SELECT * FROM `cshare_plz` WHERE `name`='".$name."'");
    while ($row = $select->fetch_assoc()) {
      $arr = $row;
    }

    return $arr;
    $select->close();
    $con->close();
  }
}