<div class="content-left">
    <h1>Мои статьи:</h1>
    <hr>
    <?php foreach ($articles as $article): ?>
        <div class="article">
            <h3><?= $article['title'] ?></h3>
            <p>
            <h5>Автор: <?= $article['author'] ?></h5>
            <h5>Просмотров: <?= $article['views'] ?></h5>
            <h5>Дата публикации: <?= $article['date_publication'] ?></h5>
            </p>
            <p><?= $article['text'] ?></p>
        </div>

        <form method="post">
            <button type="submit" name="articleId" value=<?= $article['id'] ?>>Перейти к статье</button>
        </form>
    <?php endforeach; ?>
    <?php if ($countPages > 1) { ?>
        <?php for( $i = 1; $i <= $countPages; $i++) { ?>
            <form method="post">
                <button type="submit" class="countPages" name="page" value=<?= $i ?>><?= $i ?></button>
            </form>
        <?php } ?>
    <?php } ?>
</div>