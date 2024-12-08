<?php
    include_once __DIR__."/src/helpers.php";

    checkAuth();
    $user = currentUser();
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
    <?php include_once __DIR__ . '/components/head.php'?>
    <body>
        <div class="card home">
            <img
                class="avatar"
                src = "<?php echo $user['avatar'] ?>"
                alt="<?php echo $user['name'] ?>"
            >
            <h1>Привет, <?php echo $user['name'] ?>!</h1>
            <form  method="post" action="/src/actions/logout.php">
                <button role="button">Выйти из аккаунта</button>
            </form>
        </div>
    </body>
</html>