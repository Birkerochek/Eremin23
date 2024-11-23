<?php
$db = new mysqli('151.248.115.10', 'root','Kwuy1mSu4Y','is64_solovyov') or die('error');

session_start();
if (!isset($_SESSION['user_id'])) {
    die('Вы не авторизованы!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    
    $query = "UPDATE users SET username = '$username', email = '$email'";
    if ($password) {
        $query .= ", password = '$password'";
    }
    $query .= " WHERE id = $user_id";

    if ($db->query($query)) {
        echo 'Данные успешно обновлены!';
    } else {
        echo 'Ошибка: ' . $db->error;
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
    <h2>Редактирование</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Новый пароль">
    <button type="submit" >Обновить</button>
</form>
<p>Вы сейчас под именем <?php echo $_SESSION['username'] ?></p>
</body>
</html>

