<?php
require_once __DIR__ . "/../models/AdminManager.php";
require_once __DIR__ . "/../security/SecureUsersKey.php";
class AdminController
{
  public function adminPage()
  {
    $adminAccessManager = new AdminManager();
    if ($adminAccessManager->adminAccess()) {

    $user_access_key = new SecureUsersKey();
    $user_temporary_key = $user_access_key->getSecureKey();

    $_SESSION['user_access_key'] = $user_temporary_key;
    
    $getAllUsersForAdmin = $adminAccessManager->getUserForAdmin();

      require_once __DIR__ . '/../views/layouts/administration.php';
    } else {
      header("Location: index.php?page=guard");
      exit;
    }
  }
}