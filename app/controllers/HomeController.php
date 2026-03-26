<?php
require_once __DIR__ . "/../models/HomeManager.php";
class HomeController
{
  public function homePage()
  {
    $homeManager = new HomeManager();
    $user_list = $homeManager->getAllUsers();
    require_once __DIR__ . '/../views/layouts/home.php';
  }
}
