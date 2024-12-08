<?php
    session_start();

    require_once __DIR__ . '/config.php';
    function redirect(string $path) {
        header('Location: ' . $path);
        die();
    }

    function isAriaInvalidByName(string $field) {
       return isset($_SESSION['validation'][$field]) ? 'aria-invalid="true"' : '';
    }

    function getErrorText(string $field) {
        $message = $_SESSION['validation'][$field] ?? '';
        unset($_SESSION['validation']);
        return $message;
    }

    function hasError(string $field) {
        return isset($_SESSION['validation'][$field]) ? true : false;
    }

    function addValidationErrorToSession(string $field, string $text) {
        $_SESSION['validation'][$field] = $text;
    }

    function uploadFile(array $file, string $prefix = '') {
        $uploadPath = __DIR__ . '../../uploads/avatars/';

        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $prefix . '_' . time() . ".$extension";

        if (!move_uploaded_file($file['tmp_name'], "$uploadPath/$filename")) {
            die('Error while uploading file');
        };

        return "uploads/$filename";
    }

    function getPdo() : PDO{
        try {
            return new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    function setMessage(string $key, string $message):void {
        $_SESSION['messages'][$key] = $message;
    }

    function getMessage(string $key):string {
        $message = $_SESSION['messages'][$key];
        unset($_SESSION['messages'][$key]);
        return $message;
    }

    function hasMessageError(string $key):bool {
        return isset($_SESSION['messages'][$key]);
    }

    function findUser(string $email) {
        $pdo = getPdo();

        $query = "SELECT * FROM users WHERE `email` = :email";

        $stmnt = $pdo->prepare($query);
        $stmnt->execute(['email' => $email]);

        return $stmnt->fetch(\PDO::FETCH_ASSOC);
    }