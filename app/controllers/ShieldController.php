<?php
require_once __DIR__ . "/../models/ShieldManager.php";
require_once __DIR__ . "/../security/SecureAdminKey.php";
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
              $admin = new Administrator($adminData['admin_ofr_id'], $adminData['admin_ofr_name'], $adminData['admin_ofr_key']);
            }
            $_SESSION['auth_admin'] = true;
            $_SESSION['admin_data'] = [
              "admin_id" => $admin->getAdminId(),
              "admin_name" => $admin->getAdminName(),
              "admin_key" => $admin->getAdminkey(),
            ];
            $home_admin_encrypted = Encryptor::encrypt('home');
            header("Location: index.php?page=" . $home_admin_encrypted);
            exit();
          } elseif ($users_random_crypted_key->usersVerify($input_key)) {
            $home_members_encrypted = Encryptor::encrypt('home');
            header("Location: index.php?page=". $home_members_encrypted);
            exit();
          } else {
            $error_key_msg = DataText::ERROR_KEY;
          }
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
