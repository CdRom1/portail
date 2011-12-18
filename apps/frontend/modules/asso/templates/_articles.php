<div id="articles">
  <?php if ($articles->count() > 0): ?>
    <div id="article_list">
      <?php foreach ($articles as $article) : ?>
        <div class="article">
          <h3><?php echo $article->getName() ?></h3>
          Publié par <?php echo $article->getAsso()->getName() ?> le <?php echo $article->getCreatedAt() ?>
          <p>
            <?php echo $article->getText() ?>
          </p>
          <?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->hasAccess($article->getAsso()->getLogin(), 0x04)): ?>
            <div class="actions">
              <a href="<?php echo url_for('article/edit?id=' . $article->getId()) ?>">Editer</a>
            </div>
          <?php endif ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    Cette association n'a pas encore publié d'article.
  <?php endif ?>
</div>