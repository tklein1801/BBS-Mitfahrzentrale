<?php
namespace DulliAG\API;

class Ride
{
  public $sqlPHP = "C:/xampp/htdocs/endpoints/sql.php";
  // public $sqlPHP = "/Applications/XAMPP/xamppfiles/htdocs/endpoints/sql.php";

  function _renderOffer($offer) {
    $driver = $offer['driver'] == 1 ? "Angebot" : "Gesuch";
    $createdAt = $offer['createdAt'];
    $day = date("d", $createdAt);
    $month = date("m", $createdAt);
    $day = $day == date("d", time()) ? "Heute" : ($day == (date("d", time()) - 1) ? "Gestern" : $day.".".$month);
    return '<div id="offer-'.$offer['rideId'].'" class="card offer-card mb-3">
        <div class="row g-0">
          <div class="col-md-6">
            <div class="card-body">
              <a href="Angebot/'.$offer['rideId'].'" class="stretched-link text-white">
                <h5 class="card-title">'.$offer['title'].'</h5>
              </a>
              <p class="card-text">'.$offer['information'].'</p>
              <p class="card-text">
                <small class="text-muted">'.$day.', '.date("H:i", $createdAt).' Uhr</small>
              </p>
              <span class="badge bg-orange">'.$offer['price'].' €</span>
              <span class="badge bg-orange">'.$driver.'</span>
            </div>
          </div>
          <!-- ./1st-col -->
          
          <div class="col-md-3 d-flex align-items-center">
            <div class="card-body">
              <p class="price">Start</p>
              <p>
                '.$offer['startPlz'].' '.$offer['startCity'].' <br />
                '.$offer['startAdress'].'
              </p>
            </div>
          </div>
          <!-- ./2nd-col -->
          
          <div class="col-md-3 d-flex align-items-center">
            <div class="card-body">
              <p class="price">Ziel</p>
              <p>
                '.$offer['destinationPlz'].' '.$offer['destinationCity'].' <br />
                '.$offer['destinationAdress'].'
              </p>
            </div>
          </div>
          <!-- ./3rd-col -->
        </div>
        <!-- ./row -->
      </div>';
  }

