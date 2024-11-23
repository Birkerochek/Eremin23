<?php
$db = new mysqli('151.248.115.10', 'root','Kwuy1mSu4Y','is64_solovyov') or die('error');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    
    $result = $db->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo 'Добро пожаловать ' . $user['username'];
            
            session_start();
            $_SESSION['user_id'] = $user['id'];
        } else {
            echo 'Неверный пароль';
        }
    } else {
        echo 'Пользователь не найден';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<header>
        <button onclick="document.location.href = '/index.php'" class="headerLink">Регистрация</button>
        <button onclick="document.location.href = '/login.php'" class="headerLink">Авторизация</button>
        <button onclick="document.location.href = '/edit.php'" class="headerLink">Редактирование</button>
        <button onclick="document.location.href = '/admin.php'" class="headerLink">Админка</button>
    </header>
    <h2>Авторизация</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit" name="login">Войти</button>
</form>
</body>
</html>