<?php
/******************************************
************login(session)check************
******************************************/
session_start();
if(!isset($_SESSION['account'])){
	header("Location:http://co-622.it.99sv-coco.com/mission_3-10/login_form3-10.php");
	exit();
}else{
	$name = $_SESSION['account'];
}
?>

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
<form action="main_form3-10.php" method="post" enctype="multipart/form-data">
	<!-- フォーム作成 main_form3-10.phpに送信 -->
	*名前:<br/>
	<input type="text" name="name" value="<?=$name?>" size="10" required/><br/>
	*コメント:<br/>
	<input type="text" name="comment" required/><br/>
	画像/動画(動画はmp4のみにしといて)のパス<br/>
	<input type="hidden" name="MAX_FILE_SIZE" value="16000000">
	<input type="file" name="content"><br/>
	*パスワード(半角英数字8文字)<br/>
	<input type="password" name="password" size="10" required/><br/>
	<input type="submit" value="送信"/><br/>
</form>

<?php
//フォーム入力済み判定の発行と表示
	if($_POST["name"] && $_POST["comment"] && $_POST["password"]){
		$formIsFilled = true;//この変数を書き込み分岐のために発行
	}else{
		$formIsFilled = false;
		echo "*印の項目は必須です<br/>";
	}
?>

<a href = http://co-622.it.99sv-coco.com/mission_3-10/delete_form3-10.html>削除フォーム</a><br/>
<a href = http://co-622.it.99sv-coco.com/mission_3-10/edit_form3-10.html>編集フォーム</a><br/>
<a href = http://co-622.it.99sv-coco.com/mission_3-10/logout3-10.php>ログアウト</a><br/>
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
$tablename = 'comments';
$tablename2 = 'contents';
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
if(!$chk) echo "table dame 1";
//////////*-----START HERE DOC-----*/
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS $tablename2 (
id_at INT UNSIGNED NOT NULL,
content MEDIUMBLOB,
extension VARCHAR(64)
)
EOD
;
//////////*------END HERE DOC------*/
$chk = $pdo->query($sql);
if(!$chk) echo "table dame 2";




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

	if($_FILES['content']['tmp_name']){
		// var_dump($_FILES['content']['tmp_name']);
		$sql = "SELECT COUNT(*) FROM $tablename";
		$stmt = $pdo->query($sql);
		$id_at = $stmt->fetch(PDO::FETCH_ASSOC);
		$extension = pathinfo($_FILES['content']['name'],PATHINFO_EXTENSION);
		$content = file_get_contents($_FILES['content']['tmp_name']);
		// var_dump($id_at['COUNT(*)']);
		// var_dump($extension);
		//////////*-----START HERE DOC-----*/
$sql = <<<EOD
INSERT INTO $tablename2 (
id_at,content,extension
) VALUES (
:id_at,:content,:extension
)
EOD
;
		//////////*------END HERE DOC------*/
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(":id_at",$id_at['COUNT(*)']);
		$stmt->bindValue(":content",$content);
		$stmt->bindValue(":extension",$extension);
		$stmt->execute();
		if(!$stmt) echo "file insert dame";
	}
}//end if
$_POST = array();


/***************************************************

                 COMMENT SHOW PHASE

****************************************************/
$imgMIMETypes = array(
   'png'  => 'image/png',
   'jpg'  => 'image/jpeg',
   'jpeg' => 'image/jpeg',
   'gif'  => 'image/gif',
   'bmp'  => 'image/bmp',
);
$vidMIMETypes = array(
   'mp4'  => 'video/mp4',
   'webm' => 'video/webm'
);
//google chromeでmp4が音声だけになっちゃう～

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

	//////////*-----START HERE DOC-----*/
$sql = <<<EOD
SELECT id_at,extension FROM $tablename2 WHERE id_at = {$comment['id']}
EOD
;
	//////////*------END HERE DOC------*/
	$stmt = $pdo->query($sql);
	if(!$stmt) echo 'dame';
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	// var_dump($result);
	if($result){
		?>
		<figure>
			<?php
				if(array_key_exists($result['extension'], $imgMIMETypes)){
					$mime = $imgMIMETypes[$result['extension']];
					// var_dump($mime);
					echo '<img src="contentshow3-10.php?mime='.$mime.'&id='.$result['id_at'].'"/>';
				}else if(array_key_exists($result['extension'], $vidMIMETypes)){
					$mime = $vidMIMETypes[$result['extension']];
					// var_dump($mime);
					echo '<video controls><source src="contentshow3-10.php?mime='.$mime.'&id='.$result['id_at'].'"/></video>';
				}
			?>
		</figure>
		<br/>
	<?php
	}
}
?>
</body>
</html>
