<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
};
require_once __DIR__ . "/app/core/Encryptor.php";
require __DIR__ . "/app/security/csp.php";
header("Content-Security-Policy:" . $csp); // Autorise uniquement les scripts de notre propre domaine (à configurer pour CDN et API)
header("X-Frame-Options: DENY"); // Empêche l'affichage de notre site dans une iframe (anti-clickjacking)
header("X-Content-Type-Options: nosniff"); // Empêche l'interprétation de fichiers MIME non déclarés
require_once 'app/config/database.php';
require_once __DIR__ . '/app/config/DataLink.php';
require_once __DIR__ . '/app/config/DataText.php';
require_once __DIR__ . '/app/config/DataScript.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <?php
  require "app/views/partials/_head.php";
  ?>
</head>

<body>
  <header class="main__header">
    <?php
    require "app/views/partials/_header.php";
    ?>
  </header>
  <main>
    <?php
    require "public/main.php";
    ?>
  </main>
  <footer class="main__footer">
    <?php
    require "app/views/partials/_footer.php";
    ?>
  </footer>
  <script src="<?= DataScript::FLAG_MENU ?>"></script>
  <script src="<?= DataScript::MOUSE_DATA ?>"></script>
  <script src="<?= DataLink::CHART_CDN ?>"></script>
  <script src="<?= DataScript::CHART_JS ?>"></script>
  <script src="<?= DataScript::VIEW_MENU ?>"></script>
</body>

</html>