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

        <article class="users">
            <table class="users__table">
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td> <a href="<?php echo "/user.php?id={$user['id']}" ?>">
                            <?php echo $user['id']; ?>
                        </a> </td>
                        <td> <a href="<?php echo "/user.php?id={$user['id']}" ?>">
                            <img class="avatar" src="<?php echo $user['avatar']; ?>" alt="ava">
                        </td>
                        <td> <a href="<?php echo "/user.php?id={$user['id']}" ?>">
                            <?php echo $user['name']; ?>
                        </a> </td>
                        <td> <a href="<?php echo "/user.php?id={$user['id']}" ?>">
                            <?php echo $user['email']; ?>
                        </a> </td>
                    </tr>

                <?php endforeach; ?>
            </table>
        </article>
    </body>
</html>