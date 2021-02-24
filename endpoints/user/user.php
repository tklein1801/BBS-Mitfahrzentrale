<?php
namespace DulliAG\API;
require_once get_defined_constants()['BASEPATH']."endpoints/user/nanoid/Client.php";
use Hidehalo\Nanoid\Client;

class User 
{
  public $alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  public $size = 16;

  public function register(string $name, string $surname, string $email, string $password, string $adress, int $plz, string $place, string $telNumber)
  {
    require get_defined_constants()['CON_PATH'];
    
    $userExist = $this->exist($email);
    if (!$userExist['registered']) {
      $hashedPassword = hash("md5", $password);
      /**
       * API-Key generated by NanoID
       * https://zelark.github.io/nano-id-cc/
       * ~1 thousand years needed, in order to have a 1% probability of at least one collision.
       * @ 1000 ID/s per second
       */
      $client = new Client();
      $apiKey = $client->formattedId($this->alphabet, $this->size);
      $insert = $con->prepare("INSERT INTO `cshare_user` (name, surname, email, password, adress, plz, city, telNumber, apiKey) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insert->bind_param("sssssisss", $name, $surname, $email, $hashedPassword, $adress, $plz, $place, $telNumber, $apiKey);
      $insert->execute();
      return array('inserted_id' => $insert->insert_id, 'error' => $insert->error == "" ? null : $insert->error);
    } else {
      return array('email' => $email, 'error' => 'auth/user-already-exist');
    }

    $insert->close();
    $con->close();
  }

  public function checkCredentials(string $email, string $password)
  {
    require get_defined_constants()['CON_PATH'];

    $userExist = $this->exist($email);
    if ($userExist['registered']) {
      $hashedPassword = hash("md5", $password);
      $select = $con->query("SELECT `userId`, `email`, `apiKey` FROM `cshare_user` WHERE `email`='".$email."' AND `password`='".$hashedPassword."'");
      $result = $select->num_rows;
      if ($result == 1) {
        while ($data = $select->fetch_assoc()) {
          if (session_status() == PHP_SESSION_NONE) session_start();
          $userId = $data['userId'];
          $username = $data['email'];
          $apiKey = $data['apiKey'];
          $_SESSION['login'] = array('userId' => $userId, 'email' => $username, 'apiKey' => $apiKey);
        }
        return array('loggedIn' => true, 'email' => $email, 'error' => null);
      } else {
      return array('loggedIn' => false, 'email' => $email, 'error' => 'auth/password-invalid');
      }
    } else {
      return array('email' => $email, 'error' => 'auth/user-not-found');
    }

    $select->close();
    $con->close();
  }

  public function destroySession()
  {
    session_start();
    session_destroy();
  }

  public function exist(string $email)
  {
    require get_defined_constants()['CON_PATH'];

    $select = $con->query("SELECT `userId` FROM `cshare_user` WHERE `email`='".$email."'");
    $result = $select->num_rows;

    return array('email' => $email, 'registered' => $result == 1 ? true : false);
    $select->close();
    $con->close();
  }

  public function verifyKey(string $apiKey)
  {
    require get_defined_constants()['CON_PATH'];

    $select = $con->query("SELECT `userId` FROM `cshare_user` WHERE `apiKey`='".$apiKey."'");
    $result = $select->num_rows;
    if($result == 1) {
      $response = array();
      while ($data = $select->fetch_assoc()) {
        $response = array('authentificated' => true, 'userId' => $data['userId'], 'error' => null);
      }
      return $response;
    } else {
      return array('authentificated' => false, 'error' => 'auth/key-invalid');
    }

    $select->close();
    $con->close();
  }

  public function get(int $userId)
  {
    require get_defined_constants()['CON_PATH'];

    $arr = array();
    $select = $con->query("SELECT * FROM `cshare_user` WHERE `userId`='".$userId."'");
    while ($data = $select->fetch_assoc()) {
      $arr = $data;
    }

    return $arr;
    $select->close();
    $con->close();
  }

  public function update(int $userId, /*string $email,*/ string $telNumber, string $password)
  {
    require get_defined_constants()['CON_PATH'];

    // $update = $con->prepare("UPDATE `cshare_user` SET `email`=?, `telNumber`=?, `password`=? WHERE `userId`=?");
    // $update->bind_param("sssi", $email, $telNumber, $hashedPassword, $userId);
    if (is_null($password)) {
      $update = $con->prepare("UPDATE `cshare_user` SET `telNumber`=? WHERE `userId`=?");
      $update->bind_param("si", $telNumber, $userId);
      $update->execute();
    } else {
      $hashedPassword = hash("md5", $password);
      $update = $con->prepare("UPDATE `cshare_user` SET `telNumber`=?, `password`=? WHERE `userId`=?");
      $update->bind_param("ssi", $telNumber, $hashedPassword, $userId);
      $update->execute();
    }

    return $update;
    $update->close();
    $con->close();
  }
}
