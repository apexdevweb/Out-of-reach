<?php
require_once __DIR__ . "/../models/TipsManager.php";
class TipsController
{
  public function tipsPage()
  {
    global $scripts_js;
    $scripts_js = [DataScript::VIEW_MENU];
    require_once __DIR__ . '/../views/layouts/tips.php';
  }
}
