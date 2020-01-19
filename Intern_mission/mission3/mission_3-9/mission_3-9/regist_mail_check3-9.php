<?php
session_start();

header("Content-type: text/html; charset=utf-8");

//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] != $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}

//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

//MySQLへの接続
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//////////*-----START HERE DOC-----*/
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS pre_member (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
urltoken VARCHAR(128) NOT NULL,
mail VARCHAR(50) NOT NULL,
date DATETIME NOT NULL,
flag bit(1) NOT NULL DEFAULT 0
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
}else{
	//POSTされたデータを変数に入れる
	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;

	//メール入力判定
	if ($mail == ''){
		$errors['mail'] = "メールが入力されていません。";
	}else{
		if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			$errors['mail_check'] = "メールアドレスの形式が正しくありません。";
		}

		/*
		ここで本登録用のmemberテーブルにすでに登録されているmailかどうかをチェックする。
		$errors['member_check'] = "このメールアドレスはすでに利用されております。";
		*/
	}
}

if (count($errors) === 0){

	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "http://co-622.it.99sv-coco.com/mission_3-9/regist_form3-9.php"."?urltoken=".$urltoken;

	//ここでデータベースに登録する
	try{
		$stmt = $pdo->prepare("INSERT INTO pre_member (urltoken,mail,date) VALUES (:urltoken,:mail,now() )");

		//プレースホルダへ実際の値を設定する
		$stmt->bindValue(':urltoken', $urltoken, PDO::PARAM_STR);
		$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
		$stmt->execute();

		//データベース接続切断
		$dbh = null;

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	//メールの宛先
	$mailTo = $mail;

	//Return-Pathに指定するメールアドレス
	$returnMail = 'web@sample.com';

	$name = "あきばのけいじばん";
	$mail = 'web@sample.com';
	$subject = "会員登録用URLのお知らせ";
	//////////*-----START HERE DOC-----*/
$body = <<< EOM
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;
	//////////*------END HERE DOC------*/
	mb_language('ja');
	mb_internal_encoding('UTF-8');

	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';

	if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {

	 	//セッション変数を全て解除
		$_SESSION = array();

		//クッキーの削除
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time() - 1800, '/');
		}

 		//セッションを破棄する
 		session_destroy();

 		$message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";

	 } else {
		$errors['mail_error'] = "メールの送信に失敗しました。";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>メール確認画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>メール確認画面</h1>

<?php if (count($errors) === 0): ?>

<p><?=$message?></p>

<p>↓このURLが記載されたメールが届きます。</p>
<a href="<?=$url?>"><?=$url?></a>

<?php elseif(count($errors) > 0): ?>

<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>

<input type="button" value="戻る" onClick="history.back()">

<?php endif; ?>

</body>
</html>