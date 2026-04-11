<div class="profil__card">
  <div class="profil__sub--container">
    <span class="profil__stickers">Admin</span>
    <h2 class="profil__name"><?= $_SESSION['admin_data']['admin_name'] ?></h2>
  </div>
  <hr class="profil__separate">
  <div class="profil__btn--container">
    <a href="index.php?page=<?= Encryptor::encrypt('administration') ?>" class="profil__btn"><?= DataText::NAV_ADMIN_ADMIN_PAGE ?></a>
    <a href="index.php?page=<?= Encryptor::encrypt('logout') ?>" class="profil__btn"><?= DataText::NAV_ADMIN_LOGOUT ?></a>
  </div>
</div>