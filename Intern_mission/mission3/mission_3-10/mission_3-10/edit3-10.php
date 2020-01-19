<?php
	//変数インクルードてきな
	$tablename = 'komento';
	$editNumber = $_POST['editNumber'];
	$int_editNumber = (int)$editNumber;
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
	$sql = "SELECT password FROM $tablename WHERE id = $editNumber";
	$pass = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
		//→ array(1) { ["password"]=> string(4) "2236" }
	$check = ($pass['password'] === $_POST['password']) ? true : false;
		//→ bool(true or false)

	if($check === true){
		$sql = "UPDATE $tablename SET name = :name, comment = :comment WHERE id = $editNumber";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':name',$_POST['name']);
		$stmt->bindValue(':comment',$_POST['comment']);
		$stmt->execute();
		if($stmt){
			echo '編集しました<br><a href=http://co-622.it.99sv-coco.com/mission_3-10/main_form3-10.php>メインフォームにもどる<a/>';
		}else echo "編集だめー";
	}else{
		if($check === false) echo 'パスワードが違うか、番号が適正ではありません。';
	}
?>