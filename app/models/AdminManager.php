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
  public function getUserForAdmin(): array
  {
    try {
      $search = "%" . $_POST['users_search'] . "%";
      $req_get_users = "SELECT * FROM ofr_users WHERE usr_name LIKE ?";
      $req_action_get_users = $this->bdd->prepare($req_get_users);
      $req_action_get_users->execute([$search]);
      return $get_all_users = $req_action_get_users->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "ERROR GET USERS" . $e->getMessage();
    }
  }
  public function getAllVisits(): array
  {
    try {
      $req_get_visit = "SELECT * FROM ofr_visits";
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
};
