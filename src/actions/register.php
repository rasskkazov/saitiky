<?php
    include_once __DIR__ . '/../helpers.php';
    checkGuest();

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $passwordConfirmation = $_POST['password_confirmation'] ?? null;
    $avatar = $_FILES['avatar'] ?? null;

    $_SESSION['validation'] = [];
    $avatarPath = '';

    if (empty($name)) setValidationError('name', 'Поле пустое');
    if (empty($email)) setValidationError('email', 'Поле пустое');
    if (empty($password)) setValidationError('password', 'Поле пустое');
    if ($password !== $passwordConfirmation) setValidationError('password_confirmation', 'Пароли не совпадают');

    if (!empty($avatar)) {
        $types = ['image/png', 'image/jpeg'];

        if (!in_array($_FILES['avatar']['type'], $types)){
            setValidationError('avatar', 'Используйте jpg или png');
        } elseif ($_FILES['avatar']['size'] > 1000000) {
            setValidationError('avatar', 'Используйте объем меньше 1 МБ');
        }
    }

    if (!empty($_SESSION['validation'])) redirect('/register.php');

    if (!empty($avatar)) {
        $avatarPath = uploadFile($avatar, 'avatar');
    }

    $pdo = getPdo();

    $query = "INSERT INTO users (name, email, avatar, password) VALUES (:name, :email, :avatar, :password)";
    $params = [
        'name' => $name,
        'email' => $email,
        'avatar' => $avatarPath,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];
    $stmnt = $pdo->prepare($query);
    try {
        $stmnt->execute($params);
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    redirect('/');














