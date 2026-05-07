<?php
require_once __DIR__ . "/../models/TipsManager.php";
require_once __DIR__ . "/../config/DataTextStructure.php";
class jsStructController
{
  public function jsPage()
  {
    global $scripts_js;
    $scripts_js = [DataScript::STRUCT_CASE_ANIME];
    require_once __DIR__ . '/../views/layouts/js_view_struct.php';
  }
}
