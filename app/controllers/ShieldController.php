<?php
require_once __DIR__ . "/../models/ShieldManager.php";
require_once __DIR__ . "/../class/Administrator.php";
require_once __DIR__ . "/../security/SecureAdminKey.php";
require_once __DIR__ . "/../security/SecureAdminPin.php";
require_once __DIR__ . "/../security/SecureUsersKey.php";
class ShieldController
{
  public function guardPage()
  {
    global $scripts_js;
    $scripts_js = [DataScript::FACIAL_API_SHIELD, DataScript::FACIAL_RECOGNITION_LOGIN, DataScript::MOUSE_DATA, DataScript::FLAG_MENU, DataScript::PIN_SHIELD];
    require_once __DIR__ . '/../views/layouts/guard_page.php';
  }
  public function faceRegisterPage()
  {
    global $scripts_js;
    $scripts_js = [DataScript::FACIAL_API_SHIELD, DataScript::FACIAL_RECOGNITION_REGISTRATION];
    require_once __DIR__ . '/../views/layouts/face_register.php';
  }
  public function accessControll()
  {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      // ETAPE CLE UNIQUE
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
            }
            $guard_admin_encrypted = Encryptor::encrypt('guard');
            header("Location: index.php?page=" . $guard_admin_encrypted);
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
      // ETAPE CODE PIN
      if (isset($_POST['validate_pin']) && !empty($_POST['secure_pin'])) {
        $user_pin = $_POST['secure_pin'];
        $adminData = $_SESSION['pending_admin'];

        if (!isset($_SESSION['try_pin_counter'])) {
          $_SESSION['try_pin_counter'] = 3;
        }
        if (strlen($user_pin) === 8 && ctype_digit($user_pin)) {
          $secure_checker_pin = new SecureAdminPin($adminData['admin_ofr_pin']);

          if ($secure_checker_pin->adminPinVerify($user_pin)) {
            $_SESSION['try_pin_counter'] = 3;

            $_SESSION['pin_verified'] = true;
            header("Location: index.php?page=" . Encryptor::encrypt('guard'));
            exit();
          } else {
            $_SESSION['try_pin_counter']--;
            sleep(2);
            if ($_SESSION['try_pin_counter'] <= 0) {
              $shieldblock = new ShieldManager();
              $shieldblock->shieldToBlacklist($_SERVER['REMOTE_ADDR'], "3 échecs PIN");
              session_destroy();
              http_response_code(403);
              die("<div style='position: fixed; top: 0; left: 0; display: flex; align-items: center; justify-content: center; height: 100vh; width: 100%; z-index: 999; background-color: #000;'>
              <p style='color: #fff; font-size: 4rem; text-align: center; letter-spacing: 2px;'>ERROR(403):Too many attempts you are blocked.</p>
              </div>");
            }
          }
        } else {
          $error_key_msg = DataText::ERROR_KEY;
        }
      }
      // ETAPE RECONAISSANCE FACIALE
      if (isset($_POST['validate_face']) && isset($_SESSION['pin_verified'])) {
        $adminData = $_SESSION['pending_admin'];
        $shield_management = new ShieldManager();

        if ($shield_management->verifyBiometry($_POST['face_descriptor'], $adminData['admin_ofr_face'])) {
          // SUCCÈS TOTAL : Connexion finale
          $admin = new Administrator($adminData['admin_ofr_id'], $adminData['admin_ofr_name'], $adminData['admin_ofr_key'], $adminData['admin_ofr_pin']);
          $_SESSION['auth_admin'] = true;
          $_SESSION['admin_data'] = [
            "admin_id" => $admin->getAdminId(),
            "admin_name" => $admin->getAdminName(),
            "admin_key" => $admin->getAdminkey(),
            "admin_pin" => $admin->getAdminPin(),
          ];
          unset($_SESSION['pending_admin'], $_SESSION['pin_verified'], $_SESSION['try_pin_counter']);
          header("Location: index.php?page=" . Encryptor::encrypt('home'));
          exit();
        } else {
          $error_biometry = "Visage non reconnu. Accès refusé.";
          exit();
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
