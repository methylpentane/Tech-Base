<?php
/***************入力があるかの確認***************/
$formIsFilled  = ($_POST['username'] and $_POST['password'])  ? true : false;
$passIsCollect = ($_POST['password'] === $_POST['password2']) ? true : false;

if( !$formIsFilled or !$passIsCollect ){
	echo "空欄があるか、パスワードが確認できません。やり直してください。<br/>";
	echo "<a href=http://co-622.it.99sv-coco.com/mission_3-7/regist_form3-7.html>登録フォームにもどる<a/>";
}else{
/***************MySQLに保存の巻*****************/

	$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
	$db_user = 'co-622.it.3919.c';
	$db_pass = 'Mvju89CY4';
	try{
		$pdo = new PDO($db_info,$db_user,$db_pass);
	}catch(PDOException $e){
		exit('データベース接続失敗。'.$e->getMessage());
	}

	$tablename = 'users';
	//////////*-----START HERE DOC-----*/
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS $tablename (
userid CHAR(8),
name VARCHAR(32),
password VARCHAR(8),
PRIMARY KEY(userid)
)
EOD
;
//////////*------END HERE DOC------*/
	$chk = $pdo->query($sql);
	if(!$chk) echo "テーブル作成エラー<br>";

	/******************ユーザー情報書き込みの巻****************/

	//////////*-----START HERE DOC-----*/
$sql = <<<EOD
INSERT INTO $tablename (
userid,name,password
) VALUES (
:userid,:name,:password
)
EOD
;
	//////////*------END HERE DOC------*/
	$idnum = $pdo->query("SELECT COUNT(*) FROM $tablename")->fetch(PDO::FETCH_ASSOC);
	// var_dump($idnum);
	$intidnum = (int)$idnum['COUNT(*)'];
	// var_dump($intidnum);
	$id = 'IESO'.sprintf("%04d",$intidnum);
	// var_dump($id);
	$stmt = $pdo->prepare($sql);
	if(!$stmt) echo "準備だめ<br/>";
	$stmt->bindValue(':userid',$id);
	$stmt->bindValue(':name',$_POST['username']);
	$stmt->bindValue(':password',$_POST['password']);
	$stmt->execute();
	if(!stmt) echo "ユーザー作成だめ<br/>";

	echo "ユーザーを作成しました<br/>";
	echo "名前:{$_POST['username']}<br/>";
	echo "ID:$id<br>";
	echo "パスワード:********";
}//end if(line 6)
?>