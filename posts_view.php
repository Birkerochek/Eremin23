<?php
$db = new mysqli(hostname: '151.248.115.10', username: 'root', password: 'Kwuy1mSu4Y', database: 'is64_solovyov') or die('error');
session_start();

$query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.username, posts.user_id 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC";

$result = $db->query($query);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $post_id = (int)$_POST['post_id'];

    
    $query = "SELECT user_id FROM posts WHERE id = $post_id";
    $post_result = $db->query($query);
    $post = $post_result->fetch_assoc();

    if ($post['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin') {
        $delete_query = "DELETE FROM posts WHERE id = $post_id";
        if ($db->query($delete_query)) {
            echo "<script>alert('Пост успешно удален!');</script>";
            header("Refresh:0"); 
        } else {
            echo "<script>alert('Ошибка удаления поста: " . $db->error . "');</script>";
        }
    } else {
        echo "<script>alert('У вас нет прав для удаления этого поста.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все посты</title>

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

    
        <h1>Список постов</h1>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <h2><?= $row['title']; ?></h2>
                    <p><?= $row['content']; ?></p>
                    <p>Автор: <?= $row['username']; ?></p>
                    <p>Дата создания: <?= $row['created_at']; ?></p>
                    
                        <?php if ($row['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin'): ?>
                            <a href="edit_post.php?post_id=<?= $row['id']; ?>">Редактировать</a>
                        <?php endif; ?>
                        <?php if ($row['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin'): ?>
                            <form method="POST">
                                <input type="hidden" name="post_id" value="<?= $row['id']; ?>">
                                <button type="submit" name="delete_post">Удалить</button>
                            </form>
                        <?php endif; ?>
                    
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Посты отсутствуют.</p>
        <?php endif; ?>
    
</body>
</html>
