<section class="home__container">
  <ul class="users__list--container">
    <?php
       foreach ($user_list as $user_profil) {
    ?>
    <li class="users__el"><?= htmlspecialchars($user_profil['usr_name']) ?></li>
    <?php
    }
    ?>
  </ul>
  <div class="sector__container">
    <div class="sector__choice">
      <h2 class="sector__choice--title"><?= DataText::SECTOR_DEFENCE ?></h2>
    </div>
    <div class="sector__choice">
      <h2 class="sector__choice--title"><?= DataText::SECTOR_ATTACK ?></h2>
    </div>
  </div>
</section>