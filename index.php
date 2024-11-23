<?php
$db = new mysqli('151.248.115.10', 'root','Kwuy1mSu4Y','is64_solovyov') or die('error');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    
    $result = $db->query("SELECT COUNT(*) AS count FROM users WHERE email = '$email'");
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        die('Email уже используется!');

    }

    // Вставка нового пользователя
    
    if ($db->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')")) {
        echo 'Регистрация прошла успешно!';
    } else {
        echo 'Ошибка: ' . $db->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    <h2>Регистрация</h2>
    <form  method="post">
        <input name = "username" type="text" placeholder = "Имя">
        <input name = "email" type="email" placeholder = "Email">
        <input name = "password" type="password" placeholder = "Пароль">
        <input type="submit" value="Зарегистрироваться">
    </form>
</body>
</html>