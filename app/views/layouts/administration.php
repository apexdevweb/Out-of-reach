<section class="administration__container">
  <div class="administration__wrapper">
    <div class="administration__sub--container">
      <h3 class="administration__sub--title">Uniq register key for news users</h3>
      <?php
      if (isset($_SESSION['user_encrypt_access_key'])) {
      ?>
        <div class="key__container">
          <p class="user__key__el"><?= $_SESSION['user_encrypt_access_key'] ?></p>
        </div>
      <?php
      } elseif (isset($_SESSION['user_decrypt_access_key'])) {
      ?>
        <div class="key__container">
          <p class="user__key__el"><?= $_SESSION['user_decrypt_access_key'] ?></p>
        </div>
      <?php
      } else {
      ?>
        <div class="key__container">
          <p class="user__key__el">...</p>
        </div>
      <?php
      }
      ?>
      <form method="post">
        <input type="submit" value="Generate-new-key" name="generate" class="generate__btn">
        <?php
        if (isset($_SESSION['user_encrypt_access_key'])) {
        ?>
          <input type="submit" value="Decrypt-new-key" name="decrypt" class="decrypt__btn">
        <?php
        }
        ?>
      </form>
    </div>
    <div class="administration__sub--container">
      <h3 class="administration__sub--title">Globale users register</h3>
      <div class="search__result--container">
        <?php
        if (!empty($viewAllUsers)) {
          foreach ($viewAllUsers as $users) {
        ?>
            <p class="user__list--text"><span class="user__mark">#</span><?= htmlspecialchars($users['usr_id']) . " " . htmlspecialchars($users['usr_name']) . " " . htmlspecialchars($users['usr_mail']) ?></p>
          <?php
          }
        } else {
          ?>
          <p class="user__list--text"><?= DataText::EMPTY_USER ?></p>
        <?php
        }
        ?>
      </div>
    </div>
    <div class="administration__sub--container">
      <h3 class="administration__sub--title">Shield Blacklist</h3>
      <ul class="infos__banned">
        <li class="infos__banned--detail">Banned Identifiant</li>
        <li class="infos__banned--detail">Banned Ip adresse</li>
        <li class="infos__banned--detail">Banned Date</li>
        <li class="infos__banned--detail">Banned Time</li>
      </ul>
      <ul class="blacklist__container">
        <?php
        if (is_array($viewBlacklist) && !empty($viewBlacklist)) {
          foreach ($viewBlacklist as $bl_view) {
        ?>
            <li class="user__banned">
              <span class="user__banned--el"><?= $bl_view['banned_ip_id'] ?></span>
              <span class="user__banned--el"><?= htmlspecialchars($bl_view['banned_adresse']) ?></span>
              <span class="user__banned--el"><?= $bl_view['banned_time'] ?></span>
              <span class="unban__btn"><a href="index.php?page=<?=Encryptor::encrypt('administration')?>&unban_ip=<?= $bl_view['banned_ip_id'] ?>">UNBAN</a></span>
            </li>
          <?php
          }
        } else {
          ?>
          <p class="user__banne--text"><?= DataText::BANNED_USER ?></p>
        <?php
        }
        ?>
      </ul>
    </div>
  </div>
  <div class="chart__container">
    <div class="chart__visitor--container">
      <div class="infos__visitor--container">
        <h3 class="visitor__title">All visitor on the shield</h3>
        <form method="post">
          <input type="submit" name="clean" value="Clean-visit" class="clear__btn">
        </form>
      </div>
      <ul class="infos__visitor">
        <li class="infos__visitor--detail">Identifiant</li>
        <li class="infos__visitor--detail">Ip adresse</li>
        <li class="infos__visitor--detail">Date</li>
        <li class="infos__visitor--detail">Time</li>
      </ul>
      <ul class="chart__ip--container">
        <?php
        if (isset($all_visits)) {
          foreach ($all_visits as $visitor) {
        ?>
            <li class="visitor__el"><span class="visitor__sub--el"><?= $visitor['id_visit'] ?></span><span class="visitor__sub--el"><?= $visitor['adress_visit'] ?></span><span class="visitor__sub--el"><?= $visitor['date_visit'] ?></span><span class="ban__btn"><a href="index.php?page=administration&ban_ip=<?= $visitor['adress_visit'] ?>">BAN-IP</a></span></li>
        <?php
          }
        }
        ?>
      </ul>
    </div>
    <div class="chart__sub--container">
      <canvas id="myChart" data-visites='<?= json_encode(array_values($monthlyCounts)); ?>'></canvas>
    </div>
  </div>
</section>