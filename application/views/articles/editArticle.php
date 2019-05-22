<form method="post">
    <p>Название:</p>
    <p><input type="text" name="title" value="<?= $article['title'] ?>"></p>
    <p>Категория:</p>
    <select name="category">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['name'] ?>"
                <?php if ($category['name'] ==  $article['category']) echo 'selected';?>
            ><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <p>Содержимое:</p>
    <p><textarea type="text" name="text" rows="30"><?= $article['text'] ?></textarea></p>
    <b><button type="submit" name="addArticle" value="addArticle">Изменить</button></b>
</form>