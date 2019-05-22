<div class="content-left">
    <h1>Самые популярные статьи:</h1>
    <hr>
    <?php foreach ($mostPopularArticles as $article): ?>
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
</div>

<div class="content-right">
    <div class="article">
        <h4>Категории</h4>
        <?php foreach ($categories as $category): ?>
            <form method="post">
                <button type="submit" class="category"  name="categoryName" value=<?= $category['name'] ?>><?= $category['name'] ?></button>
            </form>
        <?php endforeach; ?>

        <form method="post">
            <button type="submit" class="allArticles"  name="allArticles" value="allArticles">Все статьи</button>
        </form>
    </div>

    <?php if (!empty($user)) { ?>
        <div class="article">
            <h4>Мои статьи:</h4>
            <?php if (!empty($myArticles)) { ?>
                <?php foreach ($myArticles as $myArticle): ?>
                    <form method="post">
                        <button type="submit" class="category"  name="articleId" value=<?= $myArticle['id'] ?>><?= $myArticle['title'] ?></button>
                    </form>
                <?php endforeach; ?>

                <form method="post">
                    <button type="submit" class="allArticles"  name="myArticles" value="myArticles">Посмотреть все</button>
                </form>
            <?php } ?>

            <form method="post">
                <p><button type="submit" class="allArticles" name="addArticle" value="addArticle">Добавить статью</button></p>
            </form>
        </div>
    <?php } ?>
</div>