<?php
require('dbconnect.php');
session_start();

if (!empty($_POST)){
if ($_POST['username'] === ''){
    $error['username'] = 'blank';
}
if ($_POST['email'] === ''){
    $error['email'] = 'blank';
}
if ($_POST['password_1'] === ''){
    $error['password_1'] = 'blank';
} else if (strlen($_POST['password_1']) < 4){
    $error['password_1'] = 'length';
}
if ($_POST['password_1'] != $_POST['password_2']){
    $error['password'] = 'nmatch';
}
if (empty($error)){
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0){
        $error['email'] = 'duplicate';
    }
}
if (empty($error)){
    $_SESSION['join'] = $_POST;
    header('Location: com_register.php');
    exit();
}
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>registerform</title>
    <link rel="stylesheet" href="registerform.css">
</head>
<body>
    <div class="registerform">
    <h1>REGISTER FORM</h1>
    <form action="" method="post">
        <div class="box">
        <p>
            <input type="text" name="username" id="username" placeholder="USERNAME" 
            value="<?php print(htmlspecialchars($_POST['username'],ENT_QUOTES)); ?>" >
        </p>
        <?php if ($error['username'] === 'blank'): ?>
        <p>名前が未入力です</p>
        <?php endif; ?>
        </div>
        <div class="box">
        <p>
            <input type="email" name="email" id="email" placeholder="EMAIL ADDLESS"
            value="<?php print(htmlspecialchars($_POST['email'],ENT_QUOTES)); ?>" >
        </p>
        <?php if ($error['email'] === 'blank'): ?>
        <p>メールアドレスが未入力です</p>
        <?php endif; ?>
        <?php if ($error['email'] === 'duplicate'): ?>
        <p>登録済みのメールアドレスです</p>
        <?php endif; ?>
        </div>
        <div class="box">
        <p>
            <input type="password" name="password_1" id="password" placeholder="PASSWORD">
        </p>
        <?php if ($error['password_1'] === 'blank'): ?>
        <p>パスワードが未入力です</p>
        <?php endif; ?>
        <?php if (empty($error['password_1'] === 'blank') && $error['password_1'] === 'length'): ?>
        <p>4文字以上で入力してください</p>
        <?php endif; ?>
        </div>
        <div class="box">
        <p>
            <input type="password" name="password_2" id="password" placeholder="CONFIRM PASSWORD">
        </p>
        <?php if ($error['password'] === 'nmatch'): ?>
        <p>パスワードが一致しません</p>
        <?php endif; ?>
        </div>
        <div class="box">
        <p>
            <input type="submit" value="REGISTER">
        </p>
        </div>
    </form>
    </div>
</body>
</html>