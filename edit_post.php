<?php
session_start();
$db = new mysqli('151.248.115.10', 'root','Kwuy1mSu4Y','is64_solovyov') or die('error');


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['post_id'])) {
    $post_id = (int)$_GET['post_id'];

    $query = "SELECT * FROM posts WHERE id = $post_id";
    $result = $db->query($query);

    if ($result->num_rows === 0) {
        die("Пост не найден.");
    }

    $post = $result->fetch_assoc();

  
    if ($post['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin') {
        die("У вас нет прав для редактирования этого поста.");
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_post'])) {
    $post_id = (int)$_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    if (empty($title) || empty($content)) {
        die("Заголовок и содержание не могут быть пустыми.");
    }
   
    $query = "UPDATE posts SET title = '$title', content = '$content', updated_at = NOW() WHERE id = $post_id";
    if ($db->query($query)) {
        echo "<script>alert('Пост успешно обновлен!');</script>";
        header("Location: posts_view.php"); 
        exit;
    } else {
        echo "Ошибка обновления поста: " . $db->error;
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
<h2>Редактирование поста</h2>
<form method="POST" action="edit_post.php">
    <input type="hidden" name="post_id" value="<?= $post['id']; ?>">
    <input type="text" name="title" value="<?= $post['title']; ?>" required>
    <input name="content" value = "<?= $post['content']; ?>" required>
    <button type="submit" name="edit_post">Сохранить изменения</button>
</form>
</body>
</html>