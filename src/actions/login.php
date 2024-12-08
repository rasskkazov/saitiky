<?php
    include_once __DIR__ . '/../helpers.php';

    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $user = findUser($email);

    if(!$user){
        setMessage('error', "Email не найден");
        redirect('/');
    }

    if (!password_verify($password, $user['password'])) {
        setMessage('error', "Неверный пароль");
        redirect('/');
    }

    $_SESSION['user']['id'] = $user['id'];
    redirect('/home.php');