<!-- 2-1では使わない これは2-2用のphp(間違えて上書きしちった) -->
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<?php
header("Content-Type:text/html; charset=UTF-8");
	//echo $_GET['hitokoto']; //debug
	$filename = 'komento.txt';

	$fp = fopen($filename,'a');

	$commentCount = 1 + count(file($filename));
	$nowDate = date('Y/m/d G:i:s');
	//コメント数と日時の取得

	fwrite($fp,$commentCount.'<>'.$_GET['name'].'<>'.$_GET['comment'].'<>'.$nowDate."\n");
	//いまはそのまま書き込むことにする
	//けど、.txtにおいて文字コード指定にはできないのでブラウザ側で
	//UTF-8に指定する必要あり

	if(fclose($fp) == false) {
		echo "error occured in fclose()";
	}

	$commentArray = file($filename);//配列に読み込んでいる
	foreach($commentArray as $comment) {
		echo $comment;
		echo "<br/>";//いまは改行をhtmlタグで出力している,nl2blとかもまあ行けるでしょう
	}
?>
