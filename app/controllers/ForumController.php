<?php
require_once __DIR__ . "/../models/ForumManager.php";
class ForumController
{
  public function forumPage()
  {
    require_once __DIR__ . '/../views/layouts/forum.php';
  }
}