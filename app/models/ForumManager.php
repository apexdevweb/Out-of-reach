<?php
require_once __DIR__ . "/../config/database.php";

class ForumManager
{
  private $bdd;

  public function __construct()
  {
    $database = new Ofr_db();
    $this->bdd = $database->getConnection();
  }
}