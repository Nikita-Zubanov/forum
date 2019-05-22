<form method="post">
    <p>Название:</p>
    <p><input type="text" name="title"></p>
    <p>Категория:</p>
    <select name="category">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <p>Содержимое:</p>
    <p><textarea type="text" name="text" rows="30"></textarea></p>
    <b><button type="submit" name="addArticle" value="addArticle">Добавить</button></b>
</form>