<?php
$numberOfPin = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
if (isset($_POST['validate_pin']) && !empty($_POST['secure_pin'])) {
}
?>
<section class="pin__container">
  <form method="post">
    <input type="password" name="secure_pin" maxlength="8" placeholder="########" readonly required autofocus>
    <?php
    for ($i = 0; $i < sizeof($numberOfPin); $i++) {
    ?>
      <button type="button" value="<?= $i ?>" class="pin_key"><?= $i ?></button>
    <?php
    }
    ?>
    <input type="submit" name="validate_pin" value="Validate">
  </form>
</section>