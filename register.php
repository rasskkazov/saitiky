<!DOCTYPE html>

<html lang="ru" data-theme="light">
    <?php include_once __DIR__ . '/components/head.php'?>

    <body>
        <form class="card" method="post" enctype="multipart/form-data">
            <h2>Регистрация</h2>

            <label for="name">
                Имя
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Иванов Иван"
                >
            </label>

            <label for="email">
                E-mail
                <input
                    type="text"
                    id="email"
                    name="email"
                    placeholder="ivan@areaweb.su"
                >
            </label>

            <label for="avatar">Изображение профиля
                <input
                    type="file"
                    id="avatar"
                    name="avatar"
                >
            </label>

            <div class="grid">
                <label for="password">
                    Пароль
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="******"
                    >
                </label>

                <label for="password_confirmation">
                    Подтверждение
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="******"
                    >
                </label>
            </div>

            <fieldset>
                <label for="terms">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                    >
                    Я принимаю все условия пользования
                </label>
            </fieldset>

            <button
                type="submit"
                id="submit"
                disabled
            >Продолжить</button>
        </form>

        <p>У меня уже есть <a href="/">аккаунт</a></p>
    </body>
</html>