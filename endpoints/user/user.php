<?php
namespace DulliAG\API;
require_once get_defined_constants()['BASEPATH']."endpoints/user/nanoid/Client.php";
use Hidehalo\Nanoid\Client;

class User 
{
  public $alphabet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  public $size = 16;
  public $avatar = array('size' => 256, 'backgroundColor' => '023846', 'color' => 'e27a00');

  public function getAvatarUrl(string $username)
  {
    return "https://eu.ui-avatars.com/api/?name=".$username."&size=".$this->avatar['size']."&background=".$this->avatar['backgroundColor']."&color=".$this->avatar['color']."";
  }

  public function register(string $name, string $surname, string $email, string $password, string $telNumber)
  {
    require get_defined_constants()['CON_PATH'];
    
    $userExist = $this->exist($email);
    if (!$userExist['registered']) {

      if ($this->validateEmail($email)) {
        $hashedPassword = hash("md5", $password);
        /**
         * API-Key generated by NanoID
         * https://zelark.github.io/nano-id-cc/
         * ~1 thousand years needed, in order to have a 1% probability of at least one collision.
         * @ 1000 ID/s per second
         */
        $client = new Client();
        $apiKey = $client->formattedId($this->alphabet, $this->size);
        $insert = $con->prepare("INSERT INTO `cshare_user` (name, surname, email, password, telNumber, apiKey) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssss", $name, $surname, $email, $hashedPassword, $telNumber, $apiKey);
        $insert->execute();
        return array('inserted_id' => $insert->insert_id, 'error' => $insert->error == "" ? null : $insert->error);
      } else {
        return array('email' => $email, 'error' => 'auth/invalid-email-provider');
      }
    } else {
      return array('email' => $email, 'error' => 'auth/user-already-exist');
    }

    $insert->close();
    $con->close();
  }

  /** 
   * Validate an email adress
   * Only a few email provider are allowed to sign-up as an user to this application
   * You can find and edit the list of allowed email providers in the index.php or retrieve the list using get_defined_constants()['SETTINGS']['email']
   */
  public function validateEmail(string $email) 
  {
    $allowedEmailProvider = get_defined_constants()['SETTINGS']['email'];
    $insertedEmail = explode("@", $email);
    $emailProvider = $insertedEmail[1];
    return in_array($emailProvider, $allowedEmailProvider);
  }

  public function sendVerificationEmail(int $userId)
  {
    $userData = $this->get($userId);
    // TODO Research what these headers mean
    // $headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
    // $headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
    // $headers .= "CC: susan@example.com\r\n";
    // $headers .= "MIME-Version: 1.0\r\n";
    // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($userData['email'], "BBS-Mitfahrzentrale", "This is the message!"/*, $headers*/);
  }

  public function verify(int $userId)
  {
    require get_defined_constants()['CON_PATH'];

    $update = $con->prepare("UPDATE `cshare_user` SET `verified`=1 WHERE `userId`=?");
    $update->bind_param("i", $userId);
    $update->execute();

    return array('affected_rows' => $update->affected_rows, 'error' => $update->error == "" ? null : $update->error);
    $update->close();
    $con->close();
  }

  public function checkCredentials(string $email, string $password)
  {
    require get_defined_constants()['CON_PATH'];

    $userExist = $this->exist($email);
    if ($userExist['registered']) {
      $hashedPassword = hash("md5", $password);
      $select = $con->query("SELECT `userId`, `isAdmin`, `email`, `apiKey` FROM `cshare_user` WHERE `email`='".$email."' AND `password`='".$hashedPassword."'");
      $result = $select->num_rows;
      if ($result == 1) {
        while ($data = $select->fetch_assoc()) {
          if (session_status() == PHP_SESSION_NONE) session_start();
          $userId = $data['userId'];
          $username = $data['email'];
          $apiKey = $data['apiKey'];
          if ($data['isAdmin'] == 1) {
            $isAdmin = true;
          } else {
            $isAdmin = false;
          }
          $_SESSION['login'] = array('isAdmin' => $isAdmin, 'userId' => $userId, 'email' => $username, 'apiKey' => $apiKey);
        }
        return array('loggedIn' => true, 'isAdmin' => $isAdmin, 'email' => $email, 'error' => null);
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

  public function isAdmin(int $userId)
  {
    require get_defined_constants()['CON_PATH'];

    $result = array();
    $select = $con->query("SELECT `isAdmin` from `cshare_user` WHERE `userId`='".$userId."' ");
    if ($select->num_rows > 0) {
      while ($row = $select->fetch_assoc()) {
        $isAdmin = $row['isAdmin'];
        if ($isAdmin == 1) {
          $isAdmin = true;
        } else {
          $isAdmin = false;
        }
        $result = $isAdmin;
      }
    } else {
      $result = array('userId' => $userId, 'isAdmin' => false, 'error' => 'auth/user-not-found');
    }

    return $result;
  }

  public function getAll()
  {
    require get_defined_constants()['CON_PATH'];

    $arr = array();
    $select = $con->query("SELECT * FROM `cshare_user` WHERE 1");
    while ($data = $select->fetch_assoc()) {
      $arr[] = $data;
    }

    return $arr;
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

  public function update(int $userId, int $isAdmin, int $isVerified, string $name, string $surname, string $email, string $telNumber, string $password)
  {
    require get_defined_constants()['CON_PATH'];

    if (is_null($password) || $password == "null") {
      $update = $con->prepare("UPDATE `cshare_user` SET `verified`=?, `isAdmin`=?, `name`=?, `surname`=?, `email`=?, `telNumber`=? WHERE `userId`=?");
      $update->bind_param("iissssi", $isVerified, $isAdmin, $name, $surname, $email, $telNumber, $userId);
      $update->execute();
    } else {
      $hashedPassword = hash("md5", $password);
      $update = $con->prepare("UPDATE `cshare_user` SET `verified`=?, `isAdmin=?, `name`=?, `surname`=?, `email`=?, `telNumber`=?, `password`=? WHERE `userId`=?");
      $update->bind_param("iisssssi", $isVerified, $isAdmin, $name, $surname, $email, $telNumber, $hashedPassword, $userId);
      $update->execute();
    }

    return array('affected_rows' => $update->affected_rows, 'error' => $update->error == "" ? null : $update->error);
    $update->close();
    $con->close();
  }
}
