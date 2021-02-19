<?php
namespace DulliAG\API;

class PLZ 
{
  public function getPlacesByPlz(int $plz)
  {
    require get_defined_constants()['CON_PATH'];

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
    require get_defined_constants()['CON_PATH'];

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
    require get_defined_constants()['CON_PATH'];

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