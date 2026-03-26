<?php
require_once __DIR__ . "/../config/database.php";

class AdminManager
{
  private $bdd;

  public function __construct()
  {
    $database = new Ofr_db();
    $this->bdd = $database->getConnection();
  }
  public function adminAccess(): bool
  {
    try {
      $req_access_admin = "SELECT admin_ofr_key FROM ofr_admin WHERE admin_ofr_id = ?";
      $req_get_access = $this->bdd->prepare($req_access_admin);
      $req_get_access->execute([$_SESSION['admin_data']['admin_id']]);

      $admin_valid_access = $req_get_access->fetch(PDO::FETCH_ASSOC);

      if ($admin_valid_access) {
        return hash_equals($admin_valid_access['admin_ofr_key'], $_SESSION['admin_data']['admin_key']);
      }
    } catch (PDOException $e) {
      echo "ERROR ACCESS ADMINISTRATION" . $e->getMessage();
    }
  }
};
