<?php
require_once __DIR__ . "/../models/ToolsManager.php";
class ToolsController
{
  public function toolsPage()
  {
    require_once __DIR__ . '/../views/layouts/tools.php';
  }
}