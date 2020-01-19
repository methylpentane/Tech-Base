<?php
session_start();

//フォーム入力済み判定の発行と表示
	if($_POST["userid"] && $_POST["password"]){
		$formIsFilled = true;//この変数を書き込み分岐のために発行
	}else{
		$formIsFilled = false;
	}

//MySQLからユーザーを確認
	if($formIsFilled){
		$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
		$db_user = 'co-622.it.3919.c';
		$db_pass = 'Mvju89CY4';
		try{
			$pdo = new PDO($db_info,$db_user,$db_pass);
		}catch(PDOException $e){
			exit('データベース接続失敗。'.$e->getMessage());
		}

		$tablename = 'users';
		$userid = $_POST['userid'];
		$password = $_POST['password'];
		$sql = 'SELECT * FROM users WHERE userid = :userid';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':userid',$userid);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($password === $result['password']){
			$_SESSION['name']=$result['name'];
			$_SESSION['login']='1';
			header("Location:http://co-622.it.99sv-coco.com/mission_3-7/main_form3-7.php");
			exit;
		}else{
			echo "ちがいます";
		}
	}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="login form">
        <title>ログイン</title>
    </head>
    <body>
    	<h3>ログインしやがれ</h3>
    	<form action="login3-7.php" method="post">
			ID:<br/>
			<input type="text" name="userid" size="10"/><br/>
			パスワード(半角英数字8文字)<br/>
			<input type="password" name="password" size="10"/><br/>
			<input type="submit" value="ログイン"/><br/>
		</form>
		<?php if(!$formIsFilled){ ?>
			すべて入力してください<br>
		<?php } ?>
		<a href = http://co-622.it.99sv-coco.com/mission_3-7/regist_form3-7.html>登録フォーム</a><br/>
    </body>
</html>