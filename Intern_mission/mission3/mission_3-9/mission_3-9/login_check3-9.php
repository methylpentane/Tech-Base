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

//データベース接続
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(PDOException $e){
	exit('データベース接続失敗'.$e->getMessage());
}

//前後にある半角全角スペースを削除する関数
function spaceTrim ($str) {
	// 行頭
	$str = preg_replace('/^[ ]+/u', '', $str);
	// 末尾
	$str = preg_replace('/[ ]+$/u', '', $str);
	return $str;
}

//phpが5.2.4なのでcryptでhash_verify
function password_verify_by_crypt($str, $str_hash) {
	if(crypt($str,$str_hash) === $str_hash){
		return true;
	}else{
		return false;
	}
}

//エラーメッセージの初期化
$errors = array();

if(empty($_POST)) {
	header("Location: login_form3-9.php");
	exit();
}else{
	//POSTされたデータを各変数に入れる
	$account = isset($_POST['account']) ? $_POST['account'] : NULL;
	$password = isset($_POST['password']) ? $_POST['password'] : NULL;

	//前後にある半角全角スペースを削除
	$account = spaceTrim($account);
	$password = spaceTrim($password);

	//アカウント入力判定
	if ($account == ''):
		$errors['account'] = "アカウントが入力されていません。";
	elseif(mb_strlen($account)>10):
		$errors['account_length'] = "アカウントは10文字以内で入力して下さい。";
	endif;

	//パスワード入力判定
	if ($password == ''):
		$errors['password'] = "パスワードが入力されていません。";
	elseif(!preg_match('/^[0-9a-zA-Z]{5,30}$/', $_POST["password"])):
		$errors['password_length'] = "パスワードは半角英数字の5文字以上30文字以下で入力して下さい。";
	else:
		$password_hide = str_repeat('*', strlen($password));
	endif;

}

//エラーが無ければ実行する
if(count($errors) === 0){
	try{
		//例外処理を投げる（スロー）ようにする
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//アカウントで検索
		$statement = $pdo->prepare("SELECT * FROM member WHERE account=(:account) AND flag =1");
		$statement->bindValue(':account', $account, PDO::PARAM_STR);
		$statement->execute();

		//アカウントが一致
		if($row = $statement->fetch()){

			$password_hash = $row[password];

			//パスワードが一致
			if (password_verify_by_crypt($password, $password_hash)) {

				//セッションハイジャック対策
				session_regenerate_id(true);

				$_SESSION['account'] = $account;
				header("Location: main_form3-9.php");
				exit();
			}else{
				$errors['password'] = "アカウント及びパスワードが一致しません。";
			}
		}else{
			$errors['account'] = "アカウント及びパスワードが一致しません。";
		}

		//データベース接続切断
		$pdo = null;

	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>ログイン確認画面</title>
<meta charset="utf-8">
</head>
<body>
<h1>ログイン確認画面</h1>

<?php if(count($errors) > 0): ?>

<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>

<input type="button" value="戻る" onClick="history.back()">

<?php endif; ?>

</body>
</html>