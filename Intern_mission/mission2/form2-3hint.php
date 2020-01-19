<!DOCTYPE html>
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
<form action="form2-3hint.php" method="get">
	<!-- フォーム作成 form2-3hint.phpに送信 -->
	名前:<br/>\

	<input type="text" name="name" size="10"><br/>
	コメント:<br/>
	<input type="text" name="comment"/><br/>
	<input type="submit" value="送信"/><br/>
</form>
<h1>みんなのコメント</h1><br/>
<?php

if (フォームの入力内容があるかどうか) {
//フォームにきちんと文字が入力されていれば書き込みに入るようにしてください

	//書き込みフェーズ
	$filename = "好きなファイル名.txt";
	$fp = fopen($filename,'a');

	//ここで投稿番号と日時の取得をしてください

	//ここで一通りのコメント(番号<>名前<>コメント<>日時<>改行)をfwriteしてください

	fclose($fp);
}

	//書き込みが済んだので表示に入りましょう

	//テキストを配列に読み込んでください
	$a = ????($????????);

	foreach($a as $b) {
		foreach (???????('<>', $?) as $c) {
			echo $c.'  ';
			echo "<br>";
		}
	}
?>

<body/>
</html>
