<?php use_helper('Date') ?>
<?php use_helper('Thumb') ?>
<h1>
  Prochains événements
  <?php if($sf_user->isAuthenticated() && $sf_user->getGuardUser()->hasAccess($asso->getLogin(), 0x08)): ?>
    <span class="titleaction"><i class="icon-plus icon-white"></i> <a href="<?php echo url_for('event_new', $asso) ?>">Ajouter un événement</a></span>
  <?php endif ?>
</h1>
<?php include_partial('event/eventbox', array('events' => $events)) ?>
