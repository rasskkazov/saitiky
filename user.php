<?php
include_once __DIR__ . "/src/helpers.php";

$profileId = $_GET['id'] ?? null;
if (!$profileId) redirect("/");

checkAuth();
$user = currentUser();

$profile = getUserById($profileId);
if (!$profile) echo "Пользователь не найден";


$messages = getMessages($user['id'], $profile['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $image = $_FILES['image'] ?? null;
    $imagePath = null;

    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes)) {
            $imageName = uniqid() . '-' . basename($image['name']);
            $imagePath = $uploadDir . $imageName;

            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                echo "Ошибка при загрузке изображения";
                exit;
            }
        } else {
            echo "Неверный тип файла. Поддерживаются только изображения (JPEG, PNG, GIF)";
            exit;
        }
    }

    addMessage($user['id'], $profile['id'], $message, $imagePath);

    header("Location: /user.php?id={$profileId}");
    exit;
}

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
            <div class="chat__messages">
                <?php foreach ($messages as $msg): ?>
                    <div class="chat__message">
                        <strong><?php echo ($msg['sender_id'] === $user['id']) ? 'Вы' : $profile['name']; ?>:</strong>
                        <p><?php echo htmlspecialchars($msg['message']); ?></p>
                        <?php if ($msg['image']): ?>
                            <div class="chat__image">
                                <img src="<?php echo $msg['image']; ?>" alt="image" style="max-width: 300px; max-height: 200px;">
                            </div>
                        <?php endif; ?>
                        <small><?php echo $msg['created_at']; ?></small>
                    </div>
                <?php endforeach; ?>
            </div>

            <form method="POST" enctype="multipart/form-data" class="chat__form">
                <textarea name="message" placeholder="Введите сообщение..." required></textarea>
                <input type="file" name="image" accept="image/*">
                <button type="submit">Отправить</button>
            </form>
        </div>
    <?php endif; ?>
</article>
</body>
</html>
