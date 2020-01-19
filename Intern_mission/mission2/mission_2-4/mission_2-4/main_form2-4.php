<!DOCTYPE html>
<!-- 入力フォーム→受け取ったときに条件分岐して処理→表示 -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- 文字コードをUTF-8にセット -->
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<!-- キャッシュ強制消去 -->
	<title>コメント置き場</title>
</head>
<body>
<h1>コメント置き場</h1>
掲示板を最新の状態にするにはコメントボックスを空にして更新<br>
<form action="main_form2-4.php" method="post">
	<!-- フォーム作成 main_form2-4.phpに送信 -->
	名前:<br/>

	<input type="text" name="name" size="10"><br/>
	コメント:<br/>
	<input type="text" name="comment"/><br/>
	<input type="submit" value="送信"/><br/>
</form>
<a href = http://co-622.it.99sv-coco.com/mission_2-4/delete_form2-4.html>削除フォーム</a><br/>
<h1>みんなのコメント</h1><br/>
<?php
$filename = 'komento.txt';

if (!file_exists($filename)) file_put_contents($filename, '');
//ファイルが存在しないときは作成して初期化を行う

if ($_POST["name"] && $_POST["comment"]) {
//フォームにきちんと文字が入力されていれば書き込みフェーズ

	//書き込みフェーズ
	$fp = fopen($filename,'a');

	$commentCount = 1 + count(file($filename));
	$nowDate = date('Y/m/d G:i:s');
	//コメント数と日時の取得

	fwrite($fp,$commentCount.'<>'.$_POST['name'].'<>'.$_POST['comment'].'<>'.$nowDate."\n");

	if(fclose($fp) == false) {
		echo "error occured in fclose()";
	}
}//end if
$_POST = array();

	//表示フェーズ
	$commentArray = file($filename);//配列に読み込んでいる
	if(!$commentArray) echo 'コメントはまだ無いよ';
	foreach($commentArray as $comment) {
		foreach (explode('<>', $comment) as $commentFeature) {
			echo $commentFeature.'  ';
		}
		echo "<br>";
	}
?>
<body/>
</html>
