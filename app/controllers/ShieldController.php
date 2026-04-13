<?php
require_once __DIR__ . "/../models/ShieldManager.php";
require_once __DIR__ . "/../security/SecureAdminKey.php";
require_once __DIR__ . "/../security/SecureAdminPin.php";
require_once __DIR__ . "/../class/Administrator.php";
require_once __DIR__ . "/../security/SecureUsersKey.php";
class ShieldController
{
  public function guardPage()
  {
    require_once __DIR__ . '/../views/layouts/guard_page.php';
  }
  public function accessControll()
  {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      if (isset($_POST['try_access'])) {
        if (!empty($_SERVER['REMOTE_ADDR']) && !empty($_POST['alpha_key'])) {
          $ip_original = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);

          $admin_crypted_key = new SecureAdminKey("OF4rS13CrIpt@88Enjo22yEr#noRa000");
          $users_random_crypted_key = new SecureUsersKey();
          $input_key = trim($_POST['alpha_key']);

          if ($admin_crypted_key->adminKeyVerify($input_key)) {
            $shield_management = new ShieldManager();
            $adminData =  $shield_management->AdminAccess($ip_original);
            if ($adminData && is_array($adminData)) {
              $_SESSION['pending_admin'] = $adminData;
              $admin = new Administrator($adminData['admin_ofr_id'], $adminData['admin_ofr_name'], $adminData['admin_ofr_key'], $adminData['admin_ofr_pin']);
            }

            $_SESSION['auth_admin'] = true;
            $_SESSION['admin_data'] = [
              "admin_id" => $admin->getAdminId(),
              "admin_name" => $admin->getAdminName(),
              "admin_key" => $admin->getAdminkey(),
              "admin_pin" => $admin->getAdminPin(),
            ];

            $home_admin_encrypted = Encryptor::encrypt('guard');
            header("Location: index.php?page=" . $home_admin_encrypted);
            exit();
          } elseif ($users_random_crypted_key->usersVerify($input_key)) {
            $home_members_encrypted = Encryptor::encrypt('home');
            header("Location: index.php?page=" . $home_members_encrypted);
            exit();
          } else {
            $error_key_msg = DataText::ERROR_KEY;
          }
        }
      }
      if (isset($_POST['validate_pin']) && !empty($_POST['secure_pin'])) {
        $user_pin = $_POST['secure_pin'];
        if (strlen($user_pin) === 8 && ctype_digit($user_pin)) {
        $secure_pin = new SecureAdminPin($adminData['admin_ofr_pin']);
        } else {
          # code...
        }
      }
    }
  }
  public function insertionVisits(): bool
  {
    $visit_success = false;
    if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
      $ip_visit = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
      if ($ip_visit) {
        $visit_management = new ShieldManager();
        $visit_management->insertVisits($ip_visit);
      }
    }
    return $visit_success;
  }
}
