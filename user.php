<?php
include_once __DIR__ . "/src/helpers.php";

$profileId = $_GET['id'] ?? null;
if (!$profileId) redirect("/");

checkAuth();
$user = currentUser();

$profile = getUserById($profileId);
if (!$profile) echo "Пользователь не найден";

$messages = getMessages($user['id'], $profile['id']);
$cities = getCities();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['form_type'] ?? '';

    if ($formType === 'message') {
        $message = $_POST['message'] ?? '';
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
    } elseif ($formType === 'edit_profile') {
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        $middleName = $_POST['middle_name'] ?? '';
        $birthDate = $_POST['birth_date'] ?? '';
        $cityId = $_POST['city_id'] ?? null;

        if (empty($firstName) || empty($lastName) || empty($birthDate) || !$cityId) {
            echo "Все поля обязательны для заполнения.";
        } else {
            $pdo = getPdo();
            $query = "UPDATE users SET first_name = :first_name, last_name = :last_name, 
                      middle_name = :middle_name, birth_date = :birth_date, city_id = :city_id WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'middle_name' => $middleName,
                'birth_date' => $birthDate,
                'city_id' => $cityId,
                'id' => $profileId,
            ]);

            header("Location: /user.php?id={$profileId}");
            exit;
        }
    }
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
                <input type="hidden" name="form_type" value="message">
                <textarea name="message" placeholder="Введите сообщение..." required></textarea>
                <input type="file" name="image" accept="image/*">
                <button type="submit">Отправить</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($profileId === $user['id']) : ?>
        <div class="profile-edit">
            <h3>Редактировать профиль</h3>
            <form method="POST" class="profile-edit__form">
                <input type="hidden" name="form_type" value="edit_profile">
                <label>
                    Имя:
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>" required>
                </label>
                <label>
                    Фамилия:
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>" required>
                </label>
                <label>
                    Отчество:
                    <input type="text" name="middle_name" value="<?php echo htmlspecialchars($profile['middle_name'] ?? ''); ?>">
                </label>
                <label>
                    Дата рождения:
                    <input type="date" name="birth_date" value="<?php echo htmlspecialchars($profile['birth_date'] ?? ''); ?>" required>
                </label>
                <label>
                    Город:
                    <select name="city_id" required>
                        <option value="">Выберите город</option>
                        <?php foreach ($cities as $city): ?>
                            <option value="<?php echo $city['id']; ?>"
                                <?php echo ($profile['city_id'] ?? '') == $city['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($city['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button type="submit">Сохранить изменения</button>
            </form>
        </div>
    <?php endif; ?>
</article>
</body>
</html>
