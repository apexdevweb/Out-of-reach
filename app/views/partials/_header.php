<h1 class="primary__title"><?= DataText::PRIMARY_TITLE ?></h1>
<?php
if (isset($_SESSION['auth_admin']) && isset($_SESSION['admin_data']['admin_key'])) {
  require_once __DIR__ . '/_nav.php';
  require_once __DIR__ . '/_admin_profil.php';
} else {
?>
<ul class="small__subtitle--container">
  <li class="subtitle__el"><small><?= DataText::SECONDARY_TITLEA ?></small></li>
  <li class="subtitle__el"><small><?= DataText::SECONDARY_TITLEB ?></small></li>
  <li class="subtitle__el"><small><?= DataText::SECONDARY_TITLEC ?></small></li>
  <li class="subtitle__el">
    <span class="flag__arrow">↓</span>
    <div class="flag__container">
      <img src="<?= DataLink::FLAG_UK ?>" alt="ukFlag" class="flag">
      <img src="<?= DataLink::FLAG_FRANCE ?>" alt="frFlag" class="flag">
      <img src="<?= DataLink::FLAG_GERMANY ?>" alt="delag" class="flag">
      <img src="<?= DataLink::FLAG_HOLLANDE ?>" alt="pbFlag" class="flag">
    </div>
  </li>
  <li class="subtitle__el">
    <img src="<?= DataLink::VIEW_LOGO ?>" alt="eyeOFR" class="logo__data">
    <p id="mouse_data"></p>
  </li>
</ul>
<?php
}
?>
