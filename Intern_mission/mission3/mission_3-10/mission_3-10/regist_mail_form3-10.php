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
<title>メール登録画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>メール登録画面</h1>

<form action="regist_mail_check3-10.php" method="post">

<p>メールアドレス：<input type="text" name="mail" size="50"></p>

<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="登録する">

</form>

</body>
</html>