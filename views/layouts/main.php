<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/style.css">
    <title>Pop it MVC</title>
</head>
<body class="page">
<header class="header">
    <nav class="header__nav">
        <a href="<?= app()->route->getUrl('/hello') ?>" class="header__link">Главная</a>
        <?php
        if (!app()->auth::check()):
            ?>
            <a href="<?= app()->route->getUrl('/login') ?>" class="header__link">Вход</a>

        <?php
        else:
            ?>
            <?php $user = app()->auth->user(); ?>
            <a href="<?= app()->route->getUrl('/buildings') ?>" class="header__link">Просмотр зданий</a>
            <?php if ($user->role && $user->role_id == 1): ?>
                <a href="<?= app()->route->getUrl('/signup') ?>" class="header__link">Создание пользователя</a>
            <?php endif; ?>
            <a href="<?= app()->route->getUrl('/logout') ?>" class="header__link">Выход (<?= app()->auth::user()->login ?>, <?= app()->auth::user()->role->name ?>)</a>
        <?php
        endif;
        ?>
    </nav>
</header>
<main class="main">
    <?= $content ?? '' ?>
</main>
</body>
</html>
