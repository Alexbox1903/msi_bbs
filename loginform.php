<?php
require('dbconnect.php');
session_start();

if (!empty($_POST)){
    if ($_POST['email'] === ''){
        $error['email'] = 'blank';
    }
    if ($_POST['password'] === ''){
        $error['password'] = 'blank';
    }
    if ($_POST['email'] !== '' && $_POST['password'] !== ''){
        $stmt = $db->prepare('SELECT * FROM members WHERE email=?');
        $stmt->execute(array($_POST['email']));
        $member = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($_POST['password'], $member['password'])){
            if ($member){
            $_SESSION['id'] = $member['id'];
            }
        header('Location: index.php');
        exit();
        } else {
            $error['login'] = 'failed';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>loginform</title>
    <link rel="stylesheet" href="loginform.css">
</head>
<body>
    <div class="loginform">
    <h1>LOGIN FORM</h1>
    <form action="" method="post">
        <div class="box">
        <p>
            <input type="email" name="email" id="email" placeholder="EMAIL ADDLESS"
            value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
        </p>
        <?php if ($error['email'] === 'blank'): ?>
        <p>メールアドレスが未入力です</p>
        <?php endif; ?>
        </div>
        <div class="box">
        <p>
            <input type="password" name="password" id="password" placeholder="PASSWORD">
        </p>
        <?php if ($error['password'] === 'blank'): ?>
        <p>パスワードが未入力です</p>
        <?php endif; ?>
        <?php if ($error['login'] === 'failed'): ?>
        <p>ログインに失敗しました</p>
        <?php endif; ?>
        </div>
        <div class="box">
        <p>
            <input type="submit" value="LOGIN">
        </p>
        </div>
        Create an account <a href="registerform.php"><span>click here</span></a>
    </form>
    </div>
</body>
</html>