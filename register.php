<?php

session_start();
header('Content-Type: application/json');

if (isset($_SESSION['username'])) {
    echo json_encode(['success' => true, 'redirect' => 'index.php']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/database.php';
    require_once 'app/User.php';

    $database = new Database();
    $db = $database->connect();
    $user = new User($db);

    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $telephone = htmlspecialchars(strip_tags($_POST['telephone']));

    $user->username = $username;
    $user->password = $password;
    $user->email = $email;
    $user->telephone = $telephone;

    if ($user->userExists($email)) {
        $register_error = 'Пользователь с таким email уже зарегистрирован.';
        echo json_encode(['success' => false, 'message' => $register_error]);
        exit;
    }

    if ($user->register()) {
        $_SESSION['username'] = $username;
        echo json_encode(['success' => true, 'redirect' => 'index.php']);
        exit;
    } else {
        $register_error = 'Ошибка регистрации. Пожалуйста, попробуйте еще раз.';
        echo json_encode(['success' => false, 'message' => $register_error]);
        exit;
    }
}
