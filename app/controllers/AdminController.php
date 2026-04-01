<?php
require_once __DIR__ . "/../models/AdminManager.php";
require_once __DIR__ . "/../security/SecureUsersKey.php";
class AdminController
{
  public function adminPage()
  {
    $adminAccessManager = new AdminManager();
    if ($adminAccessManager->adminAccess()) {

      $all_visits = $adminAccessManager->getAllVisits();
      $monthlyCounts = array_fill(1, 12, 0);
      if (is_array($all_visits)) {
        foreach ($all_visits as $visit) {
          $visit['adress_visit'];
          $dateRaw = $visit['date_visit'];
          $month = (int)date('n', strtotime($dateRaw));
          $monthlyCounts[$month]++;
        }
      }
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['generate'])) {
          $user_access_key = new SecureUsersKey();
          $user_temporary_key = $user_access_key->getSecureKey();
          $_SESSION['user_access_key'] = $user_temporary_key;
        }
        if (isset($_POST['clean'])) {
          $adminAccessManager->cleanVisitOnDb();
        }

        if (isset($_POST['search_action'])) {
          if (!empty($_POST['users_search'])) {
            $adminAccessManager->getUserForAdmin($_POST['users_search']);
          }
        }
        $admin_page_encryptor = Encryptor::encrypt('administration');
        header("Location: index.php?page=" . $admin_page_encryptor);
        exit;
      }
      if (isset($_GET['adress_visit']) && !empty($_GET['adress_visit'])) {
        $adminAccessManager->addToBlacklist($_GET['adress_visit']);
        $admin_page_encryptor = Encryptor::encrypt('administration');
        header("Location: index.php?page=" . $admin_page_encryptor);
        exit;
      }

      $viewBlacklist = $adminAccessManager->getBlacklist();

      if (isset($_GET['unban_ip']) && !empty($_GET['unban_ip'])) {
        $adminAccessManager->removeToBlacklist($_GET['unban_ip']);
        $admin_page_encryptor = Encryptor::encrypt('administration');
        header("Location: index.php?page=" . $admin_page_encryptor);
        exit;
      }
      require_once __DIR__ . '/../views/layouts/administration.php';
    } else {
      $admin_page_encryptor = Encryptor::encrypt('guard');
      header("Location: index.php?page=" . $admin_page_encryptor);
      exit;
    }
  }
}
