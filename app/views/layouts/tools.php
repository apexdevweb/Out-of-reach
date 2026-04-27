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
          <h4 class="tools__title">Berserker</h4>
        </hgroup>
        <ul class="tools__icone--container">
          <li class="tools__icone--el"><?= DataText::TYPE_OF_TOOL_A ?></li>
          <li class="tools__icone--el"><?= DataText::TYPE_OF_TOOL_B ?></li>
          <li class="tools__icone--el"><?= DataText::TYPE_OF_TOOL_C ?></li>
          <li class="tools__icone--el"><img src="<?= DataLink::MAJORIS_PICT ?>" alt="MajorisLogo" class="threat__majoris--tools"></li>
        </ul>
      </header>
      <figure class="tools__img--container">
        <picture class="tools__img--wrapper">
          <source media="(min-width: 300px)" srcset="<?= DataLink::BERSERKER_PICT ?>" type="image/webp">
          <img src="<?= DataLink::BERSERKER_PICT ?>" class="tools__img--el" alt="berserkerImg">
        </picture>
        <div class="manufacturing__container--tools">
          <h6 class="tools__making--title"><?= DataText::TOOLS_MAKING_TITLE ?></h6>
          <div class="manufacturing__sub--container">
            <img src="<?= DataLink::RUST_PICT ?>" class="tools__making--language" alt="rustPict">
            <img src="<?= DataLink::PYTHON_PICT ?>" class="tools__making--language" alt="PYPict">
            <img src="<?= DataLink::JAVASCRIPT_PICT ?>" class="tools__making--language" alt="jsPict">
          </div>
          <hr class="tools__separate">
          <div class="tools__foot">
            <a href="<?= Encryptor::encrypt(DataLink::BERSERKER_DOWNLOAD) ?>" download="berserker.zip" class="tools__link"><?= DataText::DOWNLOAD_INFO_TXT ?></a>
          </div>
        </div>
      </figure>
    </article>
    <article class="tools__el">
      <header class="tools__el--header">
        <hgroup class="tools__el--title-ctnr">
          <h4 class="tools__title">Influencer's Nightmares</h4>
        </hgroup>
        <ul class="tools__icone--container">
          <li class="tools__icone--el"><?= DataText::TYPE_OF_TOOL_J ?></li>
          <li class="tools__icone--el"><?= DataText::TYPE_OF_TOOL_F ?></li>
          <li class="tools__icone--el"><?= DataText::TYPE_OF_TOOL_I ?></li>
          <li class="tools__icone--el"><img src="<?= DataLink::TERMINUS_PICT ?>" alt="TerminusLogo" class="threat__terminus--tools"></li>
        </ul>
      </header>
      <figure class="tools__img--container">
        <picture class="tools__img--wrapper">
          <source media="(min-width: 300px)" srcset="<?= DataLink::IFN_PICT ?>" type="image/webp">
          <img src="<?= DataLink::BERSERKER_PICT ?>" class="tools__img--el" alt="berserkerImg">
        </picture>
        <div class="manufacturing__container--tools">
          <h6 class="tools__making--title"><?= DataText::TOOLS_MAKING_TITLE ?></h6>
          <div class="manufacturing__sub--container">
            <img src="<?= DataLink::RUST_PICT ?>" class="tools__making--language" alt="rustPict">
            <img src="<?= DataLink::JAVASCRIPT_PICT ?>" class="tools__making--language" alt="jsPict">
          </div>
          <hr class="tools__separate">
          <div class="tools__foot">
            <a href="<?= Encryptor::encrypt(DataLink::BERSERKER_DOWNLOAD) ?>" download="berserker.zip" class="tools__link"><?= DataText::DOWNLOAD_INFO_TXT ?></a>
          </div>
        </div>
      </figure>
    </article>
  </div>
</section>