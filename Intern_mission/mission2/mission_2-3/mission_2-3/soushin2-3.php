<!-- なんかキャッシュ消去のmetaに必要性を感じないのでいいや -->
<!-- このコードもあくまで部品なので使わない -->
<?php
header("Content-Type:text/html; charset=UTF-8");

	$filename = 'komento.txt';

	$fp = fopen($filename,'a');

	$commentCount = 1 + count(file($filename));
	$nowDate = date('Y/m/d G:i:s');
	//コメント数と日時の取得

	fwrite($fp,$commentCount.'<>'.$_GET['name'].'<>'.$_GET['comment'].'<>'.$nowDate."\n");

	if(fclose($fp) == false) {
		echo "error occured in fclose()";
	}

	$commentArray = file($filename);//配列に読み込んでいる
	foreach($commentArray as $comment) {
		foreach (explode('<>', $comment) as $commentFeature) {
			echo $commentFeature.'  ';
		}
		echo nl2br("\n");//いまは改行をhtmlタグで出力している,nl2blとかもまあ行けるでしょう
	}
?>
