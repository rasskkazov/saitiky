<?php
include_once __DIR__ . "/src/helpers.php";

$profileId = $_GET['id'] ?? null;
if (!$profileId) redirect("/");

checkAuth();
$user = currentUser();

$profile = getUserById($profileId);
if (!$profile) echo "Пользователь не найден";
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
<?php include_once __DIR__ . '/components/head.php' ?>

<body class="home">
<?php include_once __DIR__ . '/components/header.php' ?>

<article>
    <div class="user">
        <div class="user__avatar">
            <img class="avatar" src="<?php echo $profile['avatar']; ?>" alt="avatar">
        </div>
        <div class="user__info">
            <p><strong><?php echo $profile['name']; ?></strong></p>
            <p><strong><?php echo $profile['email']; ?></strong></p>
        </div>
    </div>

    <?php if ($profileId !== $user['id']) : ?>
        <div class="chat">

        </div>
    <?php endif; ?>
</article>
</body>
</html>
