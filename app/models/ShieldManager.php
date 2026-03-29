<?php
require_once __DIR__ . "/../config/database.php";

class ShieldManager
{
  private $bdd;

  public function __construct()
  {
    $database = new Ofr_db();
    $this->bdd = $database->getConnection();
  }

  public function AdminAccess(string $user_ip)
  {
    try {
      $reqAdminAccess = $this->bdd->prepare("CALL AdminAccessByIp(?)");
      $reqAdminAccess->execute([$user_ip]);

      $adminAccessResult = $reqAdminAccess->fetch(PDO::FETCH_ASSOC);
      $reqAdminAccess->closeCursor();

      return $adminAccessResult;
    } catch (PDOException $e) {
      echo "ERROR ADMIN ACCESS" . $e->getMessage();
      return false;
    }
  }

  public function insertVisits(string $ip_visit): bool
  {
    try {
      $req_visit = "INSERT INTO ofr_visits (adress_visit, date_visit) VALUES (?, NOW())";
      $req_insert_visit = $this->bdd->prepare($req_visit);
      return $req_insert_visit->execute([$ip_visit]);
    } catch (PDOException $e) {
      echo "ERROR INSERT IP AND DATE" . $e->getMessage();
      return false;
    }
  }
}
