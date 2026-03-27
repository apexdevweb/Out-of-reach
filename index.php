<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require __DIR__ . "/app/security/csp.php";
header("Content-Security-Policy:" . $csp); // Autorise uniquement les scripts de votre propre domaine (à configurer pour CDN et API)
header("X-Frame-Options: DENY"); // Empêche l'affichage de votre site dans une iframe (anti-clickjacking)
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
  <header>
    <?php
    require "app/views/partials/_header.php";
    ?>
  </header>
  <main>
    <?php
    require "public/main.php";
    ?>
  </main>
  <footer>
    <?php
    require "app/views/partials/_footer.php";
    ?>
  </footer>
  <script defer src="<?= DataScript::FLAG_MENU ?>"></script>
  <script defer src="<?= DataScript::MOUSE_DATA ?>"></script>
  <script defer src="<?= DataScript::CHART_CDN ?>"></script>
  <script type="text/javascript">
    const ctx = document.getElementById("myChart").getContext("2d");
    const gradient = ctx.createLinearGradient(0, 0, ctx.canvas.width, 0);
    gradient.addColorStop(0, "#0099f7");
    gradient.addColorStop(1, "#f11712");
    new Chart(ctx, {
      type: "line",
      data: {
        labels: [
          "Janvier",
          "Fevrier",
          "Mars",
          "Avril",
          "Mais",
          "Juin",
          "juillet",
          "Aout",
          "Septembre",
          "Octobre",
          "Novembre",
          "Decembre",
        ],
        datasets: [{
          label: "Nombre de visites",
          data: <?php echo json_encode(array_values($monthlyCounts)); ?>,
          backgroundColor: "#fff",
          borderColor: gradient,
          borderWidth: 2,
          fill: false,
        }, ],
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  </script>
</body>

</html>