<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策
$_SESSION['token'] = base64_encode(md5(uniqid(rand(), true)));
$token = $_SESSION['token'];

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//データベース接続
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(PDOException $e){
	exit('データベース接続失敗'.$e->getMessage());
}

//エラーメッセージの初期化
$errors = array();

if(empty($_GET)) {
	header("Location: regist_mail_form3-10.php");
	exit();
}else{
	//GETデータを変数に入れる
	$urltoken = isset($_GET[urltoken]) ? $_GET[urltoken] : NULL;
	//メール入力判定
	if ($urltoken == ''){
		$errors['urltoken'] = "もう一度登録をやりなおして下さい。";
	}else{
		try{

			//flagが0の未登録者・仮登録日から24時間以内
			$statement = $pdo->prepare("SELECT mail FROM pre_member WHERE urltoken=(:urltoken) AND flag =0 AND date > now() - interval 24 hour");
			$statement->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
			$statement->execute();

			//レコード件数取得
			$row_count = $statement->rowCount();

			//24時間以内に仮登録され、本登録されていないトークンの場合
			if( $row_count ==1){
				$mail_array = $statement->fetch();
				$mail = $mail_array[mail];
				$_SESSION['mail'] = $mail;
			}else{
				$errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
			}

			//データベース接続切断
			$pdo = null;

		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>会員登録画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>会員登録画面</h1>

<?php if (count($errors) === 0): ?>

<form action="regist_check3-10.php" method="post">

<p>メールアドレス：<?=htmlspecialchars($mail, ENT_QUOTES, 'UTF-8')?></p>
<p>アカウント名：<input type="text" name="account"></p>
<p>パスワード：<input type="text" name="password"></p>

<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="確認する">

</form>

<?php elseif(count($errors) > 0): ?>

<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>

<?php endif; ?>

</body>
</html>