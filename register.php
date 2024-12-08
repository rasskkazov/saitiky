<?php
    include_once __DIR__ . "/src/helpers.php";
?>

<!DOCTYPE html>

<html lang="ru" data-theme="light">
    <?php include_once __DIR__ . '/components/head.php'?>

    <body>
        <form class="card" action="src/actions/register.php" method="post" enctype="multipart/form-data">
            <h2>Регистрация</h2>

            <label for="name">
                Имя
                <input
                    type="text"
                    id="name"
                    name="name"
                    <?php echo isAriaInvalidByName('name') ?>
                >
                <?php if (hasError('name')): ?>
                    <small> <?php echo getErrorText('name')?> </small>
                <?php endif; ?>
            </label>

            <label for="email">
                E-mail
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

            <label for="avatar">Изображение профиля
                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                    <?php echo isAriaInvalidByName('avatar') ?>
                >
                <?php if (hasError('avatar')): ?>
                    <small> <?php echo getErrorText('avatar')?> </small>
                <?php endif; ?>
            </label>

            <div class="grid">
                <label for="password">
                    Пароль
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="******"
                        <?php echo isAriaInvalidByName('password') ?>
                    >
                    <?php if (hasError('password')): ?>
                        <small> <?php echo getErrorText('password')?> </small>
                    <?php endif; ?>
                </label>

                <label for="password_confirmation">
                    Подтверждение
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="******"
                        <?php echo isAriaInvalidByName('password_confirmation') ?>
                    >
                    <?php if (hasError('password_confirmation')): ?>
                        <small> <?php echo getErrorText('password_confirmation')?> </small>
                    <?php endif; ?>
                </label>
            </div>

            <button
                type="submit"
                id="submit"
            >Продолжить</button>
        </form>

        <p>У меня уже есть <a href="/">аккаунт</a></p>
    </body>
</html>

