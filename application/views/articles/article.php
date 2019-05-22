<div class="article">
    <p> <h3><?= $article['title'] ?></h3></p>
    <p><h5>Автор: <?= $article['author'] ?></h5></p>
    <p><?= $article['text'] ?></p>
    <?php if($article['author'] == $user) { ?>
        <form method="post">
            <p><button type="submit" class="edit" name="edit" value="edit">Редактировать</button></p>
        </form>
    <?php } ?>
</div>
<br>
<hr>
<h3>Комментарии:</h3>
<?php foreach ($comments as $comment): ?>
    <div class="comment">
        <p><?= $comment['author'] ?>:</p>
        <p><?= $comment['comment'] ?></p>
    </div>
    <br>
<?php endforeach; ?>
<hr>
<form method="post">
    <p><textarea name="commentText" value="commentText" rows="5" cols="100"></textarea></p>
    <p><button type="submit" name="comment" value="comment">Оставить комментарий</button></p>
</form>