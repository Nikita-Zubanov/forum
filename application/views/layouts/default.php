<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link type = "text/css" rel="stylesheet" href="/web/css/style.css">
    <title><?= $title ?></title>
</head>
<body>
    <header>
        <div class="header-left">
            <a href="/"><img src="/web/images/menu.png" title="Меню"></a>
        </div>
        <div class="header-right">
            <a href="/account/profile"><img src="/web/images/login.png" title="Авторизация"></a>
        </div>
        <div class="header-center">
        </div>
    </header>
    <div class="content">
        <?= $content ?>
    </div>
</body>
</html>