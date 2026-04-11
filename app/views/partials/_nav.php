<nav class="globale__nav--container">
  <ul class="nave__sub--container">
    <li class="nav__el"><a href="index.php?page=<?= Encryptor::encrypt('home') ?>"><?= DataText::NAV_HOME ?></a></li>
    <li class="nav__el"><a href="index.php?page=<?= Encryptor::encrypt('tools') ?>"><?= DataText::NAV_TOOL ?></a></li>
    <li class="nav__el"><a href="index.php?page=<?= Encryptor::encrypt('tips') ?>"><?= DataText::NAV_TIPS ?></a></li>
    <li class="nav__el"><a href="index.php?page=<?= Encryptor::encrypt('forum') ?>"><?= Datatext::NAV_FORUM ?></a></li>
  </ul>
</nav>