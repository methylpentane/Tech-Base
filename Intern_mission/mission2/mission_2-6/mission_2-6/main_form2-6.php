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
--仕様--<br>
メインは1-7とほぼ同じで、パスワードを追加し、編集削除を別ページで実装している。<br>
今後、hiddenや複数フォームを使った操作性の向上を図る。<br>
--以下フォーム--<br>
<h1>コメント置き場</h1>
<a href = http://co-622.it.99sv-coco.com/mission_2-6/main_form2-6.php>コメントを現在の状態に更新</a>
<br/>
<form action="main_form2-6.php" method="post">
	<!-- フォーム作成 main_form2-6.phpに送信 -->
	名前:<br/>
	<input type="text" name="name" size="10"/><br/>
	コメント:<br/>
	<input type="text" name="comment"/><br/>
	パスワード<br/>
	<input type="password" name="password" size="10"/><br/>
	<input type="submit" value="送信"/><br/>
</form>

<?php
//フォーム入力済みですか？？
	if($_POST["name"] && $_POST["comment"] && $_POST["password"]){
		$formIsFilled = true;
	}else{
		$formIsFilled = false;
		echo "すべて入力してください！<br/>";
	}
?>

<a href = http://co-622.it.99sv-coco.com/mission_2-6/delete_form2-6.html>削除フォーム</a><br/>
<a href = http://co-622.it.99sv-coco.com/mission_2-6/edit_form2-6.html>編集フォーム</a><br/>
<h1>みんなのコメント</h1><br/>

<?php
$filename = 'komento.txt';

if (!file_exists($filename)) file_put_contents($filename, '');
//ファイルが存在しないときは作成して初期化を行う

if ($formIsFilled) {
//フォームにきちんと文字が入力されていれば書き込みフェーズ

	//書き込みフェーズ
	$fp = fopen($filename,'a');

	$commentCount = 1 + count(file($filename));
	$nowDate = date('Y/m/d G:i:s');
	//コメント数と日時の取得

	fwrite($fp,$commentCount.'<>'.$_POST['name'].'<>'.$_POST['comment'].'<>'.$nowDate.'<>'.$_POST['password'].'<>'."\n");

	if(fclose($fp) == false) {
		echo "error occured in fclose()";
	}
}

$_POST = array();

	//表示フェーズ
	$commentArray = file($filename);//配列に読み込んでいる
	if(!$commentArray) echo 'コメントはまだ無いよ';
	foreach($commentArray as $comment) {
		foreach (explode('<>', $comment) as $featureKey => $commentFeature) {
			if($featureKey === 4) continue;
			echo $commentFeature.'  ';
		}
		echo "<br/>";
	}
?>
<body/>
</html>
