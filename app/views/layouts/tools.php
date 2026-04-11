<section class="tools__container">
  <div class="threat__wrapper">
    <ul class="threat__container">
      <li class="threat__el">
        <h6 class="threat__info"><?= DataText::THREAT_TITLE ?></h6>
      </li>
      <li class="threat__el">
        <h6 class="threat__info"><?= DataText::THREAT_MINORIS_LVL ?></h6><img src="<?= DataLink::MINORIS_PICT ?>" alt="MinorisLogo" class="threat__logo">
      </li>
      <li class="threat__el">
        <h6 class="threat__info"><?= DataText::THREAT_MAJORIS_LVL ?></h6><img src="<?= DataLink::MAJORIS_PICT ?>" alt="MajorisLogo" class="threat__logo">
      </li>
      <li class="threat__el">
        <h6 class="threat__info"><?= DataText::THREAT_TERMINUS_LVL ?></h6><img src="<?= DataLink::TERMINUS_PICT ?>" alt="TerminusLogo" class="threat__logo">
      </li>
    </ul>
    <h5 class="tools__intro--txt"><?= DataText::TOOLS_INTRO ?></h5>
  </div>
  <div class="tools__wrapper">
    <article class="tools__el">
      <header class="tools__el--header">
        <hgroup class="tools__el--title-ctnr">
          <h4></h4>
          <h5></h5>
        </hgroup>
        <ul class="tools__icone--container">
          <li class="tools__icone--el"></li>
          <li class="tools__icone--el"></li>
          <li class="tools__icone--el"></li>
          <li class="tools__icone--el"></li>
          <li class="tools__icone--el"></li>
          <li class="tools__icone--el"></li>
        </ul>
      </header>
      <p class="tools__detail"></p>
      <figure class="tools__img--container">
        <picture class="tools__img--wrapper">
          <source media="(min-width: 600px)" srcset="" type="image/webp">
          <img src="" alt="berserkerImg">
        </picture>
        <figcaption class="tools__date--caption"></figcaption>
      </figure>
      <footer class="tools__foot"></footer>
    </article>
  </div>
</section>