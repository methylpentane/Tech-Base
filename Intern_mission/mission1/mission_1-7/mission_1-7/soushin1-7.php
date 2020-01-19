<?php
header("Content-Type:text/html; charset=UTF-8");

	$filename = 'hitokoto.txt';
	$fp = fopen($filename,'a');
	fwrite($fp,$_GET['name'].': '.$_GET['hitokoto']."\n");
	fclose($fp);
	// 1-6の流用!!

	$commentArray = file($filename);
	// fileは指定ファイルを、一行ずつ配列に格納します。末尾の改行文字\nも一緒に入ります←重要
	foreach($commentArray as $comment) { //繰り返しです。forでも良いです
		echo nl2br($comment);
		// nl2brは文字列中の\nのある場所に<br>を挿入する関数です
		// fwriteにおいて\nが書き込み済みですので、この場所に勝手に<br>が挿入されています。
		// 改行文字を含んだテキストをHTML上で表示するのに便利

		//$comment == "名前: コメント\n"
		//nl2br($comment) == "名前: コメント<br>\n"
	}

?>
