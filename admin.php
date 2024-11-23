<?php
$db = new mysqli('151.248.115.10', 'root','Kwuy1mSu4Y','is64_solovyov') or die('error');

session_start();
if (!isset($_SESSION['user_id'])) {
    die('Вы не авторизованы!');
}

$user_id = $_SESSION['user_id'];
$query = "SELECT role FROM users WHERE id = $user_id";
$result = $db->query($query);
$user = $result->fetch_assoc();

if ($user['role'] !== 'admin') {
    die('У вас нет прав для просмотра списка пользователей!');
}



$result = $db->query("SELECT username, email FROM users");

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr><th>Имя</th><th>Email</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr><td>' . htmlspecialchars($row['username']) . '</td><td>' . htmlspecialchars($row['email']) . '</td></tr>';
    }
    echo '</table>';
} else {
    echo 'Пользователи отсутствуют.';
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
    <h2>Админка</h2>
    
</body>
</html>