<?php
session_start();
$db = new mysqli('151.248.115.10', 'root','Kwuy1mSu4Y','is64_solovyov') or die('error');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = "INSERT INTO posts (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    if($db ->query($query)){
        echo 'Пост создан';
    } else{
        echo 'Ошибка';
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
    <h2><?php echo $_SESSION['user_id'] ?></h2>
    <form action="" method="post">

        <input name="title" type="text" placeholder="Заголовок">
        <input name="content" type="text" placeholder="Содержание">
        <input type="submit" value="Создать">
    </form>
</body>
</html>