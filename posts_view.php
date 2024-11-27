<?php

$db = new mysqli(hostname: '151.248.115.10', username: 'root', password: 'Kwuy1mSu4Y', database: 'is64_solovyov') or die('error');
session_start();

$query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC";

$result = $db->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['content']) . "</p>";
        echo "<p>Автор: " . htmlspecialchars($row['username']) . "</p>";
        echo "<p>Дата создания: " . $row['created_at'] . "</p>";

        

      
        
        echo "<form method='POST'>
                <input type='hidden' name='post_id' value='" . $row['id'] . "'>
                <button type='submit' name='delete_post'>Удалить</button>
              </form>";
    }
} else {
    echo "Посты отсутствуют.";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = (int)$_POST['post_id'];

    
    $query = "SELECT user_id FROM posts WHERE id = $post_id";
    $result = $db->query($query);
    $post = $result->fetch_assoc();

    if ($post['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin') {
        $query = "DELETE FROM posts WHERE id = $post_id";
        if ($db->query($query)) {
            echo "Пост успешно удален!";
        } else {
            echo "Ошибка удаления поста: " . $db->error;
        }
    } else {
        echo "У вас нет прав для удаления этого поста.";
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
        <button onclick="document.location.href = '/create_post.php'" class="headerLink">Создать пост</button>
        <button onclick="document.location.href = '/posts_view.php'" class="headerLink">Все посты</button>
    </header>

    
</body>
</html>