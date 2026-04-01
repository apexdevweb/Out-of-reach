<?php
require_once __DIR__ . "/../config/database.php";

class TipsManager
{
  private $bdd;

  public function __construct()
  {
    $database = new Ofr_db();
    $this->bdd = $database->getConnection();
  }
}
