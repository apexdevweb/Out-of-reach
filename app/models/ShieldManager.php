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
      echo "ERROR ADMIN ACCESS" . $e->getMessage(); //à retirer pour lancer en production
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
      echo "ERROR INSERT IP AND DATE" . $e->getMessage(); //à retirer pour lancer en production
      return false;
    }
  }
  public function shieldToBlacklist(string $ipToBan)
  {
    try {
      $req_banne_ip = "INSERT IGNORE INTO ofr_banned_ips (banned_adresse) VALUES (?)";
      $req_balcklisted = $this->bdd->prepare($req_banne_ip);
      return $req_balcklisted->execute([$ipToBan]);
    } catch (PDOException $e) {
      echo "BANNING ERROR" . $e->getMessage();
    }
  }

  public function registerAdminFace(int $adminId, string $jsonFaceData): bool
  {
    try {
      $sql = "UPDATE ofr_admin SET admin_ofr_face = :face WHERE admin_ofr_id = :id";
      $stmt = $this->bdd->prepare($sql);
      return $stmt->execute([
        ':face' => $jsonFaceData,
        ':id'   => $adminId
      ]);
    } catch (PDOException $e) {
      return false;
    }
  }

  public function verifyBiometry(string $jsonDescriptor, string $jsonEncryptedReference): bool
  {
    $decryted_face_data = Encryptor::decrypt($jsonEncryptedReference);

    if (!$decryted_face_data) {
     return false;
    }

    $currentFace = json_decode($jsonDescriptor, true);
    $referenceFace = json_decode($decryted_face_data, true);

    if (is_array($currentFace) && is_array($referenceFace)) {
      $distance = $this->euclideanDistance($currentFace, $referenceFace);

      // Seuil de sécurité : 0.45 est un excellent compromis entre sécurité et confort
      return ($distance < 0.45);
    }
    return false;
  }
  private function euclideanDistance(array $face1, array $face2): float
  {
    $sum = 0;
    for ($i = 0; $i < count($face1); $i++) {
      $sum += pow($face1[$i] - $face2[$i], 2);
    }
    return sqrt($sum);
  }
}
