<?php
    include_once __DIR__ . "/src/helpers.php";
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
    <?php include_once __DIR__ . '/components/authHead.php'?>
    <body>
        <form class="card" action="src/actions/login.php" method="post">
            <h2>Вход</h2>

            <?php if (hasMessageError('error')): ?>
                <div class="notice error"><?php echo getMessage('error')?></div>
            <?php endif; ?>

            <label for="email">
                Email
                <input
                    type="text"
                    id="email"
                    name="email"
                    <?php echo isAriaInvalidByName('email') ?>
                >
                <?php if (hasError('email')): ?>
                    <small> <?php echo getErrorText('email')?> </small>
                <?php endif; ?>
            </label>

            <label for="password">
                Пароль
                <input
                    type="password"
                    id="password"
                    name="password"
                    <?php echo isAriaInvalidByName('password') ?>
                >
                <?php if (hasError('password')): ?>
                    <small> <?php echo getErrorText('password')?> </small>
                <?php endif; ?>
            </label>

            <button
                type="submit"
                id="submit"
            >Продолжить</button>
        </form>

        <p>У меня еще нет <a href="/register.php">аккаунта</a></p>
    </body>
</html>