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
  
  public function insertVisits(string $ip_visit): void
  {
    if (!empty($ip_visit)) {
      try {
          $insert_ip = $this->bdd->prepare("INSERT INTO visits (adresse_visit, date_visit) VALUES (?,?)");
          $insert_ip->execute([$ip_visit, $date_visit]);
      } catch (PDOException $e) {
          echo "Erreur d'insertion de l'adresse ip" . $e->getMessage();
      }
  }
  }
  // public function usersAccess(): void
  // {
  //   try {
      
  //   } catch (PDOException $e) {
  //     echo "ERROR USERS ACCESS" . $e->getMessage();
  //   }
  // }
}