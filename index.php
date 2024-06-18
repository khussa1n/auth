<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="main-container flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md max-w-md w-full">
        <h2 class="text-3xl font-bold mb-4 text-center">Добро пожаловать, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>!</h2>
        <form action="index.php" method="POST" class="text-center">
            <button type="submit" name="logout" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded">
                Выйти
            </button>
        </form>
    </div>
</div>
</body>
</html>
