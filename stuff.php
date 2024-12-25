<?php
    include_once __DIR__."/src/helpers.php";

    checkAuth();
    $user = currentUser();

    $users = getUsers();
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
    <?php include_once __DIR__ . '/components/head.php'?>

    <body>
        <?php include_once __DIR__ . '/components/header.php'?>
        <div class="game__container">
            <canvas id="gameCanvas" width="600" height="600"></canvas>
        </div>

        <script src="game.js"></script>
    </body>
</html>