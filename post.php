<?php
require('dbconnect.php');
session_start();

if (!isset($_SESSION['id'])){
    header('Location: loginform.php');
}

if (!empty($_POST)){
    $filename = $_FILES['image']['name'];
    
    if ($_FILES['image']['size'] === 0){
        $error['image'] = 'blank';
    }
    
    if (!empty($filename)){
        $mime = mime_content_type($_FILES['image']['tmp_name']);
        if ($mime != 'image/jpg' && $mime != 'image/jpeg' && $mime != 'image/gif' 
        && $mime != 'image/png'){
            $error['image'] = 'type';
        }
    }

    if  (empty($error)){
        date_default_timezone_set('Asia/Tokyo');
        $image = date('YmdHis') . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], './member_image/' . $image);
    }

    if  (empty($error)){
        $_SESSION['post']['comment'] = $_POST['comment'];
        $_SESSION['post']['image'] = $image;
        
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>post</title>
    <iink rel="" href="">
</head>
<body>
    <h1>MOTOR SPORT IMAGE BBS</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <p>
            <textarea name="comment"></textarea>
        </p>
        <p>
            <input type="file" name="image">
        </p>
        <?php if ($error['image'] === 'type'): ?>
        <p>アップロードに失敗しました</p>
        <?php endif; ?>
        <?php if ($error['image'] === 'blank'): ?>
        <p>画像ファイルを選択してください</p>
        <?php endif; ?>
        <p>
            <input type="submit" value="SUBMIT">
        </p>
        <p>
            <button type="button" name="button" onclick="location.href='index.php'">
                BACK
            </button>
        </p>
    </form>
</body>
</html>