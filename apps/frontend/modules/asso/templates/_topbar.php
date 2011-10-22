<div id="topbar">
  <h3><a href="<?php echo url_for('asso/show?login='.$asso->getLogin()) ?>"><?php echo $asso->getName() ?></a></h3>
  <div class="logo_asso"><img src="<?php echo $asso->getLogo() ?>"></div>

  <div class="desc">
    <?php echo html_entity_decode($asso->getDescription()) ?>
  </div>
  <a class="website" href="<?php echo $asso->getUrlSite() ?>"><?php echo $asso->getUrlSite() ?></a><br />
  <a class="email "href="mailto:<?php echo $asso->getLogin() ?>@assos.utc.fr"><?php echo $asso->getLogin() ?>@assos.utc.fr</a><br />
  <br />
  <a href="#">Je souhaite rejoindre cette association</a>
</div>