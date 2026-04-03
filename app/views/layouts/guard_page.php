<video autoplay loop muted playsinline class="shield__vid">
    <source src="<?= DataLink::BG_VID ?>" type="video/mp4">
</video>
<section class="shield__container">
  <div class="shield__hero--wrapper">
    <div class="hero__img--container">
      <img src="<?= DataLink::GUARDPAGE_GIFA ?>" alt="imgA" class="shield__effect--A">
      <img src="<?= DataLink::GUARDPAGE_GIFB ?>" alt="imgB" class="shield__effect--B">
      <img src="<?= DataLink::GUARDPAGE_GIFC ?>" alt="imgC" class="shield__effect--C">
    </div>
    <div class="shield__hero--content">
      <div class="hero__sub--content">
        <small class="shield__hero--sectorInfo"><?= DataText::GUARDPAGE_INFO_SECTOR ?></small>
        <h2 class="shield__hero--slogan"><?= DataText::GUARDPAGE_SLOGAN ?><span class="shield__hero--signature"><small><?= DataText::SIGNATURE ?></small></span></h2>
      </div>
      <fieldset class="shield__form">
        <?php
        if (isset($error_key_msg)) {
        ?>
          <legend><?= htmlspecialchars(strip_tags($error_key_msg)) ?></legend>
        <?php
        } else {
        ?>
          <legend><?= DataText::GUARDPAGE_INFO ?></legend>
        <?php
        }
        ?>
        <form method="post">
          <input type="text" name="alpha_key" required>
          <input type="submit" name="try_access" value="<?= DataText::GUARDBTN_ENTER ?>">
        </form>
      </fieldset>
    </div>
  </div>
</section>