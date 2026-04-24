<?php
if (isset($_POST['face_data'])) {
  $shieldManager = new ShieldManager();

  $encrypted_face_data = Encryptor::encrypt($_POST['face_data']);
  // Remplace 1 par ton ID admin réel
  if ($shieldManager->registerAdminFace(1, $encrypted_face_data)) {
    echo "Empreinte faciale enregistrée avec succès !";
  }
}
?>
<div class="enroll__container">
  <h2 class="enroll__title"><?= DataText::FACE_ENROLL_TITLE ?></h2>
  <p id="status" class="enroll__status"><?= DataText::FACE_ENROLL_STATUS ?></p>
  <div style="position: relative;" class="enroll__vid--container">
    <video id="video" class="enroll__vid" autoplay muted></video>
    <canvas id="overlay" class="enroll__canvas"></canvas>
  </div>
  <form method="post" id="enroll_form">
    <input type="hidden" name="face_data" id="face_data">
    <button type="submit" id="capture_btn" class="enroll__btn" disabled>En attente de detecter un visage</button>
  </form>
</div>
