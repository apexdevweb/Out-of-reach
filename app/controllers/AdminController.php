<?php
require_once __DIR__ . "/../models/AdminManager.php";
class AdminController
{
  public function adminPage()
  {
    $adminAccessManager = new AdminManager();
    if ($adminAccessManager->adminAccess()) {
      require_once __DIR__ . '/../views/layouts/administration.php';
    } else {
      header("Location: index.php?page=guard");
      exit;
    }
  }
}