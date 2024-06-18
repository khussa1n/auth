<?php

session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/database.php';
    require_once 'app/User.php';

    $database = new Database();
    $db = $database->connect();
    $user = new User($db);

    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    $user->email = $email;
    $user->password = $password;

    if ($user->authenticate()) {
        $_SESSION['username'] = $user->username;
        echo json_encode(['success' => true, 'redirect' => 'index.php']);
        exit;
    } else {
        $login_error = 'Неправильный email или пароль. Пожалуйста, попробуйте еще раз.';
        echo json_encode(['success' => false, 'message' => $login_error]);
        exit;
    }
}
