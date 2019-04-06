<?php
require('dbconnect.php');
session_start();

if (isset($_SESSION['id'])){
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch(PDO::FETCH_ASSOC);
} else{
    header('Location: loginform.php');
    exit();
}

if (!empty($_SESSION['post'])){
    $comment = $db->prepare('INSERT INTO posts SET comment=?, image=?, member_id=?,
    created=NOW()');
    $comment->execute(array(
        $_SESSION['post']['comment'],
        $_SESSION['post']['image'],
        $member['id']
    ));
    unset($_SESSION['post']);
}

$posts = $db->query('SELECT m.name, p.* FROM members m, posts p WHERE
m.id=p.member_id ORDER BY p.created DESC');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>index</title>
    <link rel="" href="">
</head>
<body>
    <h1>MOTOR SPORT IMAGE BBS</h1>
    <button type="button" name="submit" onclick="location.href='post.php'">
        SUBMIT
    </button>
    <button type="button" name="logout" onclick="location.href='logout.php'">
        LOGOUT
    </button>
<?php foreach ($posts as $post): ?>
    <p><img src="member_image/<?php print(htmlspecialchars($post['image'], ENT_QUOTES));
    ?>" width="500" height="400" alt="<?php print(htmlspecialchars($post['name'], 
    ENT_QUOTES)); ?>" />
    <p><?php print(htmlspecialchars($post['comment'], ENT_QUOTES)); ?>
       (<?php print(htmlspecialchars($post['name'], ENT_QUOTES)); ?>)
       <?php print(htmlspecialchars($post['created'], ENT_QUOTES)); ?>
    </p>
<?php endforeach; ?>
</body>
</html>