<section class="administration__container">
  <div class="administration__wrapper">
    <div class="administration__sub--container">
      <h3 class="administration__sub--title">Loging uniq key for users</h3>
      <p class="user__key__el"><?= $_SESSION['user_access_key'] ?></p>
      <div class="chart__container">
        <canvas id="myChart"></canvas>
      </div>
    </div>
    <div class="administration__sub--container">
      <form method="post">
        <input type="search" placeholder="seacrh user" name="users_search" required>
        <input type="submit" value="Search" name="search_action">
      </form>
      <div class="search__result--container">
        <?php
        if (!empty($getAllUsersForAdmin)) {
          foreach ($getAllUsersForAdmin as $users) {
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
    <div class="administration__sub--container"></div>
  </div>
</section>