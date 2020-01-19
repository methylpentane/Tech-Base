<?php
	// 変数インクルードてきな
	$tablename = 'komento';
	$delNumber = $_POST['delNumber'];
	$int_delNumber = (int)$delNumber;
	// MySQL接続
	$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
	$db_user = 'co-622.it.3919.c';
	$db_pass = 'Mvju89CY4';
	try{
		$pdo = new PDO($db_info,$db_user,$db_pass);
	}catch(PDOException $e){
		exit('データベース接続失敗。'.$e->getMessage());
	}
	//パスワード認証
	$sql = "SELECT password FROM $tablename WHERE id = $delNumber";
	$pass = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
		//→ array(1) { ["password"]=> string(4) "2236" }
	$check = ($pass['password'] === $_POST['password']) ? true : false;
		//→ bool(true or false)


	//実行
	if($check === true){
		$sql = "UPDATE $tablename SET name = '', comment = '-=削除=-', date = '' WHERE id = $delNumber";
		$stmt = $pdo->query($sql);
		if($stmt){
			echo '削除しました<br><a href=http://co-622.it.99sv-coco.com/mission_2-15/main_form2-15.php>メインフォームにもどる<a/>';
		}else echo "削除失敗ー";
	}else{
		if($check === false) echo 'パスワードが違うか、番号が適正ではありません。';
	}
?>