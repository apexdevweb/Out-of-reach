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
      $req_access_admin = "CALL AdminToAdminPage(?)";
      $req_get_access = $this->bdd->prepare($req_access_admin);
      $req_get_access->execute([$_SESSION['admin_data']['admin_id']]);

      $admin_valid_access = $req_get_access->fetch(PDO::FETCH_ASSOC);
      $req_get_access->closeCursor();


      if ($admin_valid_access) {
        return hash_equals($admin_valid_access['admin_ofr_key'], $_SESSION['admin_data']['admin_key']);
      }
    } catch (PDOException $e) {
      echo "ERROR ACCESS ADMINISTRATION" . $e->getMessage();
    }
  }
  public function getAllUsersForAdmin(): array
  {
    try {
      $req_get_users = "SELECT * FROM ofr_users ORDER BY usr_id DESC";
      $req_action_get_users = $this->bdd->prepare($req_get_users);
      $req_action_get_users->execute();
      return $req_action_get_users->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "ERROR GET USERS" . $e->getMessage();
    }
  }
  public function getAllVisits(): array
  {
    try {
      $req_get_visit = "SELECT * FROM ofr_visits ORDER BY date_visit DESC";
      $req_visit_get = $this->bdd->prepare($req_get_visit);
      $req_visit_get->execute();
      return $getAllVisit = $req_visit_get->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "ERROR GET IP AND DATE" . $e->getMessage();
    }
  }
  public function cleanVisitOnDb()
  {
    try {
      $req_clean_visit = "TRUNCATE TABLE ofr_visits";
      $req_clean_action = $this->bdd->prepare($req_clean_visit);
      $req_clean_action->execute();
    } catch (PDOException $e) {
      echo "ERROR CLEAN VISIT" . $e->getMessage();
      return false;
    }
  }
  public function addToBlacklist(string $ipToBan)
  {
    try {
      $req_banne_ip = "INSERT IGNORE INTO ofr_banned_ips (banned_adresse) VALUES (?)";
      $req_balcklisted = $this->bdd->prepare($req_banne_ip);
      return $req_balcklisted->execute([$ipToBan]);
    } catch (PDOException $e) {
      echo "BANNING ERROR" . $e->getMessage();
    }
  }
  public function verifyToBlacklist(string $ipToBan)
  {
    try {
      $req_banne_verify = "SELECT banned_ip_id FROM ofr_banned_ips WHERE banned_adresse = ?";
      $req_verify_action = $this->bdd->prepare($req_banne_verify);
      $req_verify_action->execute([$ipToBan]);
      return $req_verify_action->fetch() !== false ;
    } catch (PDOException $e) {
      echo "BANNING VERIFY ERROR" . $e->getMessage();
    }
  }
  public function getBlacklist(): array
  {
    try {
      $req_get_bl = "SELECT * FROM ofr_banned_ips ORDER BY banned_ip_id DESC";
      $req_bl_getting = $this->bdd->prepare($req_get_bl);
      $req_bl_getting->execute();
      return $req_bl_getting->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "BANNING VERIFY ERROR" . $e->getMessage();
      return[];
    }
  }
  public function removeToBlacklist(string $ipToUnBan)
  {
    try {
      $req_unbanne_ip = "DELETE FROM ofr_banned_ips WHERE banned_ip_id = ?";
      $req_balcklisted = $this->bdd->prepare($req_unbanne_ip);
      return $req_balcklisted->execute([$ipToUnBan]);
    } catch (PDOException $e) {
      echo "UNBANNING ERROR" . $e->getMessage();
      return false;
    }
  }
};
