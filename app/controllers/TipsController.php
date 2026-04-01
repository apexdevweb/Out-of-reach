<?php
require_once __DIR__ . "/../models/TipsManager.php";
class TipsController
{
  public function tipsPage()
  {
    require_once __DIR__ . '/../views/layouts/tips.php';
  }
}