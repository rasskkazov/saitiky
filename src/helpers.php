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