  public function create(int $userId, int $driver, string $title, string $information, int $price, int $seats, int $startAt, int $startPlz, string $startCity, string $startAdress, int $destinationPlz, string $destinationCity, string $destinationAdress)
  {
    require $this->sqlPHP;

    $createdAt = time();
    $insert = $con->prepare("INSERT INTO `cshare_rides` (`creatorId`, `driver`, `title`, `information`, `price`, `seats`, `startAt`, `startPlz`, `startCity`, `startAdress`, `destinationPlz`, `destinationCity`, `destinationAdress`, `createdAt`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert->bind_param("iissiiiississi", $userId, $driver, $title, $information, $price, $seats, $startAt, $startPlz, $startCity, $startAdress, $destinationPlz, $destinationCity, $destinationAdress, $createdAt);
    $insert->execute();

    return array('inserted_id' => $insert->insert_id, 'error' => $insert->error == "" ? null : $insert->error);
    $insert->close();
    $con->close();
  }

  public function delete(int $rideId)
  {
    require $this->sqlPHP;

    $delete = $con->prepare("DELETE FROM `cshare_rides` WHERE `rideId`=?");
    $delete->bind_param("i", $rideId);
    $delete->execute();

    return array('affected_rows' => $delete->affected_rows, 'error' => $delete->error == "" ? null : $delete->error);
    $delete->close();
    $con->close();
  }

  public function getFavorites(int $userId)
  {
    require $this->sqlPHP;

    $arr = array();
    $select = $con->query("SELECT cshare_favorites.rideId, cshare_rides.creatorId, cshare_rides.driver, cshare_rides.title, cshare_rides.information, cshare_rides.price, cshare_rides.seats, cshare_rides.startAt, cshare_rides.startPlz, cshare_rides.startCity, cshare_rides.startAdress, cshare_rides.destinationPlz, cshare_rides.destinationCity, cshare_rides.destinationAdress, cshare_rides.createdAt, cshare_user.name, cshare_user.surname, cshare_user.email, cshare_user.telNumber 
                          FROM cshare_rides
                          INNER JOIN cshare_user ON cshare_rides.creatorId = cshare_user.userId
                          INNER JOIN cshare_favorites ON cshare_rides.rideId = cshare_favorites.rideId
                          WHERE cshare_favorites.userId = '".$userId."' ORDER BY cshare_rides.createdAt DESC");
    while ($data = $select->fetch_assoc()) {
      $arr[] = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function getUserOffers(int $userId)
  {
    require $this->sqlPHP;

    $arr = array();
    $now = time();
    $select = $con->query("SELECT cshare_rides.rideId, cshare_rides.creatorId, cshare_rides.driver, cshare_rides.title, cshare_rides.information, cshare_rides.price, cshare_rides.seats, cshare_rides.startAt, cshare_rides.startPlz, cshare_rides.startCity, cshare_rides.startAdress, cshare_rides.destinationPlz, cshare_rides.destinationCity, cshare_rides.destinationAdress, cshare_rides.createdAt, cshare_user.name, cshare_user.surname, cshare_user.email, cshare_user.telNumber 
                          FROM cshare_rides
                          INNER JOIN cshare_user ON cshare_rides.creatorId = cshare_user.userId
                          WHERE cshare_rides.startAt >= '".$now."' 
                          AND cshare_rides.creatorId = '".$userId."' 
                          ORDER BY cshare_rides.createdAt DESC");
    while ($data = $select->fetch_assoc()) {
      $arr[] = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function get(int $rideId)
  {
    require $this->sqlPHP;

    $arr = array();
    $select = $con->query("SELECT cshare_rides.rideId, cshare_rides.creatorId, cshare_rides.driver, cshare_rides.title, cshare_rides.information, cshare_rides.price, cshare_rides.seats, cshare_rides.startAt, cshare_rides.startPlz, cshare_rides.startCity, cshare_rides.startAdress, cshare_rides.destinationPlz, cshare_rides.destinationCity, cshare_rides.destinationAdress, cshare_rides.createdAt, cshare_user.name, cshare_user.surname, cshare_user.email, cshare_user.telNumber 
                          FROM cshare_rides
                          INNER JOIN cshare_user ON cshare_rides.creatorId = cshare_user.userId
                          WHERE cshare_rides.rideId = '".$rideId."' ORDER BY cshare_rides.createdAt DESC");
    while ($data = $select->fetch_assoc()) {
      $arr = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function getAll()
  {
    require $this->sqlPHP;

    $arr = array();
    $now = time();
    $select = $con->query("SELECT cshare_rides.rideId, cshare_rides.creatorId, cshare_rides.driver, cshare_rides.title, cshare_rides.information, cshare_rides.price, cshare_rides.seats, cshare_rides.startAt, cshare_rides.startPlz, cshare_rides.startCity, cshare_rides.startAdress, cshare_rides.destinationPlz, cshare_rides.destinationCity, cshare_rides.destinationAdress, cshare_rides.createdAt, cshare_user.name, cshare_user.surname, cshare_user.email, cshare_user.telNumber 
                          FROM cshare_rides
                          INNER JOIN cshare_user ON cshare_rides.creatorId = cshare_user.userId
                          WHERE cshare_rides.startAt >= '".$now."' ORDER BY cshare_rides.createdAt DESC");
    while ($data = $select->fetch_assoc()) {
      $arr[] = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function getOffers()
  {
    require $this->sqlPHP;

    $arr = array();
    $now = time();
    $select = $con->query("SELECT cshare_rides.rideId, cshare_rides.creatorId, cshare_rides.driver, cshare_rides.title, cshare_rides.information, cshare_rides.price, cshare_rides.seats, cshare_rides.startAt, cshare_rides.startPlz, cshare_rides.startCity, cshare_rides.startAdress, cshare_rides.destinationPlz, cshare_rides.destinationCity, cshare_rides.destinationAdress, cshare_rides.createdAt, cshare_user.name, cshare_user.surname, cshare_user.email, cshare_user.telNumber 
                          FROM cshare_rides
                          INNER JOIN cshare_user ON cshare_rides.creatorId = cshare_user.userId
                          WHERE cshare_rides.startAt >= '".$now."' AND cshare_rides.driver = '1' ORDER BY cshare_rides.createdAt DESC");
    while ($data = $select->fetch_assoc()) {
      $arr[] = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function getRequests()
  {
    require $this->sqlPHP;

    $arr = array();
    $now = time();
    $select = $con->query("SELECT cshare_rides.rideId, cshare_rides.creatorId, cshare_rides.driver, cshare_rides.title, cshare_rides.information, cshare_rides.price, cshare_rides.seats, cshare_rides.startAt, cshare_rides.startPlz, cshare_rides.startCity, cshare_rides.startAdress, cshare_rides.destinationPlz, cshare_rides.destinationCity, cshare_rides.destinationAdress, cshare_rides.createdAt, cshare_user.name, cshare_user.surname, cshare_user.email, cshare_user.telNumber 
                          FROM cshare_rides
                          INNER JOIN cshare_user ON cshare_rides.creatorId = cshare_user.userId
                          WHERE cshare_rides.startAt >= '".$now."' AND cshare_rides.driver = '0' ORDER BY cshare_rides.createdAt DESC");
    while ($data = $select->fetch_assoc()) {
      $arr[] = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }
}