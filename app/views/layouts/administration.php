<section class="administration__container">
  <div class="administration__wrapper">
    <div class="administration__sub--container">
      <h3 class="administration__sub--title">Uniq loging key for users</h3>
      <?php
      if (isset($_SESSION['user_access_key'])) {
      ?>
        <p class="user__key__el"><?= $_SESSION['user_access_key'] ?></p>
      <?php
      } else {
      ?>
        <p class="user__key__el">...</p>
      <?php
      }
      ?>
      <form method="post">
        <input type="submit" value="Generate-new-key" name="generate" class="generate__btn">
      </form>
    </div>
    <div class="administration__sub--container">
      <form method="post">
        <input type="search" placeholder="seacrh user" name="users_search" required class="search__space">
        <input type="submit" value="Search" name="search_action" class="search__btn">
      </form>
      <div class="search__result--container">
        <?php
        if (!empty($get_all_users)) {
          foreach ($get_all_users as $users) {
        ?>
            <p class="user__list--text"><?= htmlspecialchars($users['user_name']) ?></p>
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
            <li class="visitor__el"><span class="visitor__sub--el"><?= $visitor['id_visit'] ?></span><span class="visitor__sub--el"><?= $visitor['adress_visit'] ?></span><span class="visitor__sub--el"><?= $visitor['date_visit'] ?></span> <span class="ban__btn"><a href="">BAN-IP</a></span></li>
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