<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            <a href="<?= app()->route->getUrl('/signup') ?>" class="header__link">Регистрация</a>
        <?php
        else:
            ?>
            <a href="<?= app()->route->getUrl('/logout') ?>" class="header__link">Выход (<?= app()->auth::user()->name ?>)</a>
        <?php
        endif;
        ?>
    </nav>
</header>
<main class="main">
    <?= $content ?? '' ?>
</main>
</body>
<style>
    .page {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        color: #333333;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .header {
        background-color: #ffffff;
        border-bottom: 3px solid #d32f2f;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .header__nav {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header__link {
        text-decoration: none;
        color: #333333;
        font-weight: 600;
        font-size: 16px;
        padding: 8px 12px;
        border-radius: 4px;
        transition: color 0.2s, background-color 0.2s;
        text-transform: uppercase;
    }

    .header__link:hover {
        color: #d32f2f;
        background-color: #ffebeb;
    }

    .header__link:first-child {
        font-size: 18px;
        border-left: 4px solid #d32f2f;
        padding-left: 15px;
    }

    .main {
        flex: 1;
        max-width: 800px;
        width: 100%;
        margin: 40px auto;
        padding: 40px;
        background-color: #ffffff;
        border: 1px solid #cccccc;
        box-shadow: 8px 8px 0px #cccccc;
        border-radius: 2px;
    }
</style>
</html>
