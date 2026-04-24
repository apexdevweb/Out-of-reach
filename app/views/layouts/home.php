<section class="home__container">
  <ul class="users__list--container">
    <li class="users_list--sticker">Online members</li>
    <?php
    foreach ($user_list as $user_profil) {
    ?>
      <div class="user__card--container">
        <span class="user__light"></span>
        <li class="users__el"><?= htmlspecialchars($user_profil['usr_name']) ?></li>
      </div>
    <?php
    }
    ?>
  </ul>
  <div class="sector__container">
    <div class="sector__choice">
      <h2 class="sector__choice--title"><?= DataText::SECTOR_ENGINERING ?></h2>
    </div>
    <div class="sector__choice">
      <h2 class="sector__choice--title"><?= DataText::SECTOR_DEFENCE ?></h2>
    </div>
    <div class="sector__choice">
      <h2 class="sector__choice--title"><?= DataText::SECTOR_ATTACK ?></h2>
    </div>
  </div>
</section>