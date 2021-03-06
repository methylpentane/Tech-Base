<!DOCTYPE html>
<!-- 入力フォーム→受け取ったときに条件分岐して処理→表示 -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- 文字コードをUTF-8にセット -->
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<!-- キャッシュ強制消去 -->
	<title>コメント置き場</title>
</head>
<body>
<h1>コメント置き場</h1>
更新はフォームをカラにしてからF5でどうぞ<br/>
登録がまだの人→
<a href = http://co-622.it.99sv-coco.com/mission_3-6/regist_form3-6.html>登録フォーム</a><br/>
<form action="main_form3-6.php" method="post">
	<!-- フォーム作成 main_form3-6.phpに送信 -->
	名前:<br/>
	<input type="text" name="name" size="10"/><br/>
	コメント:<br/>
	<input type="text" name="comment"/><br/>
	パスワード(半角英数字8文字)<br/>
	<input type="password" name="password" size="10"/><br/>
	<input type="submit" value="送信"/><br/>
</form>

<?php
//フォーム入力済み判定の発行と表示
	if($_POST["name"] && $_POST["comment"] && $_POST["password"]){
		$formIsFilled = true;//この変数を書き込み分岐のために発行
	}else{
		$formIsFilled = false;
		echo "すべて入力してください！<br/>";
	}
?>

<a href = http://co-622.it.99sv-coco.com/mission_3-6/delete_form3-6.html>削除フォーム</a><br/>
<a href = http://co-622.it.99sv-coco.com/mission_3-6/edit_form3-6.html>編集フォーム</a><br/>
<h1>みんなのコメント</h1><br/>


<?php
/***************************************************

------------------Initialization--------------------

****************************************************/
//MySQLへの接続
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass);
}catch(PDOException $e){
	exit('データベース接続失敗。'.$e->getMessage());
}

//テーブルが存在しないときは作成して初期化を行う
$tablename = 'komento';
//////////*----START HERE DOC----*/
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS $tablename (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
name VARCHAR(32),
comment VARCHAR(100),
date VARCHAR(50),
password CHAR(8),
PRIMARY KEY(id)
)
EOD
;
//////////*-----END HERE DOC-----*/
$chk = $pdo->query($sql);
if(!$chk) echo 'テーブル作成エラー<br>';



/***************************************************

                COMMENT INSERT PHASE

****************************************************/
if ($formIsFilled) {
	//////////*-----START HERE DOC-----*/
$sql = <<<EOD
INSERT INTO $tablename (
name,comment,date,password
) VALUES (
:name,:comment,:date,:password
)
EOD
;
	//////////*------END HERE DOC------*/
	$nowDate = "";
	$stmt = $pdo->prepare($sql);
	if(!$stmt) echo "準備だめ<br>";
	$stmt->bindValue(':name',$_POST["name"]);
	$stmt->bindValue(':comment',$_POST["comment"]);
	$stmt->bindParam(':date',$nowDate);
	$stmt->bindValue(':password',$_POST["password"]);
	//コメント数と日時の取得
	$nowDate = date('Y/m/d G:i:s');

	$stmt->execute();
	if(!$stmt) echo "挿入だめ<br>";
}//end if
$_POST = array();


/***************************************************

                 COMMENT SHOW PHASE

****************************************************/
//////////*-----START HERE DOC-----*/
$sql = <<<EOD
SELECT * FROM $tablename ORDER BY id
EOD
;
//////////*------END HERE DOC------*/
$result = $pdo->query($sql);
foreach ($result as $comment) {
	echo $comment['id'].' ';
	echo $comment['name'].' ';
	echo $comment['comment'].' ';
	echo $comment['date'].' ';
	echo $comment['password'];
	echo "<br>";
}

?>

</body>
</html>
