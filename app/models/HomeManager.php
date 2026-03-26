<?php
require_once __DIR__ . "/../config/database.php";

class HomeManager
{
  private $bdd;

  public function __construct()
  {
    $database = new Ofr_db();
    $this->bdd = $database->getConnection();
  }

  public function getAllUsers(): array|bool
  {
    try {
      $req_get_users = "SELECT * FROM ofr_users";
      $action_get_users = $this->bdd->prepare($req_get_users);
      $action_get_users->execute();
      return $action_get_users->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "ERROR GET USERS" . $e->getMessage();
    }
  }
}
