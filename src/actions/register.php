<?php
    include_once __DIR__ . '/../helpers.php';

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $passwordConfirmation = $_POST['password_confirmation'] ?? null;
    $avatar = $_FILES['avatar'] ?? null;

    $_SESSION['validation'] = [];
    $avatarPath = '';

    if (empty($name)) addValidationErrorToSession('name', 'Поле пустое');
    if (empty($email)) addValidationErrorToSession('email', 'Поле пустое');
    if (empty($password)) addValidationErrorToSession('password', 'Поле пустое');
    if ($password !== $passwordConfirmation) addValidationErrorToSession('password_confirmation', 'Пароли не совпадают');

    if (!empty($avatar)) {
        $types = ['image/png', 'image/jpeg'];

        if (!in_array($_FILES['avatar']['type'], $types)){
            addValidationErrorToSession('avatar', 'Используйте jpg или png');
        } elseif ($_FILES['avatar']['size'] > 1000000) {
            addValidationErrorToSession('avatar', 'Используйте объем меньше 1 МБ');
        }
    }

    if (!empty($_SESSION['validation'])) redirect('/register.php');

    if (!empty($avatar)) {
        $avatarPath = uploadFile($avatar, 'avatar');
    }

    $pdo = getPdo();