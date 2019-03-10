<?php
require('dbconnect.php');
session_start();

if (!isset($_SESSION['join'])) {
    header('Location: registerform.php');
    exit();
}

if (!empty($_SESSION['join'])){
    $statement = $db->prepare('INSERT INTO members SET name=?, email=?,
    password=?, created=NOW()');
    $statement->execute(array(
    $_SESSION['join']['username'],
    $_SESSION['join']['email'],
    password_hash($_SESSION['join']['password_1'], PASSWORD_DEFAULT)
    ));
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>register</title>
    <link rel="stylesheet" href="com_register.css">
</head>
<body>
    <div class="box">
    <h1>Complete Register !</h1>
    <h2>Welcome <?php print(htmlspecialchars($_SESSION['join']['username'],
    ENT_QUOTES)); ?></h2>
    <?php unset($_SESSION['join']); ?>
    <button type="button" name="button" onclick="location.href='loginform.php'">
    LOGIN FORM
    </button>
    </div>
    </form>
</body>
</html>