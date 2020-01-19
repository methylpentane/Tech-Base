<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(md5(uniqid(rand(), true)));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

?>

<!DOCTYPE html>
<html>
<head>
<title>ログイン画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>ログイン画面</h1>
<a href="http://co-622.it.99sv-coco.com/mission_3-10/regist_mail_form3-10.php">ログインしてない人は登録画面へ</a>

<form action="login_check3-10.php" method="post">

<p>アカウント：<input type="text" name="account" size="50"></p>
<p>パスワード：<input type="text" name="password" size="50"></p>

<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="ログインする">

</form>

</body>
</html>