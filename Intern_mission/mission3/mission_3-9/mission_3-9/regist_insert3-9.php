<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}

//クリックジャッキング対策、初期化
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//////////*-----START HERE DOC-----*/
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS member (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
account VARCHAR(50) NOT NULL,
mail VARCHAR(50) NOT NULL,
password VARCHAR(128) NOT NULL,
flag bit(1) NOT NULL DEFAULT 1
)
EOD
;
	//////////*------END HERE DOC------*/
	$stmt = $pdo->query($sql);
}catch(PDOException $e){
	exit('データベース接続およびテーブル初期化失敗'.$e->getMessage());
}

//エラーメッセージの初期化
$errors = array();

if(empty($_POST)) {
	header("Location: regist_mail_form3-9.php");
	exit();
}

$mail = $_SESSION['mail'];
$account = $_SESSION['account'];

//パスワードのハッシュ化(IESOサーバーは5.2.4なのでcryptをつかう)
// $password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);
$salt = '$2a$10$';
for ($i = 0; $i < 22; $i++) {
    $salt = $salt.substr('./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', mt_rand(0, 63), 1);
}
$salt = $salt.'$';
$password_hash = crypt($_SESSION['password'], $salt);

//ここでデータベースに登録する
try{

	//トランザクション開始
	$pdo->beginTransaction();

	//memberテーブルに本登録する
	$statement = $pdo->prepare("INSERT INTO member (account,mail,password) VALUES (:account,:mail,:password_hash)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':account', $account, PDO::PARAM_STR);
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
	$statement->execute();

	//pre_memberのflagを1にする
	$statement = $pdo->prepare("UPDATE pre_member SET flag=1 WHERE mail=(:mail)");
	//プレースホルダへ実際の値を設定する
	$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
	$statement->execute();

	// トランザクション完了（コミット）
	$pdo->commit();

	//データベース接続切断
	$pdo = null;

	//セッション変数を全て解除
	$_SESSION = array();

	//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
	if (isset($_COOKIE["PHPSESSID"])) {
    		setcookie("PHPSESSID", '', time() - 1800, '/');
	}

 	//セッションを破棄する
 	session_destroy();

 	/*
 	登録完了のメールを送信
 	*/

}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$pdo->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
}

?>

<!DOCTYPE html>
<html>
<head>
<title>会員登録完了画面</title>
<meta charset="utf-8">
</head>
<body>

<?php if (count($errors) === 0): ?>
<h1>会員登録完了画面</h1>

<p>登録完了いたしました。ログイン画面からどうぞ。</p>
<p><a href="http://co-622.it.99sv-coco.com/mission_3-9/login_form3-9.php">ログイン画面</a></p>

<?php elseif(count($errors) > 0): ?>

<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>

<?php endif; ?>

</body>
</html>